<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Gallery;
use Illuminate\Http\Request;

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

    public function formProcess(Request $request, $id = 0){
        $has = Blog::where('id', $id)->count('id');
        if ($has > 0){
            try {
                $find = Blog::find($id);
                $arr = [
                    'name' => $request->name,
                    'img' => $request->img,
                    'content' => $request->summernote,
                    'streamDate' => $request->streamDate,
                    'status' => $request->status,
                ];
                $find->update($arr);
                $a = $request->category;
                $b = collect($a);
                $c = $b->flatten();
                $find->category()->sync($c);
             }catch (\Exception $exception){
                return response()->json(['statusCode' => 0, 'statusMessage' => 'Bir Hata Oluştu!']);
            }
            return response()->json(['statusCode' => 1, 'statusMessage' => 'Blog Yazısı Güncellendi']);
        }else{
            $arr = [
                'name' => $request->name,
                'img' => $request->img,
                'content' => $request->summernote,
                'streamDate' => $request->streamDate,
                'status' => $request->status,
            ];
            $process = Blog::create($arr);
            if ($process){
                try {
                    $loopList = $request->category;
                    foreach ($loopList as $item){
                        $categoryArr = [
                            'blog_id' => $process->id,
                            'category_id' => $item,
                        ];
                        BlogCategory::create($categoryArr);
                    }
                 }catch (\Exception $exception){
                    return response()->json(['statusCode' => 0, 'statusMessage' => 'Blog Yazısı Eklenemedi']);
                }
                return response()->json(['statusCode' => 1, 'statusMessage' => 'Blog Yazısı Eklendi']);
            }else{
                return response()->json(['statusCode' => 0, 'statusMessage' => 'Blog Yazısı Eklenemedi']);
            }
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

    public function addPhoto(Request $request)
    {
        try {
            $this->validate(request(), [
                'file' => 'image|mimes:jpg,png,jpeg,gif|max:3000'
            ]);
            $img = $request->file('file');
            $year = now()->year;
            $month = now()->month;
            $imgName = $img->getClientOriginalName();
            $hasImage = public_path('Gallery/Blog/'.$year.'/'.$month.'/'.$imgName);
            if (file_exists($hasImage)){
                $randomStr = \Str::random(5);
                $imgName = $randomStr .'-'. $img->getClientOriginalName();
            }
            $galleryArray = [
                'img' => 'Gallery/Blog/'.$year.'/'.$month.'/'.$imgName,
                'alt' => $img->getClientOriginalName()
            ];
            $process = Gallery::create($galleryArray);
            $img->move('Gallery/Blog/'.$year.'/'.$month, $imgName);
            return response()->json($process->id);
        }catch (\Exception $exception){
            return response()->json(false);
        }
    }

    public function destroy($id)
    {
        $has = Blog::where('id', $id)->count('id');
        if ($has > 0){
            $destroy = Blog::destroy($id);
            if ($destroy){
                return response()->json(['statusCode' => 1, 'statusMessage' => 'Blog Yazısı Silindi']);
            }else{
                return response()->json(['statusCode' => 0, 'statusMessage' => 'Blog Yazısı Silinemedi!']);
            }
        }else{
            return response()->json(['statusCode' => 0, 'statusMessage' => 'Sistemde Kayıtlı Olmayan Blog Yazısı!']);
        }
    }
}
