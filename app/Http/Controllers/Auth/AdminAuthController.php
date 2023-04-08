<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

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

        // optimize the uploaded image
        $image_path = public_path('/storage/images/') . $image_name;
        $img = Image::make($image_path); // creates a new image source using image intervention package
        $img->save($image_path, 50); // save the image with a medium quality

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

    /**
     * show update profile page
     */
    public function updateProfile()
    {
        return view('auth.admin.profile-update');
    }

    /**
     * update the profile info of the current user
     */
    public function postUpdateProfile(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:200|unique:users,name," . Auth::user()->id,
            "email" => "required|email|string|unique:users,email," . Auth::user()->id,
            "description" => "required|string|max:700",
            "password" => "required|string",
            "image" => "nullable|image|max:5000"
        ]);

        // checks if the password matches the the current user's password
        if (Gate::denies('password-auth', $request->password)) {
            return redirect()->back()->withErrors([
                "passwordError" => "Wrong password!"
            ]);
        }

        //if the password auth succeeds

        $image_path = Auth::user()->image;

        // if there is image in request
        if ($request->hasFile('image')) {

            if (Auth::user()->image !== "/default_images/nightkite_logo_transparent.webp") {
                // if the image is not the default one, deletes it

                if (File::exists(public_path($image_path))) {
                    // if file exists delete it
                    File::delete(public_path($image_path));
                }
            }

            // upload the profile image
            $image = $request->file('image');
            $image_name = random_int(1000000000, 9999999999) . $image->getClientOriginalName();
            $image->move(public_path('/storage/images'), $image_name);

            // optimize the uploaded image
            $image_local_path = public_path('/storage/images/') . $image_name;
            $img = Image::make($image_local_path); // creates a new image source using image intervention package
            $img->save($image_local_path, 50); // save the image with a medium quality
            $image_path = "/storage/images/" . $image_name; //update the image path
        }

        // update user info
        Auth::user()->update([
            "name" => $request->name,
            "email" => $request->email,
            "description" => $request->description,
            "image" => $image_path
        ]);

        return redirect()->back()->with("success", "User information has been updated!");
    }

    /**
     * change the passsword of the current user
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            "new_password" => ['required', 'confirmed', 'string', Rules\Password::defaults()],
            "new_password_confirmation" => "required|string",
            "password" => "required|string"
        ]);

        // checks if the password matches the the current user's password
        if (Gate::denies('password-auth', $request->password)) {
            return redirect()->back()->withErrors([
                "passwordError" => "Wrong password!"
            ]);
        }

        // update the password
        Auth::user()->update([
            "password" => Hash::make($request->new_password)
        ]);

        return redirect()->route('admin.dashboard.profile')->with("success", "Password has been changed!");
    }
}
