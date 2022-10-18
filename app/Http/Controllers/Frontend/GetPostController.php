<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class GetPostController extends Controller
{
    public function allPost()
    {
        $allPosts = Post::with('category')->orderBy('id', 'desc')->paginate(5);

        return PostResource::collection($allPosts);
    }

    public function getTotalPost()
    {
        
        $posts = Post::count();

        return response()->json([
            'status' => true,
            'count' => $posts
        ]);
    }

    public function postById(Post $post)
    {
        return new PostResource($post);
    }

    public function searchPost($search)
    {
        $posts = Post::where('title', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();

        if($posts)
        {
            return response()->json($posts);
        }

        else {
            return response()->json(['post not found']);
        }
    }
}
