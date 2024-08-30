<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\BookingStaff;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Activity;
use App\Models\Booking;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $where_pending['booking_status'] = 1;
        $data['pending_bookings'] = Booking::where($where_pending)->count();

        $where_cancel['booking_status'] = 2;
        $data['cancelled_bookings'] = Booking::where($where_cancel)->count();

        $where_incomplete['booking_status'] = 3;
        $data['incomplete_bookings'] = Booking::where($where_incomplete)->count();

        $where_report['booking_status'] = 4;
        $data['report_bookings'] = Booking::where($where_report)->count();

        $where_complete['booking_status'] = 5;
        $data['completed_bookings']   = Booking::where($where_complete)->count();

        $where_reschedule['booking_status'] = 6;
        $data['rescheduled_bookings'] = Booking::where($where_reschedule)->count();

        $data['total_bookings'] = Booking::count();

        $bookings = Booking::selectRaw('MONTH(booking_start) as month, COUNT(booking_id) as total')
            ->whereYear('booking_start', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Ensure all months are represented
        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        $monthWiseData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthWiseData[] = [
                'month' => $monthNames[$month],
                'total' => $bookings[$month] ?? 0 // Use 0 if the month is not in the result
            ];
        }

        $data['month_wise'] = $monthWiseData;

        $data['set'] = 'dashboard';
        return view('admin.dashboard.dashboard', $data);
    }

    public function get_today_bookings(Request $request)
    {
        if ($request->ajax()) {
            $where_today = 'booking_trash = 1 AND booking_start >= "' . date('Y-m-d 00:00:00') . '" AND booking_start <= "' . date('Y-m-d 23:59:59') . '"';

            $data = Booking::getWhereDetails($where_today);
            // echo "<pre>";
            // print_r($data);
            // die;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('booking_job_id', function ($row) {

                    $booking_job = "<a href='view_booking/$row->booking_id'>$row->booking_job_id</a>";

                    return $booking_job;
                })
                ->addColumn('booking_start', function ($row) {

                    $booking_start = date('d M Y h:i A', strtotime($row->booking_start));

                    return $booking_start;
                })
                ->addColumn('booking_start', function ($row) {

                    $booking_start = date('d M Y h:i A', strtotime($row->booking_start));

                    return $booking_start;
                })
                ->addColumn('booking_end', function ($row) {

                    $booking_end = date('d M Y h:i A', strtotime($row->booking_end));

                    return $booking_end;
                })
                ->addColumn('activities', function ($row) {

                    $activity_arr = json_decode($row->booking_activities, true);

                    $get_activities = Activity::whereIn('activity_id', $activity_arr)->get();

                    $activities = array_column($get_activities->toArray(), 'activity_name');
                    $activities = implode(',', $activities);

                    return $activities;
                })
                ->addColumn('technicians', function ($row) {

                    $booking_staffs = BookingStaff::where('bstaff_booking', $row->booking_id)->join('staffs', 'staffs.staff_id', 'booking_staffs.bstaff_staff')->get();

                    $staffs = array();

                    if ($booking_staffs->count() > 0) {
                        foreach ($booking_staffs as $booking_staff) {
                            if ($booking_staff->bstaff_status == 1) {
                                $status = 'Pending';
                            } elseif ($booking_staff->bstaff_status == 2) {
                                $status = 'Confirm';
                            } elseif ($booking_staff->bstaff_status == 3) {
                                $status = 'Not Confirm';
                            } elseif ($booking_staff->bstaff_status == 4) {
                                $status = 'Sick Leave';
                            } elseif ($booking_staff->bstaff_status == 5) {
                                $status = 'Annual Leave';
                            }

                            $new_staff = '<div class="d-flex align-items-center">';
                            $new_staff .= '<div><img src="' . ($booking_staff->staff_image ? asset(config("constants.admin_path") . 'uploads/profile/' . $booking_staff->staff_image) : asset(config("constants.admin_path") . "dist/img/no_image.png")) . '" style="min-width:40px;min-height:40px; width:40px; height:40px" class="img-thumbnail object-fit-cover rounded-circle">&nbsp;&nbsp;</div>';
                            $new_staff .= '<div><div  style="white-space:nowrap">' . $booking_staff->staff_fname . ' &nbsp;</div> ' . $booking_staff->staff_lname . ' <br> <span class="badge rounded-pill text-bg-secondary">' . $status . '</span></div></div>';
                            $staffs[] = $new_staff;
                        }
                    }

                    $staffs = implode(',<br> ', $staffs);

                    return $staffs;
                })
                ->addColumn('status', function ($row) {

                    if ($row->booking_status == 1) {
                        $status = 'Pending';
                        $status_bg = "text-bg-info";
                    } elseif ($row->booking_status == 2) {
                        $status = 'Cancelled';
                        $status_bg = "text-bg-danger";
                    } elseif ($row->booking_status == 3) {
                        $status = 'Incomplete';
                        $status_bg = "text-bg-dark";
                    } elseif ($row->booking_status == 4) {
                        $status = 'Report Pending';
                        $status_bg = "text-bg-secondary";
                    } elseif ($row->booking_status == 5) {
                        $status = 'Completed';
                        $status_bg = "text-bg-success";
                    } else {
                        $status = 'Rescheduled';
                        $status_bg = "text-bg-primary";
                    }

                    return '<a href="javascript:void(0)" class="badge ' . $status_bg . '" title="Status" onclick="booking_status(' . $row->booking_id . ')">' . $status . "</a>";
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    // $btn .= '<a href="javascript:void(0)" class="btn btn-warning btn-sm rounded-circle" title="Status" onclick="booking_status(' . $row->booking_id . ')"><i class="fa fa-check-circle"></i></a> ';

                    $btn .= '<a href="edit_booking/' . $row->booking_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    return $btn . "</div>";
                })
                ->rawColumns(['booking_job_id', 'action', 'status', 'technicians'])
                ->make(true);
        }
    }
}
