<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $timezones = timezone_identifiers_list();
      
        $guessedTimezone = User::guessUserTimezoneUsingAPI($request->ip());
        
        
        $response = Http::get('https://api.ipify.org?format=json');
        
        if ($response->ok()) {
            $data = $response->json();
            $publicIP = $data['ip'] ?? null;
            $guessedTimezone = User::guessUserTimezoneUsingAPI($publicIP);
            // return $publicIP;
        }
        
        // dd($guessedTimezone, $publicIP);
        
        return view('auth.register', compact('timezones', 'guessedTimezone'));
 
        
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'timezone' => ['required', Rule::in(array_flip(timezone_identifiers_list()))],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'timezone' => timezone_identifiers_list()[$request->input('timezone', 'UTC')],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
