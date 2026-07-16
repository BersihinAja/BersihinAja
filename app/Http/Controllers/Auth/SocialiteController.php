<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $user->assignRole('customer');
        }

        Auth::login($user);

        return redirect()->intended($this->redirectBasedOnRole($user));
    }

    private function redirectBasedOnRole(User $user): string
    {
        if ($user->hasRole('admin')) return '/admin/dashboard';
        if ($user->hasRole('pekerja')) return '/pekerja/dashboard';
        return '/';
    }
}
