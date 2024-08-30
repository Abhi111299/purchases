<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\TripLog;
   
class StaffTripLogController extends BaseController
{
    public function index(Request $request)
    {
        $where['trip_log_vehicle'] = $request->segment(3);
        $trip_logs = TripLog::where($where)->orderby('trip_log_id','desc')->get();

        if($trip_logs->count() > 0)
        {
            foreach($trip_logs as $trip_log)
            {
                $trip_date = date('d M Y',strtotime($trip_log->trip_log_date));

                $start_time = date('h:i A',strtotime($trip_log->trip_log_stime));

                $end_time = date('h:i A',strtotime($trip_log->trip_log_etime));

                $result[] = array('id'=>$trip_log->trip_log_id,'date'=>$trip_date,'driver'=>$trip_log->trip_log_driver,'start_time'=>$start_time,'end_time'=>$end_time,'start_odometer'=>$trip_log->trip_log_sodometer,'end_odometer'=>$trip_log->trip_log_eodometer);
            }

            return $this->sendResponse($result, 'Trip Log List');
        }
        else
        {
            return $this->sendError('Trip Logs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_trip_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'driver' => 'required',  
                  'start_time' => 'required',  
                  'start_odometer' => 'required'
                 ];
            
            $messages = ['date.required' => 'Please Select Date',
                         'driver.required' => 'Please Enter Driver',
                         'start_time.required' => 'Please Select Start Time',
                         'start_odometer.required' => 'Please Enter Start Odometer'
                        ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['trip_log_vehicle']    = $request->segment(3);
            $ins['trip_log_date']       = date('Y-m-d',strtotime($request->date));
            $ins['trip_log_driver']     = $request->driver;
            $ins['trip_log_stime']      = date('H:i',strtotime($request->start_time));
            $ins['trip_log_sodometer']  = $request->start_odometer;
            $ins['trip_log_eodometer']  = $request->end_odometer;
            $ins['trip_log_details']    = $request->details;
            $ins['trip_log_notes']      = $request->notes;
            $ins['trip_log_added_on']   = date('Y-m-d H:i:s');
            $ins['trip_log_added_by']   = $request->user()->staff_id;
            $ins['trip_log_updated_on'] = date('Y-m-d H:i:s');
            $ins['trip_log_updated_by'] = $request->user()->staff_id;
            $ins['trip_log_status']     = 1;

            if(!empty($request->end_time))
            {
                $ins['trip_log_etime'] = date('H:i',strtotime($request->end_time));
            }
            else
            {
                $ins['trip_log_etime'] = NULL;
            }
            
            $add = TripLog::create($ins);

            if($add)
            {
                $result = array('trip_log_id' => $add->trip_log_id);

                return $this->sendResponse($result, 'Trip Log Added Successfully');
            }
            else
            {
                return $this->sendError('Trip Log Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function trip_log_detail(Request $request)
    {
        $trip_log = TripLog::where('trip_log_id',$request->segment(3))->first();

        if(isset($trip_log))
        {
            $result = array('id'=>$trip_log->trip_log_id,'date'=>date('d-m-Y',strtotime($trip_log->trip_log_date)),'driver'=>$trip_log->trip_log_driver,'start_time'=>date('h:i A',strtotime($trip_log->trip_log_stime)),'end_time'=>date('h:i A',strtotime($trip_log->trip_log_etime)),'start_odometer'=>$trip_log->trip_log_sodometer,'end_odometer'=>$trip_log->trip_log_eodometer,'details'=>$trip_log->trip_log_details,'notes'=>$trip_log->trip_log_notes);

            return $this->sendResponse($result, 'Trip Log Details');
        }
        else
        {
            return $this->sendError('Trip Log Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_trip_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'driver' => 'required',  
                  'start_time' => 'required',  
                  'start_odometer' => 'required'
                 ];
            
            $messages = ['date.required' => 'Please Select Date',
                         'driver.required' => 'Please Enter Driver',
                         'start_time.required' => 'Please Select Start Time',
                         'start_odometer.required' => 'Please Enter Start Odometer'
                        ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['trip_log_date']       = date('Y-m-d',strtotime($request->date));
            $upd['trip_log_driver']     = $request->driver;
            $upd['trip_log_stime']      = date('H:i',strtotime($request->start_time));
            $upd['trip_log_sodometer']  = $request->start_odometer;
            $upd['trip_log_eodometer']  = $request->end_odometer;
            $upd['trip_log_details']    = $request->details;
            $upd['trip_log_notes']      = $request->notes;
            $upd['trip_log_updated_on'] = date('Y-m-d H:i:s');
            $upd['trip_log_updated_by'] = $request->user()->staff_id;

            if(!empty($request->end_time))
            {
                $upd['trip_log_etime'] = date('H:i',strtotime($request->end_time));
            }
            else
            {
                $upd['trip_log_etime'] = NULL;
            }

            TripLog::where('trip_log_id',$request->segment(3))->update($upd);

            $result = array('trip_log_id' => $request->segment(3));

            return $this->sendResponse($result, 'Trip Log Updated Successfully');
        }
    }
}