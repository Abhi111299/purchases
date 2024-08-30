<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\ServiceLog;
   
class StaffServiceLogController extends BaseController
{
    public function index(Request $request)
    {
        $where['service_log_vehicle'] = $request->segment(3);
        $service_logs = ServiceLog::getDetails($where);

        if($service_logs->count() > 0)
        {
            foreach($service_logs as $service_log)
            {
                $staff_name = $service_log->staff_fname.' '.$service_log->staff_lname;

                $service_date = date('d M Y',strtotime($service_log->service_log_date));

                $result[] = array('id'=>$service_log->service_log_id,'date'=>$service_date,'requested_by'=>$staff_name,'odometer_reading'=>$service_log->service_log_odometer,'next_service_odometer'=>$service_log->service_log_nodometer,'provider'=>$service_log->service_log_provider,'cost'=>$service_log->service_log_cost);
            }

            return $this->sendResponse($result, 'Service Log List');
        }
        else
        {
            return $this->sendError('Service Logs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_service_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'requested_by' => 'required',  
                  'odometer_reading' => 'required',  
                  'next_service_odometer' => 'required',
                  'provider' => 'required',
                  'cost' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'requested_by.required' => 'Please Select Requested By',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'next_service_odometer.required' => 'Please Enter Next Service Odometer',
                     'provider.required' => 'Please Enter Service Provider',
                     'cost.required' => 'Please Enter Cost'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['service_log_vehicle']    = $request->segment(3);
            $ins['service_log_date']       = date('Y-m-d',strtotime($request->date));
            $ins['service_log_requested']  = $request->requested_by;
            $ins['service_log_odometer']   = $request->odometer_reading;
            $ins['service_log_nodometer']  = $request->next_service_odometer;
            $ins['service_log_provider']   = $request->provider;
            $ins['service_log_cost']       = $request->cost;
            $ins['service_log_notes']      = $request->notes;
            $ins['service_log_added_on']   = date('Y-m-d H:i:s');
            $ins['service_log_added_by']   = $request->user()->staff_id;
            $ins['service_log_updated_on'] = date('Y-m-d H:i:s');
            $ins['service_log_updated_by'] = $request->user()->staff_id;
            $ins['service_log_status']     = 1;
            
            $add = ServiceLog::create($ins);

            if($add)
            {
                $result = array('service_log_id' => $add->service_log_id);

                return $this->sendResponse($result, 'Service Log Added Successfully');
            }
            else
            {
                return $this->sendError('Service Log Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function service_log_detail(Request $request)
    {
        $where['service_log_id'] = $request->segment(3);
        $service_log = ServiceLog::getDetail($where);

        if(isset($service_log))
        {
            $staff_name = $service_log->staff_fname.' '.$service_log->staff_lname;

            $result = array('id'=>$service_log->service_log_id,'date'=>date('d-m-Y',strtotime($service_log->service_log_date)),'requested_by_id'=>$service_log->service_log_requested,'requested_by'=>$staff_name,'odometer_reading'=>$service_log->service_log_odometer,'next_service_odometer'=>$service_log->service_log_nodometer,'provider'=>$service_log->service_log_provider,'cost'=>$service_log->service_log_cost,'notes'=>$service_log->service_log_notes);

            return $this->sendResponse($result, 'Service Log Details');
        }
        else
        {
            return $this->sendError('Service Log Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_service_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'requested_by' => 'required',  
                  'odometer_reading' => 'required',  
                  'next_service_odometer' => 'required',
                  'provider' => 'required',
                  'cost' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'requested_by.required' => 'Please Select Requested By',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'next_service_odometer.required' => 'Please Enter Next Service Odometer',
                     'provider.required' => 'Please Enter Service Provider',
                     'cost.required' => 'Please Enter Cost'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['service_log_date']       = date('Y-m-d',strtotime($request->date));
            $upd['service_log_requested']  = $request->requested_by;
            $upd['service_log_odometer']   = $request->odometer_reading;
            $upd['service_log_nodometer']  = $request->next_service_odometer;
            $upd['service_log_provider']   = $request->provider;
            $upd['service_log_cost']       = $request->cost;
            $upd['service_log_notes']      = $request->notes;
            $upd['service_log_updated_on'] = date('Y-m-d H:i:s');
            $upd['service_log_updated_by'] = $request->user()->staff_id;

            ServiceLog::where('service_log_id',$request->segment(3))->update($upd);

            $result = array('service_log_id' => $request->segment(3));

            return $this->sendResponse($result, 'Service Log Updated Successfully');
        }
    }
}