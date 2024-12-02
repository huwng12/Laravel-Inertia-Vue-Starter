<?php

namespace App\Repositories\Profile;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProfileRepositoryInterface
{
    public function updateInfo(array $fields, $user);
    public function updatePassword(array $fields, $user);
    public function destroyAccount($user);
}
