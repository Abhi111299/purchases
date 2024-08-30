<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Excel;
use Validator;
use DataTables;
use App\Exports\AttendanceExport;
use App\Models\Staff;
use App\Models\Attendance;

class AdminAttendanceController extends Controller
{
    public function index()
    {
        if (!in_array('13', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['staffs'] = Staff::orderby('staff_fname')->get();

        $data['set'] = 'attendances';
        return view('admin.attendance.attendances', $data);
    }

    public function get_attendances(Request $request)
    {
        if ($request->ajax()) {
            $where = 'attendance_status = 1';

            if (!empty($request->staff_id)) {
                $where .= ' AND staff_id = ' . $request->staff_id;
            }

            if (!empty($request->from_date)) {
                $from_date = '"' . date('Y-m-d', strtotime($request->from_date)) . '"';

                $where .= ' AND attendance_date >= ' . $from_date;
            }

            if (!empty($request->to_date)) {
                $to_date = '"' . date('Y-m-d', strtotime($request->to_date)) . '"';

                $where .= ' AND attendance_date <= ' . $to_date;
            }

            $data = Attendance::getWhereDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = $row->staff_fname . ' ' . $row->staff_lname;

                    return $staff_name;
                })
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

                    $btn = '<a href="/admin/edit_attendance/' . $row->attendance_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function attendance_download_excel(Request $request)
    {
        $filename = 'attendance_' . date('Y_m_d_H_i_s') . '.xlsx';

        return Excel::download(new AttendanceExport($request->staff_id, $request->from_date, $request->to_date), $filename);
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
                $where_check['attendance_staff'] = $request->attendance_staff;
                $where_check['attendance_date']  = date('Y-m-d', strtotime($request->attendance_date));
                $check_attendance = Attendance::where($where_check)->where('attendance_id', '!=', $request->segment(3))->count();

                if ($check_attendance > 0) {
                    return redirect()->back()->with('error', 'Attendance Already Added For This Selected Date');
                } else {
                    $upd['attendance_date']       = date('Y-m-d', strtotime($request->attendance_date));
                    $upd['attendance_type']       = $request->attendance_type;
                    $upd['attendance_notes']      = $request->attendance_notes;
                    $upd['attendance_updated_on'] = date('Y-m-d H:i:s');
                    $upd['attendance_updated_by'] = Auth::guard('admin')->user()->admin_id;

                    $add = Attendance::where('attendance_id', $request->segment(3))->update($upd);

                    return redirect()->back()->with('success', 'Attendance Updated Successfully');
                }
            }
        }

        $where_attendance['attendance_id'] = $request->segment(3);
        $data['attendance'] = Attendance::getDetail($where_attendance);

        if (!isset($data['attendance'])) {
            return redirect('admin/attendances');
        }

        if (!in_array('13', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'edit_attendance';
        return view('admin.attendance.edit_attendance', $data);
    }
}
