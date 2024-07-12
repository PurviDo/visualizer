<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'duration',
        'description',
        'credits',
        'actual_price',
        'discounted_price',
        'status',
    ];
}
