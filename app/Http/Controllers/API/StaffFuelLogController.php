<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\FuelLog;
   
class StaffFuelLogController extends BaseController
{
    public function index(Request $request)
    {
        $where['fuel_log_vehicle'] = $request->segment(3);
        $fuel_logs = FuelLog::where($where)->orderby('fuel_log_id','desc')->get();

        if($fuel_logs->count() > 0)
        {
            foreach($fuel_logs as $fuel_log)
            {
                $fuel_date = date('d M Y',strtotime($fuel_log->fuel_log_date));

                $result[] = array('id'=>$fuel_log->fuel_log_id,'date'=>$fuel_date,'driver'=>$fuel_log->fuel_log_driver,'odometer_reading'=>$fuel_log->fuel_log_odometer,'fuel_added'=>$fuel_log->fuel_log_fadded,'cost'=>$fuel_log->fuel_log_cost);
            }

            return $this->sendResponse($result, 'Fuel Log List');
        }
        else
        {
            return $this->sendError('Fuel Logs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_fuel_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'driver' => 'required',  
                  'odometer_reading' => 'required',  
                  'fuel_added' => 'required',  
                  'cost' => 'required'
                 ];
            
        $messages = ['date.required' => 'Please Select Date',
                     'driver.required' => 'Please Enter Driver',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'fuel_added.required' => 'Please Enter Fuel Added',
                     'cost.required' => 'Please Enter Cost'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['fuel_log_vehicle']    = $request->segment(3);
            $ins['fuel_log_date']       = date('Y-m-d',strtotime($request->date));
            $ins['fuel_log_driver']     = $request->driver;
            $ins['fuel_log_odometer']   = $request->odometer_reading;
            $ins['fuel_log_fadded']     = $request->fuel_added;
            $ins['fuel_log_cost']       = $request->cost;
            $ins['fuel_log_notes']      = $request->notes;
            $ins['fuel_log_added_on']   = date('Y-m-d H:i:s');
            $ins['fuel_log_added_by']   = $request->user()->staff_id;
            $ins['fuel_log_updated_on'] = date('Y-m-d H:i:s');
            $ins['fuel_log_updated_by'] = $request->user()->staff_id;
            $ins['fuel_log_status']     = 1;
            
            $add = FuelLog::create($ins);

            if($add)
            {
                $result = array('fuel_log_id' => $add->fuel_log_id);

                return $this->sendResponse($result, 'Fuel Log Added Successfully');
            }
            else
            {
                return $this->sendError('Fuel Log Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function fuel_log_detail(Request $request)
    {
        $fuel_log = FuelLog::where('fuel_log_id',$request->segment(3))->first();

        if(isset($fuel_log))
        {
            $result = array('id'=>$fuel_log->fuel_log_id,'date'=>date('d-m-Y',strtotime($fuel_log->fuel_log_date)),'driver'=>$fuel_log->fuel_log_driver,'odometer_reading'=>$fuel_log->fuel_log_odometer,'fuel_added'=>$fuel_log->fuel_log_fadded,'cost'=>$fuel_log->fuel_log_cost,'notes'=>$fuel_log->fuel_log_notes);

            return $this->sendResponse($result, 'Fuel Log Details');
        }
        else
        {
            return $this->sendError('Fuel Log Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_fuel_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'driver' => 'required',  
                  'odometer_reading' => 'required',  
                  'fuel_added' => 'required',  
                  'cost' => 'required'
                 ];
            
        $messages = ['date.required' => 'Please Select Date',
                     'driver.required' => 'Please Enter Driver',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'fuel_added.required' => 'Please Enter Fuel Added',
                     'cost.required' => 'Please Enter Cost'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['fuel_log_date']       = date('Y-m-d',strtotime($request->date));
            $upd['fuel_log_driver']     = $request->driver;
            $upd['fuel_log_odometer']   = $request->odometer_reading;
            $upd['fuel_log_fadded']     = $request->fuel_added;
            $upd['fuel_log_cost']       = $request->cost;
            $upd['fuel_log_notes']      = $request->notes;
            $upd['fuel_log_updated_on'] = date('Y-m-d H:i:s');
            $upd['fuel_log_updated_by'] = $request->user()->staff_id;

            FuelLog::where('fuel_log_id',$request->segment(3))->update($upd);

            $result = array('fuel_log_id' => $request->segment(3));

            return $this->sendResponse($result, 'Fuel Log Updated Successfully');
        }
    }
}