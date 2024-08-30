<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Mail;
use Validator;
use App\Models\Staff;
use App\Models\Leave;
use App\Models\LeaveStaff;
   
class StaffLeaveController extends BaseController
{
    public function index(Request $request)
    {
        $where['leave_staff'] = $request->user()->staff_id;
        $leaves = Leave::where($where)->orderby('leave_id','desc')->get();

        if($leaves->count() > 0)
        {
            foreach($leaves as $leave)
            {
                if($leave->leave_type == 1)
                {
                    $type = 'Sick Leave';
                }
                elseif($leave->leave_type == 2)
                {
                    $type = 'Annual Leave';
                }
                elseif($leave->leave_type == 3)
                {
                    $type = 'Parental Leave';
                }
                elseif($leave->leave_type == 4)
                {
                    $type = 'Long Service Leave';
                }
                elseif($leave->leave_type == 5)
                {
                    $type = 'Other';
                }

                if($leave->leave_status == 1)
                {
                    $status = 'Pending';
                }
                elseif($leave->leave_status == 2)
                {
                    $status = 'Approved';
                }
                elseif($row->leave_status == 3)
                {
                    $status = 'Rejected';
                }

                $result[] = array('id'=>$leave->leave_id,'type'=>$type,'apply_date'=>date('d M Y',strtotime($leave->leave_date)),'start_date'=>date('d M Y',strtotime($leave->leave_sdate)),'return_date'=>date('d M Y',strtotime($leave->leave_wdate)),'reason'=>$leave->leave_reason,'status'=>$status);
            }

            return $this->sendResponse($result, 'Leave List');
        }
        else
        {
            return $this->sendError('Leaves Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_leave(Request $request)
    {
        $rules = ['type' => 'required',
                  'apply_date' => 'required',
                  'reason' => 'required',
                  'start_date' => 'required',
                  'return_date' => 'required'
                 ];
    
        $messages = ['type.required' => 'Please Select Type',
                     'apply_date.required' => 'Please Select Apply Date',
                     'reason.required' => 'Please Enter Reason',
                     'start_date.required' => 'Please Select Leave Start Date',
                     'return_date.required' => 'Please Select Returning to Work'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['leave_staff']      = $request->user()->staff_id;
            $ins['leave_type']       = $request->type;
            $ins['leave_date']       = date('Y-m-d',strtotime($request->apply_date));
            $ins['leave_sdate']      = date('Y-m-d',strtotime($request->start_date));
            $ins['leave_wdate']      = date('Y-m-d',strtotime($request->return_date));
            $ins['leave_reason']     = $request->reason;
            $ins['leave_added_on']   = date('Y-m-d H:i:s');
            $ins['leave_added_by']   = $request->user()->staff_id;
            $ins['leave_updated_on'] = date('Y-m-d H:i:s');
            $ins['leave_updated_by'] = $request->user()->staff_id;
            $ins['leave_status']     = 1;
            $ins['leave_trash']      = 1;

            $add = Leave::create($ins);

            if($add)
            {
                $data['type'] = $request->type;
                $data['apply_date'] = date('d M Y',strtotime($request->apply_date));
                $data['start_date'] = date('d M Y',strtotime($request->start_date));
                $data['return_date'] = date('d M Y',strtotime($request->return_date));
                $data['reason'] = $request->reason;

                $managers = $request->manager;

                if(!empty($managers))
                {
                    foreach($managers as $manager)
                    {
                        $ins_lstaff['lstaff_leave']      = $add->leave_id;
                        $ins_lstaff['lstaff_staff']      = $manager;
                        $ins_lstaff['lstaff_added_on']   = date('Y-m-d H:i:s');
                        $ins_lstaff['lstaff_added_by']   = $request->user()->staff_id;
                        $ins_lstaff['lstaff_updated_on'] = date('Y-m-d H:i:s');
                        $ins_lstaff['lstaff_updated_by'] = $request->user()->staff_id;
                        $ins_lstaff['lstaff_status']     = 1;

                        LeaveStaff::create($ins_lstaff);
                    }

                    $get_staffs = Staff::whereIn('staff_id',$managers)->get();

                    foreach($get_staffs as $get_staff)
                    {
                        $data['staff_id'] = $get_staff->staff_id;

                        $mail  = $get_staff->staff_email;
                        $uname = $get_staff->staff_fname.' '.$get_staff->staff_lname;
                        
                        $subject = 'New Leave Request';

                        $send = Mail::send('staff.mail.apply_leave', $data, function($message) use ($mail, $uname, $subject){
                            $message->to($mail, $uname)->subject($subject);
                            $message->from(config('constants.mail_from'),config('constants.site_title'));
                        });
                    }
                }

                $result = array('leave_id' => $add->leave_id);

                return $this->sendResponse($result, 'Leave Added Successfully');
            }
            else
            {
                return $this->sendError('Leave Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function leave_detail(Request $request)
    {
        $leave = Leave::where('leave_id',$request->segment(3))->first();

        if(isset($leave))
        {
            if($leave->leave_type == 1)
            {
                $type = 'Sick Leave';
            }
            elseif($leave->leave_type == 2)
            {
                $type = 'Annual Leave';
            }
            elseif($leave->leave_type == 3)
            {
                $type = 'Parental Leave';
            }
            elseif($leave->leave_type == 4)
            {
                $type = 'Long Service Leave';
            }
            elseif($leave->leave_type == 5)
            {
                $type = 'Other';
            }

            $where_staff['lstaff_leave'] = $request->segment(3);
            $staffs = LeaveStaff::getDetails($where_staff);

            $managers = array();

            if($staffs->count() > 0)
            {
                foreach($staffs as $staff)
                {
                    $managers[] = array('id'=>$staff->staff_id,'name'=>$staff->staff_fname.' '.$staff->staff_lname);
                }
            }

            $result = array('id'=>$leave->leave_id,'type_id'=>$leave->leave_type,'type'=>$type,'apply_date'=>date('d M Y',strtotime($leave->leave_date)),'start_date'=>date('d M Y',strtotime($leave->leave_sdate)),'return_date'=>date('d M Y',strtotime($leave->leave_wdate)),'reason'=>$leave->leave_reason,'managers'=>$managers);

            return $this->sendResponse($result, 'Leave Details');
        }
        else
        {
            return $this->sendError('Leave Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_leave(Request $request)
    {
        $rules = ['type' => 'required',
                  'apply_date' => 'required',
                  'reason' => 'required',
                  'start_date' => 'required',
                  'return_date' => 'required'
                 ];
    
        $messages = ['type.required' => 'Please Select Type',
                     'apply_date.required' => 'Please Select Apply Date',
                     'reason.required' => 'Please Enter Reason',
                     'start_date.required' => 'Please Select Leave Start Date',
                     'return_date.required' => 'Please Select Returning to Work'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['leave_type']       = $request->type;
            $upd['leave_date']       = date('Y-m-d',strtotime($request->apply_date));
            $upd['leave_sdate']      = date('Y-m-d',strtotime($request->start_date));
            $upd['leave_wdate']      = date('Y-m-d',strtotime($request->return_date));
            $upd['leave_reason']     = $request->reason;
            $upd['leave_updated_on'] = date('Y-m-d H:i:s');
            $upd['leave_updated_by'] = $request->user()->staff_id;

            $add = Leave::where('leave_id',$request->segment(3))->update($upd);

            LeaveStaff::where('lstaff_leave',$request->segment(3))->delete();
                        
            $managers = $request->manager;

            if(!empty($managers))
            {
                foreach($managers as $manager)
                {
                    $ins_lstaff['lstaff_leave']      = $request->segment(3);
                    $ins_lstaff['lstaff_staff']      = $manager;
                    $ins_lstaff['lstaff_added_on']   = date('Y-m-d H:i:s');
                    $ins_lstaff['lstaff_added_by']   = $request->user()->staff_id;
                    $ins_lstaff['lstaff_updated_on'] = date('Y-m-d H:i:s');
                    $ins_lstaff['lstaff_updated_by'] = $request->user()->staff_id;
                    $ins_lstaff['lstaff_status']     = 1;

                    LeaveStaff::create($ins_lstaff);
                }
            }

            $result = array('leave_id' => $request->segment(3));

            return $this->sendResponse($result, 'Leave Updated Successfully');
        }
    }

    public function leave_type(Request $request)
    {
        $types = array(1=>'Sick Leave',2=>'Annual Leave',3=>'Parental Leave',4=>'Long Service Leave',5=>'Other');

        if(count($types) > 0)
        {
            foreach($types as $id => $type)
            {
                $result[] = array('id'=>$id,'name'=>$type);
            }

            return $this->sendResponse($result, 'Type List');
        } 
        else
        {
            return $this->sendError('Type Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function managers(Request $request)
    {
        $where['staff_role'] = 1;
        $where['staff_status'] = 1;
        $staffs = Staff::where($where)->orderby('staff_fname','asc')->get();

        if($staffs->count() > 0)
        {
            foreach($staffs as $staff)
            {
                $result[] = array('id'=>$staff->staff_id,'name'=>$staff->staff_fname.' '.$staff->staff_lname);
            }

            return $this->sendResponse($result, 'Manager List');
        } 
        else
        {
            return $this->sendError('Managers Available.', ['error'=>'Data Not Available']);
        }
    }
}