<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BlogCategory extends Pivot
{
    protected $table = 'blogCategory' , $guarded = [];
    public $timestamps = false , $incrementing = true;
}
