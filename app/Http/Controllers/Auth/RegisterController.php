<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store() {
        $validate = request()->validate([
            'name' => 'required| max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:3',
        ]);

        $user = User::create($validate);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
