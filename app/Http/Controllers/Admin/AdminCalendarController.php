<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Activity;
use App\Models\Staff;
use App\Models\Booking;

class AdminCalendarController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array('6', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $where['booking_added_by'] = Auth::guard('admin')->user()->admin_id;
            }

            $where['booking_trash'] = 1;
            $data = Booking::join('services', 'services.service_id', 'bookings.booking_service')
                ->join('customers', 'customers.customer_id', 'bookings.booking_customer')
                ->whereDate('booking_start', '>=', $request->start)
                ->whereDate('booking_end',   '<=', $request->end)
                ->where($where)
                ->get(['booking_id as id', 'customer_name as title', 'booking_start as start', 'booking_end as end']);

            return response()->json($data);
        }

        $data['set'] = 'calendar';
        return view('admin.calendar.calendar', $data);
    }

    public function booking_detail(Request $request)
    {
        $where['booking_id'] = $request->booking_id;
        $data['booking'] = $booking = Booking::getDetail($where);
        $data['activities'] = "";
        $data['staffs'] = "";

        $activity_arr = json_decode($booking->booking_activities, true);

        $get_activities = Activity::whereIn('activity_id', $activity_arr)->get();

        $activities = array_column($get_activities->toArray(), 'activity_name');
        if ($activities)
            $data['activities'] = implode(',', $activities);

        $staff_arr = json_decode($booking->booking_staffs, true);
        if ($staff_arr) {

            $get_staffs = Staff::whereIn('staff_id', $staff_arr)->get();

            $staffs = array_column($get_staffs->toArray(), 'staff_name');
            $data['staffs'] = implode(',', $staffs);
        }

        return view('admin.calendar.booking_detail', $data);
    }
}
