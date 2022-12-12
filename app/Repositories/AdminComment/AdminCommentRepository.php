<?php

namespace App\Repositories\AdminComment;

use App\Models\Comment;

class AdminCommentRepository implements IAdminCommentRepository
{
    public function allAdminComments()
    {
        $comments = Comment::with('post')->orderBy('id', 'desc')->paginate(5);

        return response()->json($comments);
    }

    public function deleteAdminComment(Comment $comment)
    {
        $comment = $comment->delete();
    }
}