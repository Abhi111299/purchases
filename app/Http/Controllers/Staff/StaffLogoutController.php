<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class StaffLogoutController extends Controller
{
    public function index(Request $request)
    {
        Auth::guard('staff')->logout();

        return redirect('staff');
    }
}
