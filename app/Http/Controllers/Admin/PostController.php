<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        //$posts->dd();

        return PostResource::collection($posts);
    }

    public function getTotalPost()
    {
        $posts = Post::count();

        //$posts->dd();

        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $tags = Tag::all();

        return response()->json([
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = Validator::make($request->all(),[
            'category_id' => 'required',
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'date' => 'nullable|date',
        ]);

        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials and try again'
            ]);
        }

        $image = $request->image;
      
        $originalName = $image->getClientOriginalName();
    
        $image_new_name = 'image-' .time() .  '-' .$originalName;
    
        $image->move('posts/image', $image_new_name);
    
             $post = new Post;
             $post->category_id = $request->input('category_id');
             $post->title = $request->input('title');
             $post->image = 'posts/image/' . $image_new_name;
             $post->description = $request->input('description');
             $post->date = Carbon::now();
             $post->save();

             $post->tags()->attach($request->tag);
    
             return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        
        $data = Validator::make($request->all(),[
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);
  
        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials and try again !'
            ]);
        }

        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('posts/image', $image_new_name);
  
            $post->image = 'posts/image/' . $image_new_name;
      }

        $post->user_id = $request->input('user_id');
        $post->category_id = $request->input('category_id');
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->date = $request->input('date');
        $post->update();

        $post->tags()->sync($request->tag);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post = $post->delete();

        return response()->json([
            "message" => 'Post deleted successfully !',
            'post' => $post
        ]);
    }

    public function search($search)
    {
        $posts = Post::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($posts) {
            return response()->json([
                'success' => true,
                'posts' => $posts
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'posts not found'
            ]);
        }
    }
}
