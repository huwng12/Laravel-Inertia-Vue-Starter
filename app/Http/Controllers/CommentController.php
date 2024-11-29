<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Listing $listing, Comment $comment)
    {
        $fields = $request->validate([
            'comment' => 'required|string|max:255',
        ]);
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
