<?php

namespace App\Dashboard\Controllers;

use App\Enums\ProviderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterWithEmailRequest;
use App\Http\Requests\CallbackProviderRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class OauthController extends Controller
{
    public string $redirectTo = '/dashboard';

    public function loginForm(): \Inertia\Response
    {
        return Inertia::render('Auth/Login', [
            'github' => Socialite::driver('github')->redirect()->getTargetUrl(),
            'google' => Socialite::driver('google')->redirect()->getTargetUrl(),
        ]);
    }

    /**
     * @param  \App\Http\Requests\CallbackProviderRequest  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function callback(CallbackProviderRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        return match (ProviderEnum::from($request->provider)) {
            ProviderEnum::GOOGLE => $this->googleCallback(),
            ProviderEnum::GITHUB => $this->gitHubCallback(),
            ProviderEnum::EMAIL => throw new Exception('To be implemented'),
            ProviderEnum::FACEBOOK => throw new Exception('To be implemented'),
        };
    }

    /**
     * @return \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    protected function gitHubCallback(): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $user = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'provider' => ProviderEnum::GITHUB->value,
            'provider_id' => $user->id,
        ], [
            'name' => $user->name,
            'email' => $user->email,
            'provider_id' => $user->id,
            'provider_token' => $user->token,
            'provider_refresh_token' => $user->refreshToken ?? null,
        ]);

        Auth::login($user);

        return redirect($this->redirectTo);
    }

    protected function googleCallback(): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $user = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'provider' => ProviderEnum::GOOGLE->value,
            'provider_id' => $user->id,
        ], [
            'name' => $user->name,
            'email' => $user->email,
            'provider_id' => $user->id,
            'provider_token' => $user->token,
            'provider_refresh_token' => $user->refreshToken ?? null,
        ]);

        Auth::login($user);

        return redirect($this->redirectTo);
    }

    protected function loginWithEmail(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registerWithEmailForm(Request $request)
    {
        return Inertia::render('Auth/Register');
    }

    public function registerWithEmail(RegisterWithEmailRequest $request)
    {
        User::create($request->validated());

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Successfully singed out.');
    }
}
