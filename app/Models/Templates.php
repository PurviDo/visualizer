<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_type',
        'name',
        'description',
        'instructions',
        'category_id',
        'sub_category_id',
        'status',
        'no_of_files',
        'user_id'
    ];
}
