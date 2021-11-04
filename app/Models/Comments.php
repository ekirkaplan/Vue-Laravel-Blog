<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments' , $guarded = [];

    public function blog()
    {
        return $this->belongsTo(Blog::class,'blogId','id');
    }
}
