<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminAccountManagement extends Controller
{
    /* admin acccount accept page */
    public function getAcceptAccounts(Request $request)
    {
        $admins = User::select('id', 'name', 'email', 'image', 'role')->where('role', '1')->paginate('10');

        return view('admin.accept-accounts', compact('admins'));
    }
}
