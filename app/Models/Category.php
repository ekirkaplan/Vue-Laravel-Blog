<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category' , $guarded = [];

    public function blog()
    {
        return $this->belongsToMany(Blog::class, 'blogCategory')->using(BlogCategory::class);
    }
}
