<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\DeleteAccountRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use Illuminate\Http\Request;
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

    public function updateInfo(ProfileUpdateRequest $request)
    {
        $fields = $request->safe()->only('name', 'email');
        $this->profileRepository->updateInfo($fields, $request->user());
        return redirect()->route('profile.edit');
    }

    public function updatePassword(ProfileUpdateRequest $request)
    {
        $fields = $request->safe()->only('password');
        $this->profileRepository->updatePassword($fields, $request->user());
        return redirect()->route('profile.edit');
    }

    public function destroy(DeleteAccountRequest $request)
    {
        $this->profileRepository->destroyAccount($request->user());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
