<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(array $filters, ?int $perPage): LengthAwarePaginator
    {
        $query = User::with('listings')->filter($filters);
        $perPage = $perPage ?? $query->count();
        return $query->paginate($perPage)->withQueryString();
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

    public function getAllUsersExceptAdmin(array $filters, ?int $perPage): LengthAwarePaginator
    {
        $query = User::with('listings')->where('role', '!=', 'admin')->filter($filters);
        $perPage = $perPage ?? $query->count();
        return $query->paginate($perPage)->withQueryString();
    }
}
