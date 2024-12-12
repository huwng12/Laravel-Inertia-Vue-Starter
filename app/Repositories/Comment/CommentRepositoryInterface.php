<?php

namespace App\Repositories\Comment;

interface CommentRepositoryInterface
{
    public function storeComment(array $fields, int $listingId);
}
