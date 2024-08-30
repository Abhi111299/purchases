<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Location;
use App\Models\Customer;
use App\Models\Timesheet;

class StaffTimesheetController extends Controller
{
    public function index()
    {
        $data['set'] = 'timesheets';
        return view('staff.timesheet.timesheets', $data);
    }

    public function get_timesheets(Request $request)
    {
        if ($request->ajax()) {
            $where['timesheet_staff'] = Auth::guard('staff')->user()->staff_id;
            $data = Timesheet::getStaffDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {

                    if ($row->timesheet_wtype == 1) {
                        $status = 'Work';
                    } elseif ($row->timesheet_wtype == 2) {
                        $status = 'Sick Leave';
                    } elseif ($row->timesheet_wtype == 3) {
                        $status = 'Annual Leave';
                    } elseif ($row->timesheet_wtype == 4) {
                        $status = 'Training';
                    } elseif ($row->timesheet_wtype == 5) {
                        $status = 'Travelling';
                    } elseif ($row->timesheet_wtype == 6) {
                        $status = 'Saturday Holiday';
                    } elseif ($row->timesheet_wtype == 7) {
                        $status = 'Sunday Holiday';
                    } elseif ($row->timesheet_wtype == 8) {
                        $status = 'Public Holiday';
                    } elseif ($row->timesheet_wtype == 9) {
                        $status = 'Others';
                    }

                    return $status;
                })
                ->addColumn('timesheet_date', function ($row) {

                    $timesheet_date = date('d M Y', strtotime($row->timesheet_date));

                    return $timesheet_date;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="edit_timesheet/' . $row->timesheet_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_timesheet(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'timesheet_date' => 'required',
                'timesheet_wtype' => 'required'
            ];

            $messages = [
                'timesheet_date.required' => 'Please Select Date',
                'timesheet_wtype.required' => 'Please Select Status'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $where_check['timesheet_staff'] = Auth::guard('staff')->user()->staff_id;
                $where_check['timesheet_date']  = date('Y-m-d', strtotime($request->timesheet_date));
                $check_timesheet = Timesheet::where($where_check)->count();

                if ($check_timesheet > 0) {
                    return redirect()->back()->with('error', 'Timesheet Already Added For This Selected Date');
                } else {
                    $ins['timesheet_staff']      = Auth::guard('staff')->user()->staff_id;
                    $ins['timesheet_date']       = date('Y-m-d', strtotime($request->timesheet_date));
                    $ins['timesheet_wtype']      = $request->timesheet_wtype;
                    $ins['timesheet_client']     = $request->timesheet_client;
                    $ins['timesheet_desc']       = $request->timesheet_desc;
                    $ins['timesheet_location']   = $request->timesheet_location;
                    $ins['timesheet_added_on']   = date('Y-m-d H:i:s');
                    $ins['timesheet_added_by']   = Auth::guard('staff')->user()->staff_id;
                    $ins['timesheet_updated_on'] = date('Y-m-d H:i:s');
                    $ins['timesheet_updated_by'] = Auth::guard('staff')->user()->staff_id;
                    $ins['timesheet_status']     = 1;

                    if (!empty($request->timesheet_start)) {
                        $ins['timesheet_start'] = date('H:i', strtotime($request->timesheet_start));
                    } else {
                        $ins['timesheet_start'] = NULL;
                    }

                    if (!empty($request->timesheet_end)) {
                        $ins['timesheet_end'] = date('H:i', strtotime($request->timesheet_end));
                    } else {
                        $ins['timesheet_end'] = NULL;
                    }

                    $add = Timesheet::create($ins);

                    if ($add) {
                        return redirect()->back()->with('success', 'Timesheet Added Successfully');
                    }
                }
            }
        }

        $data['customers'] = Customer::where('customer_status', 1)->orderby('customer_name', 'asc')->get();

        $data['locations'] = Location::where('location_status', 1)->orderby('location_name', 'asc')->get();

        $data['set'] = 'add_timesheet';
        return view('staff.timesheet.add_timesheet', $data);
    }

    public function edit_timesheet(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'timesheet_date' => 'required',
                'timesheet_wtype' => 'required'
            ];

            $messages = [
                'timesheet_date.required' => 'Please Select Date',
                'timesheet_wtype.required' => 'Please Select Status'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $where_check['timesheet_staff'] = Auth::guard('staff')->user()->staff_id;
                $where_check['timesheet_date']  = date('Y-m-d', strtotime($request->timesheet_date));
                $check_timesheet = Timesheet::where($where_check)->where('timesheet_id', '!=', $request->segment(3))->count();

                if ($check_timesheet > 0) {
                    return redirect()->back()->with('error', 'Timesheet Already Added For This Selected Date');
                } else {
                    $upd['timesheet_date']       = date('Y-m-d', strtotime($request->timesheet_date));
                    $upd['timesheet_wtype']      = $request->timesheet_wtype;
                    $upd['timesheet_client']     = $request->timesheet_client;
                    $upd['timesheet_desc']       = $request->timesheet_desc;
                    $upd['timesheet_location']   = $request->timesheet_location;
                    $upd['timesheet_updated_on'] = date('Y-m-d H:i:s');
                    $upd['timesheet_updated_by'] = Auth::guard('staff')->user()->staff_id;

                    if (!empty($request->timesheet_start)) {
                        $upd['timesheet_start'] = date('H:i', strtotime($request->timesheet_start));
                    } else {
                        $upd['timesheet_start'] = NULL;
                    }

                    if (!empty($request->timesheet_end)) {
                        $upd['timesheet_end'] = date('H:i', strtotime($request->timesheet_end));
                    } else {
                        $upd['timesheet_end'] = NULL;
                    }

                    $add = Timesheet::where('timesheet_id', $request->segment(3))->update($upd);

                    return redirect()->back()->with('success', 'Timesheet Updated Successfully');
                }
            }
        }

        $where_timesheet['timesheet_staff'] = Auth::guard('staff')->user()->staff_id;
        $where_timesheet['timesheet_id'] = $request->segment(3);
        $data['timesheet'] = Timesheet::where($where_timesheet)->first();

        if (!isset($data['timesheet'])) {
            return redirect('staff/timesheets');
        }

        $data['customers'] = Customer::where('customer_status', 1)->orderby('customer_name', 'asc')->get();

        $data['locations'] = Location::where('location_status', 1)->orderby('location_name', 'asc')->get();

        $data['set'] = 'edit_timesheet';
        return view('staff.timesheet.edit_timesheet', $data);
    }
}
