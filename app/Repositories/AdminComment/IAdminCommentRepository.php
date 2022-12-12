<?php

namespace App\Repositories\AdminComment;

use APP\Models\Comment;

interface IAdminCommentRepository
{
    public function allAdminComments();

    public function deleteAdminComment(Comment $comment);
}