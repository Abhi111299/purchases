<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class StaffDashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'dashboard';
        return view('staff.dashboard.dashboard',$data);
    }
}