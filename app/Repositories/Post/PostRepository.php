<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Repositories\Post\IPostRepository;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PostRepository implements IPostRepository
{

    public function getAllPosts()
    {
       // $pagesize = $request->page_size ?? 5;

        $posts = Post::with(['category', 'tags'])->orderBy('id', 'desc')->paginate(20);

        return PostResource::collection($posts);
    }

    public function storePost(Request $request,array $data)
    {
        DB::transaction(function () use ($request, $data) {

       $post = Post::query()->create([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
            'post_date' => carbon::now(),
        ]);

        //dd($post);

        $post->tags()->attach($request->tag_id);

        return $post;

    });

    }

    public function getSinglePost(Post $post)
    {
        return $post;
    }

    public function updatePost(Request $request, $id, array $data)
    {
        DB::transaction(function () use ($request, $id, $data) {

        $post = Post::find($id)->update([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
            'post_date' => carbon::now(),
        ]);

        //dd($posts);

         $post->tags()->sync($request->tag_id);

        return $post;

       });
    }

    public function deletePost(Post $post)
    {
        $post = $post->delete();

        //return response()->json($post);
    }
}