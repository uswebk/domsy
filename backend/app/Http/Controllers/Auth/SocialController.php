<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    use AuthenticatesUsers;

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }

    public function callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
//        $userAcount = User::where(['email' => $userSocial->getEmail()])->first();
//
//        if ($userAcount) {
//            $user = User::find($userAcount->getAttribute('id'));
//            Auth::login($userAcount);
//        } else {
//            $user = User::create([
//                'name' => $userSocial->getName(),
//                'email' => $userSocial->getEmail(),
//                'avatar' => $userSocial->getAvatar(),
//                'provider_id' => $userSocial->getId(),
//                'provider' => $provider,
//            ]);
//        }
//
//        return [
//            'user' => $user,
//            'access_token' => $user->createToken('user')->plainTextToken,
//        ];
    }
}
