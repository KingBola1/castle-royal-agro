<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            event(new Registered($user));

            // Send Welcome Email via Brevo API
            Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => ['email' => env('MAIL_FROM_ADDRESS'), 'name' => 'Castle Royal Admin'],
                'to' => [['email' => $user->email, 'name' => $user->name]],
                'subject' => '🌱 Welcome to Castle Royal Agro!',
                'htmlContent' => "
                    <div style='font-family: Arial; padding: 20px; border: 1px solid #eee;'>
                        <h2>Welcome, {$user->name}!</h2>
                        <p>Thank you for joining <strong>Castle Royal Agro</strong>. We are excited to have you on board.</p>
                        <p>You can now log in to your dashboard to view investment packages and track your portfolio.</p>
                        <br>
                        <a href='" . route('login') . "' style='background-color: #2d3748; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login to Dashboard</a>
                    </div>"
            ]);

        } catch (\Exception $e) {
            // Log the error but continue logging in the user
            \Illuminate\Support\Facades\Log::error('Registration Email Failed: ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
