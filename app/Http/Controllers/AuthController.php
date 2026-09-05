<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Chhota sa login, sirf maalik ke liye.
 *
 * Register ka koi rasta nahi hai -- jaan-boojh kar. Account
 * `php artisan make:admin` se banta hai, server par. Site par register
 * hota to koi bhi khud ko admin bana kar property add kar sakta tha.
 */
class AuthController extends Controller
{
    public function form()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($data, $request->boolean('remember'))) {
            /* Ek hi jawab dono galtiyon ka -- "email galat hai" alag se
               batate to koi ye pata kar sakta tha ki kaunsa email
               maujood hai. */
            throw ValidationException::withMessages([
                'email' => 'Email ya password galat hai.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
