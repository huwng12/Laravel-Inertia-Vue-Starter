<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentStoreRequest $request, Listing $listing, Comment $comment)
    {
        $fields = $request->validated();
        $comment->create([
            'name' => Auth::user()->name,
            'user_id' => Auth::id(),
            'listing_id' => $listing->id,
            'comment' => $fields['comment'],
            'status' => '1'
        ]);

        return back()->with('status', 'Comment added successfully');
    }
}
