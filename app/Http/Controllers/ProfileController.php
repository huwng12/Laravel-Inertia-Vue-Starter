<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return inertia('Profile/Edit', [
            'user' => $request->user(),
        ]);
    }

    public function updateInfo(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|lowercase|email|max:255',
        ]);

        return redirect()->route('profile.edit');
    }
}
