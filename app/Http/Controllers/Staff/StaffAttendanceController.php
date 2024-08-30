<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Attendance;

class StaffAttendanceController extends Controller
{
    public function index()
    {
        $data['set'] = 'attendances';
        return view('staff.attendance.attendances', $data);
    }

    public function get_attendances(Request $request)
    {
        if ($request->ajax()) {
            $where['attendance_staff'] = Auth::guard('staff')->user()->staff_id;
            $data = Attendance::where($where)->orderby('attendance_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {

                    if ($row->attendance_type == 1) {
                        $type = 'Present';
                    } elseif ($row->attendance_type == 2) {
                        $type = 'Absent';
                    } elseif ($row->attendance_type == 3) {
                        $type = 'Half Day';
                    }

                    return $type;
                })
                ->addColumn('attendance_date', function ($row) {

                    $attendance_date = date('d M Y', strtotime($row->attendance_date));

                    return $attendance_date;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="edit_attendance/' . $row->attendance_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_attendance(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'attendance_date' => 'required',
                'attendance_type' => 'required'
            ];

            $messages = [
                'attendance_date.required' => 'Please Select Date',
                'attendance_type.required' => 'Please Select Attendance'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $where_check['attendance_staff'] = Auth::guard('staff')->user()->staff_id;
                $where_check['attendance_date']  = date('Y-m-d', strtotime($request->attendance_date));
                $check_attendance = Attendance::where($where_check)->count();

                if ($check_attendance > 0) {
                    return redirect()->back()->with('error', 'Attendance Already Added For This Selected Date');
                } else {
                    $ins['attendance_staff']      = Auth::guard('staff')->user()->staff_id;
                    $ins['attendance_date']       = date('Y-m-d', strtotime($request->attendance_date));
                    $ins['attendance_type']       = $request->attendance_type;
                    $ins['attendance_notes']      = $request->attendance_notes;
                    $ins['attendance_added_on']   = date('Y-m-d H:i:s');
                    $ins['attendance_added_by']   = Auth::guard('staff')->user()->staff_id;
                    $ins['attendance_updated_on'] = date('Y-m-d H:i:s');
                    $ins['attendance_updated_by'] = Auth::guard('staff')->user()->staff_id;
                    $ins['attendance_status']     = 1;

                    $add = Attendance::create($ins);

                    if ($add) {
                        return redirect()->back()->with('success', 'Attendance Added Successfully');
                    }
                }
            }
        }

        $data['set'] = 'add_attendance';
        return view('staff.attendance.add_attendance', $data);
    }

    public function edit_attendance(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'attendance_date' => 'required',
                'attendance_type' => 'required'
            ];

            $messages = [
                'attendance_date.required' => 'Please Select Date',
                'attendance_type.required' => 'Please Select Attendance'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $where_check['attendance_staff'] = Auth::guard('staff')->user()->staff_id;
                $where_check['attendance_date']  = date('Y-m-d', strtotime($request->attendance_date));
                $check_attendance = Attendance::where($where_check)->where('attendance_id', '!=', $request->segment(3))->count();

                if ($check_attendance > 0) {
                    return redirect()->back()->with('error', 'Attendance Already Added For This Selected Date');
                } else {
                    $upd['attendance_date']       = date('Y-m-d', strtotime($request->attendance_date));
                    $upd['attendance_type']       = $request->attendance_type;
                    $upd['attendance_notes']      = $request->attendance_notes;
                    $upd['attendance_updated_on'] = date('Y-m-d H:i:s');
                    $upd['attendance_updated_by'] = Auth::guard('staff')->user()->staff_id;

                    $add = Attendance::where('attendance_id', $request->segment(3))->update($upd);

                    return redirect()->back()->with('success', 'Attendance Updated Successfully');
                }
            }
        }

        $where_attendance['attendance_staff'] = Auth::guard('staff')->user()->staff_id;
        $where_attendance['attendance_id'] = $request->segment(3);
        $data['attendance'] = Attendance::where($where_attendance)->first();

        if (!isset($data['attendance'])) {
            return redirect('staff/attendances');
        }

        $data['set'] = 'edit_attendance';
        return view('staff.attendance.edit_attendance', $data);
    }
}
