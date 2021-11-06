<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Comments;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function homeSliderList()
    {
        return BlogResource::collection(Blog::where('status',1)->orderBy('id','DESC')->limit(5)->get());
    }

    public function detail($slug)
    {
        return new BlogResource(Blog::where('slug', $slug)->first());
    }

    public function commentAdd(Request $request)
    {
        $has = Comments::where('blogId', $request->blogId)->where('email',$request->email)->count();
        if ($has < 1){
            $arr = [
                'blogId' => $request->blogId,
                'name' => $request->name,
                'email' => $request->email,
                'content' => $request->contents,
                'status' => 0,
            ];
            $process = Comments::create($arr);
            if ($process){
                return response()->json(['statusCode'=> 1,'statusMessage' => "Yorumunuz Moderatör Onayına Gönderildi!"]);
            }else{
                return response()->json(['statusCode'=> 0,'statusMessage' => "Tekrar Deneyiniz"]);
            }
        }else{
            return response()->json(['statusCode'=> 0,'statusMessage' => "Zaten Yorum Yaptınız!"]);
        }
    }

    public function filterList(Request $request)
    {
        $list = Blog::where('status', 1);
        if ($request->categoryId > 1){
            $a = BlogCategory::where('category_id', $request->categoryId)->get(['blog_id']);
            $list = $list->whereIn('id', $a);
        }
        if ($request->orderBy == 1){
            $list = $list->orderBy('id', 'DESC');
        }elseif ($request->orderBy == 2){
            $list = $list->orderBy('id', 'ASC');
        }elseif ($request->orderBy == 3){
            $list = $list->orderBy('name', 'ASC');
        }elseif ($request->orderBy == 4){
            $list = $list->orderBy('name', 'DESC');
        }
        return BlogResource::collection($list->get());
    }
}
