<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Update the user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $user->id, 'alpha_dash'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'website' => ['nullable', 'url', 'max:255'],
            'interests' => ['nullable', 'array'],
             'profile_image' => ['nullable', 'image', 'max:1024'],
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists('public/' . $user->profile_image)) {
                Storage::delete('public/' . $user->profile_image);
            }
            
            // Store new image
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $path;
        }
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (isset($validated['username'])) {
            $user->username = $validated['username'];
        }
        
        if (isset($validated['bio'])) {
            $user->bio = $validated['bio'];
        }
        
        if (isset($validated['website'])) {
            $user->website = $validated['website'];
        }
        
        if (isset($validated['interests'])) {
            $user->interests = $validated['interests'];
        }
        
        if (isset($validated['social_links'])) {
            $user->social_links = $validated['social_links'];
        }
        
        $user->save();
        
        return redirect()->route('dashboard.settings')->with('status', 'Profile updated successfully!');
    }
    
    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        
        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();
        
        return redirect()->route('dashboard.settings')->with('status', 'Password updated successfully!');
    }
    
    /**
     * Update notification preferences.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'notifications' => ['nullable', 'array'],
        ]);
        
        $user->notification_preferences = $validated['notifications'] ?? [];
        $user->save();
        
        return redirect()->route('dashboard.settings')->with('status', 'Notification preferences updated successfully!');
    }
    
    /**
     * Update display preferences.
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'preferences' => ['nullable', 'array'],
        ]);
        
        $user->display_preferences = $validated['preferences'] ?? [];
        $user->save();
        
        return redirect()->route('dashboard.settings')->with('status', 'Display preferences updated successfully!');
    }
    
    /**
     * Delete the user's account.
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        // Delete profile image if exists
        if ($user->profile_image && Storage::exists('public/' . $user->profile_image)) {
            Storage::delete('public/' . $user->profile_image);
        }
        
        // Delete user
        Auth::logout();
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('status', 'Your account has been deleted.');
    }
}