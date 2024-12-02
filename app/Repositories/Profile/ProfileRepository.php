<?php

namespace App\Repositories\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function updateInfo(array $fields, $user)
    {
        $user->fill($fields);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    public function updatePassword(array $fields, $user)
    {
        $user->update([
            'password' => Hash::make($fields['password']),
        ]);
    }

    public function destroyAccount($user)
    {
        $user->delete();
        Auth::logout();
    }
}
