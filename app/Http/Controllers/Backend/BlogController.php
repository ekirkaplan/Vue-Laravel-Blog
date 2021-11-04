<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function list()
    {
        $list = Blog::all();
        return view('Backend.Blog.list', compact('list'));
    }

    public function form($id = 0)
    {
        $has = Blog::where('id', $id)->count();
        if ($has > 0){
            $data = Blog::find($id);
            return view('Backend.Blog.form', compact('data'));
        }else{
            $data = new Blog();
            return view('Backend.Blog.form', compact('data'));
        }
    }

    public function editorUpload(Request $request)
    {
        try {
            $this->validate(request(), [
                'file' => 'image|mimes:jpg,png,jpeg,gif|max:3000'
            ]);
            $img = $request->file('file'); //

            $year = now()->year;
            $month = now()->month;
            $imgName = $img->getClientOriginalName();
            $hasImage = public_path('Gallery/Other/'.$year.'/'.$month.'/'.$imgName);
            if (file_exists($hasImage)){
                $randomStr = \Str::random(5);
                $imgName = $randomStr .'-'. $img->getClientOriginalName();
            }
            $galleryArray = [
                'img' => 'Gallery/Other/'.$year.'/'.$month.'/'.$imgName,
                'alt' => $img->getClientOriginalName()
            ];
            $img->move('Gallery/Other/'.$year.'/'.$month, $imgName);
            return response()->json(['location' => '/Gallery/Other/'.$year.'/'.$month.'/'.$imgName]);
         }catch (\Exception $exception){
            return response()->json(false);
        }
    }
}
