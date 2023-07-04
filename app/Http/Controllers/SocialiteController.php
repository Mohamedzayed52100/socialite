<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function login($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function redirect($provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([  //علشان لو اليوسر موجود ميعملش create 
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
        ], [
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
        ]);

        //

        // auth user
        Auth::login($user, true);   //true علشان ال remmber token 

        // redirect to dashboard
        return to_route('dashboard');
    }
}
