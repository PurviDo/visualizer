<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number' ,'message'];
}
