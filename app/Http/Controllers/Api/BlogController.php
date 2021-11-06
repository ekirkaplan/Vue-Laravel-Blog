<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;

class BlogController extends Controller
{
    public function homeSliderList()
    {
        return BlogResource::collection(Blog::where('status',1)->orderBy('id','DESC')->limit(5)->get());
    }
}
