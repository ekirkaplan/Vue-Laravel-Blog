<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog' , $guarded = [];

    public function category()
    {
        return $this->belongsToMany(Category::class,'blogCategory')->using(BlogCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class,'blogId','id');
    }
}
