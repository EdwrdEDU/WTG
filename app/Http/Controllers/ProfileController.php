<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile settings form
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('accounts')->ignore($user->id)
            ],
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            // Store new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        // Update user data
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}