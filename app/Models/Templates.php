<?php

namespace App\Models;

use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
        'no_of_files',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(category::class,'sub_category_id');
    }

    public function templateModels(): HasMany
    {
        return $this->hasMany(TemplateModels::class,'template_id','id');
    }
}
