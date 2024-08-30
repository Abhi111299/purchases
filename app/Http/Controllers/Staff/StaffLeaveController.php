<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Auth;
use Validator;
use DataTables;
use App\Models\Staff;
use App\Models\LeaveStaff;
use App\Models\Leave;

class StaffLeaveController extends Controller
{
    public function index()
    {
        $data['set'] = 'leaves';
        return view('staff.leave.leaves', $data);
    }

    public function get_leaves(Request $request)
    {
        if ($request->ajax()) {
            $where['leave_staff'] = Auth::guard('staff')->user()->staff_id;
            $data = Leave::where($where)->orderby('leave_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {

                    if ($row->leave_type == 1) {
                        $type = 'Sick Leave';
                    } elseif ($row->leave_type == 2) {
                        $type = 'Annual Leave';
                    } elseif ($row->leave_type == 3) {
                        $type = 'Parental Leave';
                    } elseif ($row->leave_type == 4) {
                        $type = 'Long Service Leave';
                    } elseif ($row->leave_type == 5) {
                        $type = 'Other';
                    }

                    return $type;
                })
                ->addColumn('apply_date', function ($row) {

                    $apply_date = date('d M Y', strtotime($row->leave_date));

                    return $apply_date;
                })
                ->addColumn('start_date', function ($row) {

                    $start_date = date('d M Y', strtotime($row->leave_sdate));

                    return $start_date;
                })
                ->addColumn('return_date', function ($row) {

                    $return_date = date('d M Y', strtotime($row->leave_wdate));

                    return $return_date;
                })
                ->addColumn('status', function ($row) {

                    if ($row->leave_status == 1) {
                        $status = 'Pending';
                    } elseif ($row->leave_status == 2) {
                        $status = 'Approved';
                    } elseif ($row->leave_status == 3) {
                        $status = 'Rejected';
                    }

                    return $status;
                })
                ->addColumn('action', function ($row) {

                    $btn = '';

                    if ($row->leave_status == 1) {
                        $btn = '<a href="edit_leave/' . $row->leave_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_leave(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'leave_type' => 'required',
                'leave_date' => 'required',
                'leave_reason' => 'required',
                'leave_sdate' => 'required',
                'leave_wdate' => 'required'
            ];

            $messages = [
                'leave_type.required' => 'Please Select Type',
                'leave_date.required' => 'Please Select Apply Date',
                'leave_reason.required' => 'Please Enter Reason',
                'leave_sdate.required' => 'Please Select Leave Start Date',
                'leave_wdate.required' => 'Please Select Returning to Work'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['leave_staff']      = Auth::guard('staff')->user()->staff_id;
                $ins['leave_type']       = $request->leave_type;
                $ins['leave_date']       = date('Y-m-d', strtotime($request->leave_date));
                $ins['leave_sdate']      = date('Y-m-d', strtotime($request->leave_sdate));
                $ins['leave_wdate']      = date('Y-m-d', strtotime($request->leave_wdate));
                $ins['leave_reason']     = $request->leave_reason;
                $ins['leave_added_on']   = date('Y-m-d H:i:s');
                $ins['leave_added_by']   = Auth::guard('staff')->user()->staff_id;
                $ins['leave_updated_on'] = date('Y-m-d H:i:s');
                $ins['leave_updated_by'] = Auth::guard('staff')->user()->staff_id;
                $ins['leave_status']     = 1;
                $ins['leave_trash']      = 1;

                $add = Leave::create($ins);

                if ($add) {
                    $data['type'] = $request->leave_type;
                    $data['apply_date'] = date('d M Y', strtotime($request->leave_date));
                    $data['start_date'] = date('d M Y', strtotime($request->leave_sdate));
                    $data['return_date'] = date('d M Y', strtotime($request->leave_wdate));
                    $data['reason'] = $request->leave_reason;

                    $leave_staffs = $request->leave_request;

                    if (!empty($leave_staffs)) {
                        foreach ($leave_staffs as $leave_staff) {
                            $ins_lstaff['lstaff_leave']      = $add->leave_id;
                            $ins_lstaff['lstaff_staff']      = $leave_staff;
                            $ins_lstaff['lstaff_added_on']   = date('Y-m-d H:i:s');
                            $ins_lstaff['lstaff_added_by']   = Auth::guard('staff')->user()->staff_id;
                            $ins_lstaff['lstaff_updated_on'] = date('Y-m-d H:i:s');
                            $ins_lstaff['lstaff_updated_by'] = Auth::guard('staff')->user()->staff_id;
                            $ins_lstaff['lstaff_status']     = 1;

                            LeaveStaff::create($ins_lstaff);
                        }

                        $get_staffs = Staff::whereIn('staff_id', $leave_staffs)->get();

                        foreach ($get_staffs as $get_staff) {
                            $data['staff_id'] = $get_staff->staff_id;

                            $mail  = $get_staff->staff_email;
                            $uname = $get_staff->staff_fname . ' ' . $get_staff->staff_lname;

                            $subject = 'New Leave Request';

                            $send = Mail::send('staff.mail.apply_leave', $data, function ($message) use ($mail, $uname, $subject) {
                                $message->to($mail, $uname)->subject($subject);
                                $message->from(config('constants.mail_from'), config('constants.site_title'));
                            });
                        }
                    }

                    return redirect()->back()->with('success', 'Leave Added Successfully');
                }
            }
        }

        $where_staff['staff_role'] = 1;
        $where_staff['staff_status'] = 1;
        $data['staffs'] = Staff::where($where_staff)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'add_leave';
        return view('staff.leave.add_leave', $data);
    }

    public function edit_leave(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'leave_type' => 'required',
                'leave_date' => 'required',
                'leave_reason' => 'required',
                'leave_sdate' => 'required',
                'leave_wdate' => 'required'
            ];

            $messages = [
                'leave_type.required' => 'Please Select Type',
                'leave_date.required' => 'Please Select Apply Date',
                'leave_reason.required' => 'Please Enter Reason',
                'leave_sdate.required' => 'Please Select Leave Start Date',
                'leave_wdate.required' => 'Please Select Returning to Work'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['leave_type']       = $request->leave_type;
                $upd['leave_date']       = date('Y-m-d', strtotime($request->leave_date));
                $upd['leave_sdate']      = date('Y-m-d', strtotime($request->leave_sdate));
                $upd['leave_wdate']      = date('Y-m-d', strtotime($request->leave_wdate));
                $upd['leave_reason']     = $request->leave_reason;
                $upd['leave_updated_on'] = date('Y-m-d H:i:s');
                $upd['leave_updated_by'] = Auth::guard('staff')->user()->staff_id;

                $add = Leave::where('leave_id', $request->segment(3))->update($upd);

                LeaveStaff::where('lstaff_leave', $request->segment(3))->delete();

                $leave_staffs = $request->leave_request;

                if (!empty($leave_staffs)) {
                    foreach ($leave_staffs as $leave_staff) {
                        $ins_lstaff['lstaff_leave']      = $request->segment(3);
                        $ins_lstaff['lstaff_staff']      = $leave_staff;
                        $ins_lstaff['lstaff_added_on']   = date('Y-m-d H:i:s');
                        $ins_lstaff['lstaff_added_by']   = Auth::guard('staff')->user()->staff_id;
                        $ins_lstaff['lstaff_updated_on'] = date('Y-m-d H:i:s');
                        $ins_lstaff['lstaff_updated_by'] = Auth::guard('staff')->user()->staff_id;
                        $ins_lstaff['lstaff_status']     = 1;

                        LeaveStaff::create($ins_lstaff);
                    }
                }

                return redirect()->back()->with('success', 'Leave Updated Successfully');
            }
        }

        $data['leave'] = Leave::where('leave_id', $request->segment(3))->first();

        if (!isset($data['leave'])) {
            return redirect('staff/leaves');
        }

        $leave_staffs = LeaveStaff::where('lstaff_leave', $data['leave']->leave_id)->get();
        if ($leave_staffs->count() > 0) {
            $data['requested_staffs'] = array_column($leave_staffs->toArray(), 'lstaff_staff');
        }
dd($data['requested_staffs']);
        $where_staff['staff_role'] = 1;
        $where_staff['staff_status'] = 1;
        $data['staffs'] = Staff::where($where_staff)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'edit_leave';
        return view('staff.leave.edit_leave', $data);
    }
}
