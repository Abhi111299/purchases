<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\BookingStaff;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $booking_id = $request->segment(2);
        $staff_id = $request->segment(3);
        $status = $request->segment(4);

        $check_where['bstaff_booking'] = $booking_id;
        $check_where['bstaff_staff'] = $staff_id;
        $check_where['bstaff_status'] = 1;
        $check_booking = BookingStaff::where($check_where)->count();

        if($check_booking == 0)
        {
            return redirect('staff')->with('error','You have already responded to this job.');
        }
        else
        {
            $upd['bstaff_status'] = $status;

            $where['bstaff_booking'] = $booking_id;
            $where['bstaff_staff'] = $staff_id;
            BookingStaff::where($where)->update($upd);

            return redirect('staff');
        }
    }
}