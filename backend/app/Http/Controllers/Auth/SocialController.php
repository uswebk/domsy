<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;

final class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }

    public function callback($provider)
    {

        // User情報取得

        // ユーザーが存在すればそのままログイン状態にしてOKを返す

        // ユーザーが存在しなければユーザーを作成してログイン状態にして返す

        // 例外が発生すれば 500を返す

        return [];
    }
}
