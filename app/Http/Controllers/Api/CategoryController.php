<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryDetailResource;
use App\Http\Resources\CategoryWithBlogResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function allList()
    {
        return response()->json(Category::where('status', 1)->get(['id','name']));
    }

    public function blogWithList()
    {
        return CategoryWithBlogResource::collection(Category::where('status', 1)->get());
    }

    public function menuList()
    {
        return response()->json(Category::where('status', 1)->limit(4)->get(['id','name','slug']));
    }

    public function find($slug)
    {
        $has = Category::where('slug', $slug)->count();
        if ($has > 0){
            return new CategoryDetailResource(Category::where('slug', $slug)->first());
        }else{
            return response()->json([]);
        }
    }
}
