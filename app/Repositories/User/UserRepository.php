<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(array $filters, int $perPage): LengthAwarePaginator
    {
        return User::with('listings')
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getUserListings(int $userId, array $filters, int $perPage): LengthAwarePaginator
    {
        return User::find($userId)
            ->listings()
            ->userListingForAdminFilter($filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function updateRole(int $userId, string $role): bool
    {
        return User::find($userId)->update(['role' => $role]);
    }
}
