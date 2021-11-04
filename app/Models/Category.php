<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasSlug;
    protected $table = 'category' , $guarded = [];

    public function blog()
    {
        return $this->belongsToMany(Blog::class, 'blogCategory')->using(BlogCategory::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
