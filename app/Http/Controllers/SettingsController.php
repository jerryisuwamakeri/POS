<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $branch = $user->branch;

        return view('settings.index', compact('user', 'branch'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:50',
        ]);

        Auth::user()->update($request->only([
            'name',
            'display_name',
            'email',
            'phone',
        ]));

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!\Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        Auth::user()->update([
            'password' => \Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully');
    }
}
