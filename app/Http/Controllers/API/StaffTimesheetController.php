<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Timesheet;
   
class StaffTimesheetController extends BaseController
{
    public function index(Request $request)
    {
        $where['timesheet_staff'] = $request->user()->staff_id;
        $timesheets = Timesheet::getStaffDetails($where);

        if($timesheets->count() > 0)
        {
            foreach($timesheets as $timesheet)
            {
                if($timesheet->timesheet_wtype == 1)
                {
                    $status = 'Work';
                }
                elseif($timesheet->timesheet_wtype == 2)
                {
                    $status = 'Sick Leave';
                }
                elseif($timesheet->timesheet_wtype == 3)
                {
                    $status = 'Annual Leave';
                }
                elseif($timesheet->timesheet_wtype == 4)
                {
                    $status = 'Training';
                }
                elseif($timesheet->timesheet_wtype == 5)
                {
                    $status = 'Travelling';
                }
                elseif($timesheet->timesheet_wtype == 6)
                {
                    $status = 'Saturday Holiday';
                }
                elseif($timesheet->timesheet_wtype == 7)
                {
                    $status = 'Sunday Holiday';
                }
                elseif($timesheet->timesheet_wtype == 8)
                {
                    $status = 'Public Holiday';
                }
                elseif($timesheet->timesheet_wtype == 9)
                {
                    $status = 'Others';
                }

                if(!empty($timesheet->timesheet_start)){ $start_time = date('h:i A',strtotime($timesheet->timesheet_start)); }else{ $start_time = NULL; }
                if(!empty($timesheet->timesheet_end)){ $end_time = date('h:i A',strtotime($timesheet->timesheet_end)); }else{ $end_time = NULL; }

                $result[] = array('id'=>$timesheet->timesheet_id,'date'=>date('d M Y',strtotime($timesheet->timesheet_date)),'status'=>$status,'start_time'=>$start_time,'finish_time'=>$end_time,'client'=>$timesheet->customer_name,'location'=>$timesheet->location_name,'description'=>$timesheet->timesheet_desc);
            }

            return $this->sendResponse($result, 'Timesheet List');
        }
        else
        {
            return $this->sendError('Timesheets Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_timesheet(Request $request)
    {
        $rules = ['date' => 'required',
                  'status' => 'required'];
            
        $messages = ['date.required' => 'Please Select Date',
                     'status.required' => 'Please Select Status'];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $where_check['timesheet_staff'] = $request->user()->staff_id;
            $where_check['timesheet_date']  = date('Y-m-d',strtotime($request->date));
            $check_timesheet = Timesheet::where($where_check)->count();

            if($check_timesheet > 0)
            {
                return $this->sendError('Timesheet Already Added For This Selected Date', ['error'=>'Already Added']);
            }
            else
            {
                $ins['timesheet_staff']      = $request->user()->staff_id;
                $ins['timesheet_date']       = date('Y-m-d',strtotime($request->date));
                $ins['timesheet_wtype']      = $request->status;
                $ins['timesheet_client']     = $request->client;
                $ins['timesheet_desc']       = $request->description;
                $ins['timesheet_location']   = $request->location;
                $ins['timesheet_added_on']   = date('Y-m-d H:i:s');
                $ins['timesheet_added_by']   = $request->user()->staff_id;
                $ins['timesheet_updated_on'] = date('Y-m-d H:i:s');
                $ins['timesheet_updated_by'] = $request->user()->staff_id;
                $ins['timesheet_status']     = 1;

                if(!empty($request->start_time))
                {
                    $ins['timesheet_start'] = date('H:i',strtotime($request->start_time));
                }
                else
                {
                    $ins['timesheet_start'] = NULL;
                }

                if(!empty($request->finish_time))
                {
                    $ins['timesheet_end'] = date('H:i',strtotime($request->finish_time));
                }
                else
                {
                    $ins['timesheet_end'] = NULL;
                }

                $add = Timesheet::create($ins);

                if($add)
                {
                    $result = array('timesheet_id' => $add->timesheet_id);

                    return $this->sendResponse($result, 'Timesheet Added Successfully');
                }
                else
                {
                    return $this->sendError('Timesheet Not Added', ['error'=>'Some errors occured']);
                }
            }
        }
    }

    public function timesheet_status(Request $request)
    {
        $statuses = array(1=>'Work',2=>'Sick Leave',3=>'Annual Leave',4=>'Training',5=>'Travelling',6=>'Saturday Holiday',7=>'Sunday Holiday',8=>'Public Holiday',9=>'Others');

        if(count($statuses) > 0)
        {
            foreach($statuses as $id => $status)
            {
                $result[] = array('id'=>$id,'name'=>$status);
            }

            return $this->sendResponse($result, 'Status List');
        } 
        else
        {
            return $this->sendError('Status Not Available.', ['error'=>'Data Not Available']);
        }
    }
}