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
        $search = "";
        $reqStartDate = "";
        $reqEndDate = "";

        $admins = User::query();

        /* select name similar to search */
        if ($request->search) {
            $search = $request->search;
            $admins = $admins->where('name', 'like', "%$search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $reqStartDate = $request->startdate;
            $reqEndDate = $request->enddate;

            $startdate = Carbon::parse($reqStartDate);
            $enddate = Carbon::parse($reqEndDate);

            $admins = $admins->whereBetween('created_at', [$startdate, $enddate]);
        }

        $admins = $admins->select('id', 'name', 'email', 'image', 'role')->where('role', '1')->paginate('10');

        return view('admin.accept-accounts', compact('admins', 'search', 'reqStartDate', 'reqEndDate'));
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
        $search = "";
        $reqStartDate = "";
        $reqEndDate = "";

        $admins = User::query();

        /* select name similar to search */
        if ($request->search) {
            $search = $request->search;
            $admins = $admins->where('name', 'like', "%$search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $reqStartDate = $request->startdate;
            $reqEndDate = $request->enddate;

            $startdate = Carbon::parse($reqStartDate);
            $enddate = Carbon::parse($reqEndDate);

            $admins = $admins->whereBetween('created_at', [$startdate, $enddate]);
        }

        $admins = $admins->select('id', 'name', 'email', 'image', 'role')->where('role', '2')->orWhere('role', '3');

        /* 
        Note that the search and date range queires are being repeated 
        in order to also take effect on orWhere('role', '3')
        */
    
        /* select name similar to search */
        if ($request->search) {
            $search = $request->search;
            $admins = $admins->where('name', 'like', "%$search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $reqStartDate = $request->startdate;
            $reqEndDate = $request->enddate;

            $startdate = Carbon::parse($reqStartDate);
            $enddate = Carbon::parse($reqEndDate);

            $admins = $admins->whereBetween('created_at', [$startdate, $enddate]);
        }

        $admins = $admins->paginate('10');
        

        return view('admin.search-accounts', compact('admins', 'search', 'reqStartDate', 'reqEndDate'));
    }
}
