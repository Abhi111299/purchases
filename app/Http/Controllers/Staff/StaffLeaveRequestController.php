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

class StaffLeaveRequestController extends Controller
{
    public function index()
    {
        $data['set'] = 'leave_requests';
        return view('staff.leave_request.leave_requests',$data);
    }

    public function get_leave_requests(Request $request)
    {
        if($request->ajax())
        {
            $where['lstaff_staff'] = Auth::guard('staff')->user()->staff_id;
            $data = Leave::getDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('staff_name', function($row){
                                                
                        $staff = Staff::where('staff_id',$row->leave_staff)->first();

                        return $staff->staff_fname.' '.$staff->staff_lname;
                    })
                    ->addColumn('type', function($row){
                                                
                        if($row->leave_type == 1)
                        {
                            $type = 'Sick Leave';
                        }
                        elseif($row->leave_type == 2)
                        {
                            $type = 'Annual Leave';
                        }
                        elseif($row->leave_type == 3)
                        {
                            $type = 'Parental Leave';
                        }
                        elseif($row->leave_type == 4)
                        {
                            $type = 'Long Service Leave';
                        }
                        elseif($row->leave_type == 5)
                        {
                            $type = 'Other';
                        }

                        return $type;
                    })
                    ->addColumn('apply_date', function($row){
                                                
                        $apply_date = date('d M Y',strtotime($row->leave_date));

                        return $apply_date;
                    })
                    ->addColumn('start_date', function($row){
                                                
                        $start_date = date('d M Y',strtotime($row->leave_sdate));

                        return $start_date;
                    })
                    ->addColumn('return_date', function($row){
                                                
                        $return_date = date('d M Y',strtotime($row->leave_wdate));

                        return $return_date;
                    })
                    ->addColumn('status', function($row){
                                                
                        if($row->leave_status == 1)
                        {
                            $status = 'Pending';
                        }
                        elseif($row->leave_status == 2)
                        {
                            $status = 'Approved';
                        }
                        elseif($row->leave_status == 3)
                        {
                            $status = 'Rejected';
                        }

                        return $status;
                    })
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm" title="Status" onclick="leave_status('.$row->leave_id.')"><i class="fa fa-check-circle"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function leave_requests_status(Request $request)
    {
        $data['leave'] = Leave::where('leave_id',$request->leave_id)->first();

        return view('staff.leave_request.leave_requests_status',$data);
    }

    public function add_leave_requests_status(Request $request)
    {
        if($request->has('submit'))
        {
            $upd['leave_status'] = $request->status;
            Leave::where('leave_id',$request->leave_id)->update($upd);

            if($request->status == 1)
            {
                $data['status'] = 'Pending';
            }
            elseif($request->status == 2)
            {
                $data['status'] = 'Approved';
            }
            elseif($request->status == 3)
            {
                $data['status'] = 'Rejected';
            }

            $data['leave'] = $leave = Leave::where('leave_id',$request->leave_id)->first();
            $staff = Staff::where('staff_id',$leave->leave_staff)->first();

            $mail  = $staff->staff_email;

            $uname = $data['name'] = $staff->staff_name;

            $send = Mail::send('staff.mail.leave_status', $data, function($message) use ($mail, $uname){
                    $message->to($mail, $uname)->subject(config('constants.site_title').' - Leave Status Changed');
                    $message->from(config('constants.mail_from'),config('constants.site_title'));
                });

            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }
}