<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
{
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    // Cerrar sesión antes de eliminar
    Auth::logout();

    // Eliminar equipos donde el usuario es owner
    $user->teams()->where('owner_id', $user->id)->each(function ($team) {
        $team->delete();
    });

    // Eliminar relaciones de equipos en los que está unido
    $user->joinedTeams()->detach();

    // Eliminar el usuario
    $user->delete();

    // Invalida sesión y regenera el token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
}


}
