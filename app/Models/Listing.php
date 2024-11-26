<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'tags',
        'email',
        'link',
        'image',
        'approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filter)
    {
        if ($filter['search'] ?? false) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                    ->orWhere('desc', 'like', '%' . request('search') . '%');
            });
        }

        if ($filter['user_id'] ?? false) {
            $query->where('user_id', $filter['user_id']);
        }

        if ($filter['tag'] ?? false) {
            $query->where('tags', 'like', '%' . $filter['tag'] . '%');
        }
    }
}
