<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Listing;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public $commentRepository;
    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(CommentStoreRequest $request, Listing $listing, Comment $comment)
    {
        $fields = $request->validated();
        $this->commentRepository->storeComment($fields, $listing->id);

        return back()->with('status', 'Comment added successfully');
    }
}
