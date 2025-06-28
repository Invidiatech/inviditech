<?php

namespace App\Http\Controllers\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
 use App\Http\Requests\seo\SeoProfileUpdateRequest;

class ProfileController extends Controller
{

    public function edit(Request $request): View
    {
         return view('seo.profile.edit', [
            'user' => $request->user('seo'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(SeoProfileUpdateRequest $request): RedirectResponse
    {
        $request->user('seo')->fill($request->validated());

        if ($request->user('seo')->isDirty('email')) {
            $request->user('seo')->email_verified_at = null;
        }

        $request->user('seo')->save();

        return Redirect::route('seo.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // $request->validateWithBag('userDeletion', [
        //     'password' => ['required', 'current_password:seo'],
        // ]);

        $user = $request->user('seo');

        Auth::guard('seo')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/seo/login');
    }
}
