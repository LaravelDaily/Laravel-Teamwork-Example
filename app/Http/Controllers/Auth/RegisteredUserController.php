<?php

namespace App\Http\Controllers\Auth;

use App\Models\Team;
use App\Http\Controllers\Controller;
use App\Models\User;
use Mpociot\Teamwork\Facades\Teamwork;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $invite = null;

        if ($request->invitation_token) {
            $invite = Teamwork::getInviteFromAcceptToken($request->invitation_token);
            if (! $invite) {
                throw ValidationException::withMessages(['token' => 'Bad token']);
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($invite) {
            Teamwork::acceptInvite($invite);
        } else {
            $team = Team::create([
                'owner_id' => $user->id,
                'name' => $user->name . "'s Team",
            ]);

            $user->attachTeam($team);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
