<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class TemplateModels extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_id',
        'background_image',
        'foreground_image',
        'shadow_image',
        'highlight_image',
        'preview_image',
        'model_image'
    ];

    public function template()
    {
        return $this->belongsTo(Templates::class,'template_id');
    }
}
