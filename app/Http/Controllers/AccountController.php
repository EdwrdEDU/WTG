<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule; 


class AccountController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $account = new Account();
        $account->firstname = $validatedData['firstname'];
        $account->lastname = $validatedData['lastname'];
        $account->email = $validatedData['email'];
        $account->password = bcrypt($validatedData['password']);
        $account->save();

        Auth::login($account); // Auto-login after registration (optional)

        return redirect('/home')->with('success', 'Account created successfully!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $account = Account::where('email', $credentials['email'])->first();

        if ($account && Hash::check($credentials['password'], $account->password)) {
            Auth::login($account); // manually login the user
            $request->session()->regenerate();

            return redirect('/home')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/account/login')->with('success', 'Logged out successfully!');
    }

    public function update(Request $request)
    {
        $user = Account::find(Auth::id());

        $validated = $request->validate([
            'firstname'      => 'required|string|max:255',
            'lastname'       => 'required|string|max:255',
            'email'          => "required|email|max:255|unique:accounts,email,{$user->id}",
            'phone'          => 'nullable|string|max:20',
            'date_of_birth'  => 'nullable|date',
            // Password fields are validated below if present
        ]);

        $user->firstname = $validated['firstname'];
        $user->lastname = $validated['lastname'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->date_of_birth = $validated['date_of_birth'] ?? null;

        // Handle password change if fields are filled
        if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('new_password_confirmation')) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            $user->password = bcrypt($request->input('new_password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = Account::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email not found']);
    }

    $token = Str::random(64);
    $user->reset_token = $token;
    $user->reset_token_expires_at = now()->addHour();
    $user->save();

    Mail::to($user->email)->send(new ResetPasswordMail($token));

    return back()->with('status', 'Reset link sent to your email.');
}

public function showResetForm($token)
{
    return view('auth.reset-password', ['token' => $token]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = Account::where('reset_token', $request->token)
                   ->where('reset_token_expires_at', '>', now())
                   ->first();

    if (!$user) {
        return back()->withErrors(['token' => 'Invalid or expired token']);
    }

    $user->password = Hash::make($request->password); // more consistent than bcrypt
    $user->reset_token = null;
    $user->reset_token_expires_at = null;
    $user->save();

    // Optionally auto-login:
    // Auth::login($user);

    return redirect('/account/login')->with('status', 'Password successfully reset.');
}



}

