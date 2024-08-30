<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Attendance;
   
class StaffAttendanceController extends BaseController
{
    public function index(Request $request)
    {
        $where['attendance_staff'] = $request->user()->staff_id;
        $attendances = Attendance::where($where)->orderby('attendance_id','desc')->get();

        if($attendances->count() > 0)
        {
            foreach($attendances as $attendance)
            {
                if($attendance->attendance_type == 1)
                {
                    $type = 'Present';
                }
                elseif($attendance->attendance_type == 2)
                {
                    $type = 'Absent';
                }
                elseif($attendance->attendance_type == 3)
                {
                    $type = 'Half Day';
                }

                $result[] = array('id'=>$attendance->attendance_id,'date'=>date('d M Y',strtotime($attendance->attendance_date)),'type'=>$type,'notes'=>$attendance->attendance_notes);
            }

            return $this->sendResponse($result, 'Attendance List');
        }
        else
        {
            return $this->sendError('Attendances Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_attendance(Request $request)
    {
        $rules = ['date' => 'required',
                  'type' => 'required'];
            
        $messages = ['date.required' => 'Please Select Date',
                     'type.required' => 'Please Select Type'];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $where_check['attendance_staff'] = $request->user()->staff_id;
            $where_check['attendance_date']  = date('Y-m-d',strtotime($request->date));
            $check_attendance = Attendance::where($where_check)->count();

            if($check_attendance > 0)
            {
                return $this->sendError('Attendance Already Added For This Selected Date', ['error'=>'Already Added']);
            }
            else
            {
                $ins['attendance_staff']      = $request->user()->staff_id;
                $ins['attendance_date']       = date('Y-m-d',strtotime($request->date));
                $ins['attendance_type']       = $request->type;
                $ins['attendance_notes']      = $request->notes;
                $ins['attendance_added_on']   = date('Y-m-d H:i:s');
                $ins['attendance_added_by']   = $request->user()->staff_id;
                $ins['attendance_updated_on'] = date('Y-m-d H:i:s');
                $ins['attendance_updated_by'] = $request->user()->staff_id;
                $ins['attendance_status']     = 1;

                $add = Attendance::create($ins);

                if($add)
                {
                    $result = array('attendance_id' => $add->attendance_id);

                    return $this->sendResponse($result, 'Attendance Added Successfully');
                }
                else
                {
                    return $this->sendError('Attendance Not Added', ['error'=>'Some errors occured']);
                }
            }
        }
    }

    public function attendance_type(Request $request)
    {
        $types = array(1=>'Present',2=>'Absent',3=>'Half Day');

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
}