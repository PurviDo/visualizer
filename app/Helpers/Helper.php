<?php

namespace App\Helpers;

use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Helper {

    public static function instance() {
        return new Helper();
    }

    protected function responseJSON($apiResponseArray)
    {
        $result = $this->encodeJson($apiResponseArray);
        return $result;
    }

    /**
     * Encode a value to camelCase JSON
     */
    private function encodeJson($value)
    {
        if ($value instanceof Arrayable) {
            return $this->encodeJson($value->toArray());
        } else if (is_array($value)) {
            return $this->encodeArray($value);
        } else if (is_object($value)) {
            return $this->encodeArray((array) $value);
        } else {
            return $value;
        }
    }

    private function encodeArray($array)
    {
        $newArray = [];
        foreach ($array as $key => $val) {
            $newArray[Str::camel($key)] = $this->encodeJson($val);
        }
        return $newArray;
    }

    public static function createToken()
    {
        // Set the token to expire in 2 days
        $expiresAt = Carbon::now()->addDays(2);

        $plainTextToken = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = Str::random(40),
            hash('crc32b', $tokenEntropy)
        );

        $token = [
            'name' => 'VisualizerAdminToken',
            'token' => hash('sha256', $plainTextToken),
            'expires_at' => $expiresAt,
        ];

        // return [$token, $plainTextToken];
        return $plainTextToken;
    }
}
