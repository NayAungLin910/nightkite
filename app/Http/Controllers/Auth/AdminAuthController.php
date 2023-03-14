<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminAuthController extends Controller
{
    /* post request login of admin */
    public function postLogin(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email|string|exists:users,email",
            "password" => "required|string",
        ]);


        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors([
                "errors" => 'The user with the provided email was not found!',
            ]);
        }

        // check if the account has been accepted already or the super admin itself
        if ($user->role !== '2' && $user->role !== '3') {
            return back()->withErrors([
                "errors" => 'Your account has not been accepted by the super admin.
                Please wait for awhile or inform the super admin to accept your account.',
            ]);
        }

        if (Auth::attempt($data, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard.home')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
            "errors" => 'The proivded email or password is incorrect.'
        ]);
    }

    /* log out from account post request */
    public function postLogout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('info', 'Logged out successfully!');
        }

        return redirect()->route('welcome')->with('error', 'An error occurred while trying to log out!');
    }

    /* register admin account post request */
    public function postRegister(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:200",
            "email" => "required|email|string|unique:users,email",
            "description" => "required|string|max:700",
            "password" => ['required', 'confirmed', 'string', Rules\Password::defaults()],
            "password_confirmation" => "required",
            "image" => "required|image|max:5000",
        ]);

        // upload the profile image
        $image = $request->file('image');
        $image_name = random_int(1000000000, 9999999999) . $image->getClientOriginalName();
        $image->move(public_path('/storage/images'), $image_name);

        // create user
        $user = User::create([
            'name' => $request->name,
            'image' => '/storage/images/' . $image_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'description' => $request->description,
        ]);

        return redirect()->route('welcome')->with('success', "Your account has been registered! Please wait for the super admin to accept the account!");
    }
}
