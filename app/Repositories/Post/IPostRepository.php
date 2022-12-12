<?php

namespace App\Repositories\Post;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\Request;

interface IPostRepository
{

  public function getAllPosts();

  public function storePost(Request $request,array $data);

  public function getSinglePost(Post $post);

 public function updatePost(Request $request, $id, array $data);

 public function deletePost(Post $post);
  
}