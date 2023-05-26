<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Repositories\Post\PostRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Cache::remember('posts', 60, function () {
            return $this->post->getAllPosts();
        });

        return PostResource::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {

       $data = $request->all();

       $image = $request->image;

        $originalName = $image->getClientOriginalName();
    
        $image_new_name = 'image-' .time() .  '-' .$originalName;
    
        $image->move('posts/image', $image_new_name);

        $this->post->storePost($request, $data);

        Cache::put('post', $data);
    
        return response()->json([

          'message' => 'Post Save Successfully'
          
         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        $postShow = Cache::remember('post:'. $post->id, 60, function () use ($post) {
            return $this->post->getSinglePost($post);
        });
        
        return response()->json($postShow);
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
    public function update(PostUpdateRequest $request, $id)
    {
    
        $data = $request->all();

        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('posts/image', $image_new_name);
  
            $data['image'] = 'posts/image/' . $image_new_name;    
      }

       $this->post->updatePost($request, $id, $data);

       Cache::put('post', $data);

        return response()->json([
            'message' => 'Post Updated Successfully !'
        ]);

        //return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->post->deletePost($post);

        Cache::pull('post');

        return response()->json([
            "message" => 'Post deleted successfully !'
            
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
