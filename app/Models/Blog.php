<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasSlug;
    protected $table = 'blog' , $guarded = [];

    public function category()
    {
        return $this->belongsToMany(Category::class,'blogCategory')->using(BlogCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class,'blogId','id');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
