<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Template\Template;

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
        return $this->belongsTo(Template::class);
    }
}
