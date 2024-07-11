<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_deleted', 'parent_id'];

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
