<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\RepairLog;
   
class StaffRepairLogController extends BaseController
{
    public function index(Request $request)
    {
        $where['repair_log_vehicle'] = $request->segment(3);
        $repair_logs = RepairLog::getDetails($where);

        if($repair_logs->count() > 0)
        {
            foreach($repair_logs as $repair_log)
            {
                $staff_name = $repair_log->staff_fname.' '.$repair_log->staff_lname;

                $repair_date = date('d M Y',strtotime($repair_log->repair_log_date));

                $result[] = array('id'=>$repair_log->repair_log_id,'date'=>$repair_date,'odometer_reading'=>$repair_log->repair_log_odometer,'requested_by'=>$staff_name,'parts_replaced'=>$repair_log->repair_log_replaced,'labor_cost'=>$repair_log->repair_log_lcost,'parts_cost'=>$repair_log->repair_log_pcost,'total_cost'=>$repair_log->repair_log_cost,'provider'=>$repair_log->repair_log_provider);
            }

            return $this->sendResponse($result, 'Repair Log List');
        }
        else
        {
            return $this->sendError('Repair Logs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_repair_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'odometer_reading' => 'required',  
                  'requested_by' => 'required',  
                  'parts_replaced' => 'required',
                  'labor_cost' => 'required',
                  'parts_cost' => 'required',
                  'total_cost' => 'required',
                  'provider' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'requested_by.required' => 'Please Select Repair requested by',
                     'parts_replaced.required' => 'Please Enter Parts Replaced',
                     'labor_cost.required' => 'Please Enter Labor Cost',
                     'parts_cost.required' => 'Please Enter Parts Cost',
                     'total_cost.required' => 'Please Enter Total Cost',
                     'provider.required' => 'Please Enter Service Provider'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['repair_log_vehicle']    = $request->segment(3);
            $ins['repair_log_date']       = date('Y-m-d',strtotime($request->date));
            $ins['repair_log_odometer']   = $request->odometer_reading;
            $ins['repair_log_performed']  = $request->requested_by;
            $ins['repair_log_replaced']   = $request->parts_replaced;
            $ins['repair_log_lcost']      = $request->labor_cost;
            $ins['repair_log_pcost']      = $request->parts_cost;
            $ins['repair_log_cost']       = $request->total_cost;
            $ins['repair_log_provider']   = $request->provider;
            $ins['repair_log_notes']      = $request->notes;
            $ins['repair_log_added_on']   = date('Y-m-d H:i:s');
            $ins['repair_log_added_by']   = $request->user()->staff_id;
            $ins['repair_log_updated_on'] = date('Y-m-d H:i:s');
            $ins['repair_log_updated_by'] = $request->user()->staff_id;
            $ins['repair_log_status']     = 1;
            
            $add = RepairLog::create($ins);

            if($add)
            {
                $result = array('repair_log_id' => $add->repair_log_id);

                return $this->sendResponse($result, 'Repair Log Added Successfully');
            }
            else
            {
                return $this->sendError('Repair Log Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function repair_log_detail(Request $request)
    {
        $where['repair_log_id'] = $request->segment(3);
        $repair_log = RepairLog::getDetail($where);

        if(isset($repair_log))
        {
            $staff_name = $repair_log->staff_fname.' '.$repair_log->staff_lname;

            $result = array('id'=>$repair_log->repair_log_id,'date'=>date('d-m-Y',strtotime($repair_log->repair_log_date)),'odometer_reading'=>$repair_log->repair_log_odometer,'requested_by_id'=>$repair_log->repair_log_performed,'requested_by'=>$staff_name,'parts_replaced'=>$repair_log->repair_log_replaced,'labor_cost'=>$repair_log->repair_log_lcost,'parts_cost'=>$repair_log->repair_log_pcost,'total_cost'=>$repair_log->repair_log_cost,'provider'=>$repair_log->repair_log_provider,'notes'=>$repair_log->repair_log_notes);

            return $this->sendResponse($result, 'Repair Log Details');
        }
        else
        {
            return $this->sendError('Repair Log Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_repair_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'odometer_reading' => 'required',  
                  'requested_by' => 'required',  
                  'parts_replaced' => 'required',
                  'labor_cost' => 'required',
                  'parts_cost' => 'required',
                  'total_cost' => 'required',
                  'provider' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'requested_by.required' => 'Please Select Repair requested by',
                     'parts_replaced.required' => 'Please Enter Parts Replaced',
                     'labor_cost.required' => 'Please Enter Labor Cost',
                     'parts_cost.required' => 'Please Enter Parts Cost',
                     'total_cost.required' => 'Please Enter Total Cost',
                     'provider.required' => 'Please Enter Service Provider'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['repair_log_date']       = date('Y-m-d',strtotime($request->date));
            $upd['repair_log_odometer']   = $request->odometer_reading;
            $upd['repair_log_performed']  = $request->requested_by;
            $upd['repair_log_replaced']   = $request->parts_replaced;
            $upd['repair_log_lcost']      = $request->labor_cost;
            $upd['repair_log_pcost']      = $request->parts_cost;
            $upd['repair_log_cost']       = $request->total_cost;
            $upd['repair_log_provider']   = $request->provider;
            $upd['repair_log_notes']      = $request->notes;
            $upd['repair_log_updated_on'] = date('Y-m-d H:i:s');
            $upd['repair_log_updated_by'] = $request->user()->staff_id;

            RepairLog::where('repair_log_id',$request->segment(3))->update($upd);

            $result = array('repair_log_id' => $request->segment(3));

            return $this->sendResponse($result, 'Repair Log Updated Successfully');
        }
    }
}