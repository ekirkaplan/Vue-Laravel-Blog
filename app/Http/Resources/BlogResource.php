<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/** @mixin \App\Models\Blog */
class BlogResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'img' => asset($this->coverImage->img),
            'content' => $this->content,
            'contentShort' => Str::limit(strip_tags($this->content), 120,'...'),
            'streamDate' => $this->streamDate->format('d/m/Y'),
            'created_at' => $this->created_at->format('d/m/Y'),
            'category' => $this->category,
            'commentsCount' => $this->comments->where('status', 1)->count(),
            'comments' => CommentResource::collection($this->comments->where('status', 1)),
        ];
    }
}
