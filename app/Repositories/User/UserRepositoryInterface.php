<?php

namespace App\Repositories\User;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllUsers(array $filters, int $perPage): LengthAwarePaginator;

    public function getUserListings(int $userId, array $filters, int $perPage): LengthAwarePaginator;

    public function updateRole(int $userId, string $role): bool;
}
