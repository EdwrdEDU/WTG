<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        ]);

        $user->firstname = $validated['firstname'];
        $user->lastname = $validated['lastname'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->date_of_birth = $validated['date_of_birth'] ?? null;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

}

