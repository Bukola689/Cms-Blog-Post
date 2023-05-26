<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use App\Repositories\AdminComment\AdminCommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminCommentController extends Controller
{
    public $comment;

    public function __construct(AdminCommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {

        $comments = cache()->remember('comments', 30, function () {
             return  $this->comment->allAdminComments();
        });

        return response()->json($comments);
    }


    public function destroy(Comment $comment)
    {
      $this->comment->deleteAdminComment($comment);

      Cache::pull('comment');

      return response()->json([
        'message' => 'Comment Deleted Successfully',
      ]);
    }
}
