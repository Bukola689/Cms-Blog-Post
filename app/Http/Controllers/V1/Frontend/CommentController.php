<?php

namespace App\Http\Controllers\V1\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    public function getComment()
    {
        
        $comments = Cache::remember('comments', 60, function () {
            return  Comment::orderBy('id', 'desc')->paginate(5);
        });

        return response()->json($comments);
    }

    public function getTotalComment()
    {
        $comments = Comment::count();

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required'
        ]);

        $comment = new Comment();
        $comment->post_id = $request->input('post_id');
        $comment->name = $request->input('name');
        $comment->email = $request->input('email');
        $comment->comment = $request->input('comment');
        $comment->save();

        Cache::put('comment', $data);

        return response()->json([
            'status' => true,
            'message' => 'You Made Comment To This Post !'
        ]);
    }
}
