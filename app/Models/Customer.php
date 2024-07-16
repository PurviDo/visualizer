<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name', 'last_name', 'email', 'mobile_no', 'password', 'purchased_credit', 'package_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
