<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use App\Http\Resources\TagResource;
use App\Repositories\Tag\ITagRepository;

class TagRepository implements ITagRepository
{
    public function allTag()
    {
        $tags = Tag::latest()->get();

        return TagResource::collection($tags);
    }

    public function storeTag(array $data)
    {
        Tag::insert([
            'name' => $data['name'],
        ]);
    }

    public function getSingleTag(Tag $tag)
    {
        return $tag;
    }

    public function updateTag(Tag $tag, array $data)
    {
        $tag->update([
            'name' => $data['name'],
        ]);
    }

    public function deleteTag(Tag $tag)
    {
        $tag = $tag->delete();
    }
}