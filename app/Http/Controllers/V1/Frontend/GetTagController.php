<?php

namespace App\Http\Controllers\V1\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Tag;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;

class GetTagController extends Controller
{
    public function allTag()
    {
        $allTags = Tag::orderBy('id', 'desc')->paginate(5);

        return TagResource::collection($allTags);
    }

    public function tagById(Tag $tag)
    {
        return new TagResource($tag);
    }

    public function getTotalTag()
    {
        $tags = Tag::count();

        return response()->json($tags);
    }

    public function searchTag($search)
    {
        $tags = Tag::where('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();

        if($tags)
        {
            return response()->json($tags);
        }

        else {
            return response()->json(['tag not found']);
        }
    }
}
