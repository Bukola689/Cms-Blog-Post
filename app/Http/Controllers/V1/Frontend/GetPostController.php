<?php

namespace App\Http\Controllers\V1\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GetPostController extends Controller
{
    public function allPost()
    {
        $allPosts = Cache::remember('posts', 60, function () {
           return  Post::with('category')->orderBy('id', 'desc')->paginate(5);
        });

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
        $postId = Cache::remember('post:'. $post->id, 60, function () use ($post) {
            return $post;
        });
        return new PostResource($postId);
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
