<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list()
    {
        $list = Category::all();
        return view('Backend.Category.list', compact('list'));
    }

    public function process(Request $request, $id = 0)
    {
        $this->validate($request, [
            'name' => "required",
            'status' => "required",
        ],[
            'name.required' => "Kategori Adı Girmediniz!",
            'status.required' => "Kategori Durumu Seçmediniz!",
        ]);

        $has = Category::where('id', $id)->count('id');

        if ($has > 0 && $id > 0){
           try {
               $find = Category::find($id);
               $arr = [
                   'name' => $request->name,
                   'status' => $request->status,
               ];
               $find->update($arr);
            }catch (\Exception $exception){
               return redirect()->back()->with('error', 'Kategori Güncellenirken Bir Hata Oluştu!');
           }
            return redirect()->back()->with('success', 'Kategori Güncellendi');
        }else{
            $arr = [
                'name' => $request->name,
                'status' => $request->status,
            ];
            $process = Category::create($arr);
            if ($process){
                return redirect()->back()->with('success', 'Kategori Eklendi');
            }else{
                return redirect()->back()->with('error', 'Kategori Güncellenirken Bir Hata Oluştu!');
            }
        }
    }

    public function destroy($id)
    {
        $has = Category::where('id', $id)->count('id');
        if ($has > 0){
            $destroy = Category::destroy($id);
            if ($destroy){
                return response()->json(['statusCode' => 1, 'statusMessage' => 'Kategori Silindi']);
            }else{
                return response()->json(['statusCode' => 0, 'statusMessage' => 'Kategori Silinemedi!']);
            }
        }else{
            return response()->json(['statusCode' => 0, 'statusMessage' => 'Sistemde Kayıtlı Olmayan Kategori!']);
        }
    }
}
