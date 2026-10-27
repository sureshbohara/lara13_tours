<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_category';
    
    protected $fillable = ['blog_id', 'category_id'];
    
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}