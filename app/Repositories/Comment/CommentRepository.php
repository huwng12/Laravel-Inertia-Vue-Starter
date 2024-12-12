<?php

namespace App\Repositories\Comment;

use App\Events\NotificationCreated;
// use App\Models\Notification;

use App\Models\Comment;
use App\Models\Listing;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentRepositoryInterface
{
    public function storeComment(array $fields, int $listingId)
    {

        Comment::create([
            'name' => Auth::user()->name,
            'user_id' => Auth::id(),
            'listing_id' => $listingId,
            'comment' => $fields['comment'],
            'status' => '1'
        ]);
        $listing = Listing::find($listingId);
        if ($listing->user_id != Auth::id()) {
            $fields['user_id'] = $listing->user_id;
            $fields['from_user_id'] = Auth::id();
            $fields['listing_id'] = $listingId;
            $fields['title'] = $listing->title;
            $fields['message'] = $fields['comment'];
            $fields['type'] = 2;
            Notification::create($fields);
            $commentedUserName = Auth::user()->name;
            broadcast(new NotificationCreated([
                'user_id' => $listing->user_id,
                'title' => $listing->title,
                'message' =>   $commentedUserName . ' had commented to your listing',
                // 'url' => route('listings.show', Listing::id())
            ]));
        }
    }
}
