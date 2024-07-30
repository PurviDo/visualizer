<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['content','title'];

}
