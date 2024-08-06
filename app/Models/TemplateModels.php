<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateModels extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'model_type',
        'background_image',
        'foreground_image',
        'shadow_image',
        'highlight_image',
        'status',
        'preview_image'
    ];
}
