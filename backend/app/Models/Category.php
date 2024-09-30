<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Отношение к родительской категории
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');;
    }

    // Рекурсивная связь для получения всех уровней вложенных категорий
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive', 'products');
    }

    // Связь с продуктами
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    
}
