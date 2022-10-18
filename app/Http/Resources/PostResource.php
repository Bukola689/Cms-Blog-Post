<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // $category = $this->whenLoaded('category');

        return [
            'id' => (string) $this->id,
            'type' => 'Posts',
            'attributes' => [
                'title' => $this->title,
                'image' => $this->image,
                'description' => $this->description,
                'date' => $this->date,
                'category' => new CategoryResource($this->category),
                //'tag' => new TagResource($this->tag),
                'tags' => $this->tags
            ]
        ];
    }
}
