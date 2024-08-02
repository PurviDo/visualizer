<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class UserPackages extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'package_id',
        'purchase_date',
        'credit',
    ];
}
