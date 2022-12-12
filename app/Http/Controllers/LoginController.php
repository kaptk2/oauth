<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($service)
    {
        $subdomain = Arr::first(explode('.', \Request::getHost()));

        return Socialite::driver($service)->with(['state' => $subdomain])->redirect();
    }

    public function handleProviderCallback($service, Request $request)
    {
        $user = Socialite::driver($service)->stateless()->user();

        $account = Account::where('name', $request->get('state'))->first();

        $provider = $account->oauthProviders->firstWhere('name', $service);

        // only allowed authorized domains to login
        if ($provider?->oAuthAllowedDomains->isNotEmpty()) {
            $userDomain = explode('@', $user->email)[1];
            if (! $provider?->oAuthAllowedDomains->contains('domain', $userDomain)) {
                return redirect('/oauth/error');
            }
        }

        $account->makeCurrent();

        $localUser = User::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'profile_photo_path' => $user->avatar,
                'password' => Hash::make(Str::random(24)),
            ]
        );

        Auth::login($localUser, true);

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
