<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
