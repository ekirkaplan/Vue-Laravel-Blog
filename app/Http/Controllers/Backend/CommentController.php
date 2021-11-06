<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comments;

class CommentController extends Controller
{
    public function list()
    {
        $list = Comments::all();
        return view('Backend.Comments.list', compact('list'));
    }

    public function statusSwap($id)
    {
        $find = Comments::find($id);
        if ($find->status > 0){
            $find->update(['status' => 0]);
        }else{
            $find->update(['status' => 1]);
        }
        return redirect()->back()->with('success', 'İşlem Başarılı');
    }
}
