<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Repositories\Profile\ProfileRepositoryInterface;

class ProfileController extends Controller
{
    private $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function edit(Request $request)
    {
        return inertia('Profile/Edit', [
            'user' => $request->user(),
            'status' => session('status'),
        ]);
    }

    public function updateInfo(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => [
                'required',
                'email',
                'lowercase',
                'max:255',
                Rule::unique(User::class)->ignore($request->user()->id),
            ],
        ]);

        $this->profileRepository->updateInfo($fields, $request->user());

        return redirect()->route('profile.edit');
    }

    public function updatePassword(Request $request)
    {
        $fields = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:3'],
        ]);

        $this->profileRepository->updatePassword($fields, $request->user());
        return redirect()->route('profile.edit');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $this->profileRepository->destroyAccount($request->user());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
