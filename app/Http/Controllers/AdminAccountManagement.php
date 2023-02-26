<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use function PHPSTORM_META\type;

class AdminAccountManagement extends Controller
{
    /* admin acccount accept page */
    public function getAcceptAccounts(Request $request)
    {
        $admins = User::query();

        /* select name similar to search */
        if ($request->search) {
            $admins = $admins->where('name', 'like', "%$request->search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $startdate = Carbon::parse($request->startdate);
            $enddate = Carbon::parse($request->enddate);

            $admins = $admins->whereBetween('created_at', [$startdate, $enddate]);
        }

        /* orderby the admin list according to the selected timeline */
        if ($request->timeline && $request->timeline === "oldest") {
            $admins = $admins->oldest();
        } else {
            $admins = $admins->latest();
        }

        $admins = $admins->select('id', 'name', 'email', 'image', 'role', 'created_at')->where('role', '1')->paginate('10');

        return view('admin.accept-accounts', compact('admins'));
    }

    /* accept the account */
    public function postAcceptAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(["errors" => "User not found!"]);
        }

        $user->role = '2';
        $user->save();

        return back()->with('success', "The admin account $user->name has been accepted!");
    }

    /* decline account */
    public function declineAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(["errors" => "User not found!"]);
        }

        // delete image
        if (File::exists(public_path($user->image))) {
            if ($user->image !== '/default_images/nightkite_logo_transparent.webp') { // if the image is not default image
                File::delete(public_path($user->image));
            }
        }

        $userName = $user->name;
        $user->delete(); // delete user

        return back()->with('info', "The admin account $userName has been declined!");
    }

    /* search accepted admins */
    public function searchAdmin(Request $request)
    {

        $admins = User::query();

        /* select name similar to search */
        if ($request->search) {
            $admins = $admins->where('name', 'like', "%$request->search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $startdate = Carbon::parse($request->startdate);
            $enddate = Carbon::parse($request->enddate);

            $admins = $admins->whereBetween('created_at', [$startdate, $enddate]);
        }

        /* orderby the admin list according to the selected timeline */
        if ($request->timeline && $request->timeline === "oldest") {
            $admins = $admins->oldest();
        } else {
            $admins = $admins->latest();
        }

        $admins = $admins->select('id', 'name', 'email', 'image', 'role', 'created_at')->where('role', '2')->orWhere('role', '3');

        /* 
        Note that the search and date range queires are being repeated 
        in order to also take effect on orWhere('role', '3')
        */

        /* select name similar to search */
        if ($request->search) {
            $admins = $admins->where('name', 'like', "%$request->search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $startdate = Carbon::parse($request->startdate);
            $enddate = Carbon::parse($request->enddate);

            $admins = $admins->whereBetween('created_at', [$startdate, $enddate]);
        }

        /* orderby the admin list according to the selected timeline */
        if ($request->timeline) {
            if ($request->timeline === "oldest") {
                $admins = $admins->oldest();
            } else {
                $admins = $admins->latest();
            }
        }

        $admins = $admins->paginate('10');

        return view('admin.search-accounts', compact('admins'));
    }

    /* deleting accepted admin account */
    public function deleteAdminAccount(Request $request)
    {
        $request->validate([
            "email" => "required|email|string|exists:users,email"
        ]);

        $user = User::where('email', $request->email)->first();

        // if user not found or if the user is super admin then shows error
        if (!$user || $user->role === '3') {
            return back()->with("error", "Delete process failed! Something went wrong!");
        }

        // delete image
        if (File::exists(public_path($user->image))) {
            if ($user->image !== '/default_images/nightkite_logo_transparent.webp') { // if the image is not default image
                File::delete(public_path($user->image));
            }
        }

        $userName = $user->name;
        $user->delete(); // delete user

        return back()->with('info', "The admin account $userName has been deleted!");
    }
}
