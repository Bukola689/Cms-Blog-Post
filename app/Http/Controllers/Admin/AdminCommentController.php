<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{

    public function index()
    {
        $comments = Comment::orderBy('id', 'desc')->paginate(5);

        return response()->json($comments);
    }


    public function delete(Comment $comment)
    {
        $comment = $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment Deleted Successfully !'
        ]);
    }
}
