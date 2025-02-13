<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'listing_id',
        'comment',
        'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
