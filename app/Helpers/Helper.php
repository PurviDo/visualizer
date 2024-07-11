<?php

namespace App\Helpers;

use App\User;
use Auth;

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


  protected function sendValidationErrors($errors)
  {
      foreach ($errors->all() as $error) {
          return response()->json(['error' => $error], 400);
      }
  }
}
