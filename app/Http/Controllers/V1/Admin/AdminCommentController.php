<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use App\Repositories\AdminComment\AdminCommentRepository;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public $comment;

    public function __construct(AdminCommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {
        $comments = $this->comment->allAdminComments();

        return response()->json($comments);
    }


    public function destroy(Comment $comment)
    {
      $comment = $this->comment->deleteAdminComment($comment);

      return response()->json([
        'message' => 'Comment Deleted Successfully',
      ]);
    }
}
