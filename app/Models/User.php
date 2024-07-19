<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Model; 
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'mobile_no', 'password', 'purchased_credit', 'package_id', 'otp', 'access_token', 'device_token', 'updated_at', 'deleted_at', 'user_type', 'is_active', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public static function getUserByEmail($email)
    {
        return User::where('email', $email)->where('user_type', 0)->first();
    }

    public static function updateUserOtp($email, $otp)
    {
        $updateOtp = User::getUserByEmail($email);
        $updateOtp->update(['otp' => $otp]);
        return $updateOtp;
    }
}
