<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'email', 'phone','address','map_url'];
}
