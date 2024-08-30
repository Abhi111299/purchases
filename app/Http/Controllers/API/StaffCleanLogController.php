<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\CleaningLog;
   
class StaffCleanLogController extends BaseController
{
    public function index(Request $request)
    {
        $where['cleaning_log_vehicle'] = $request->segment(3);
        $cleaning_logs = CleaningLog::where($where)->orderby('cleaning_log_id','desc')->get();

        if($cleaning_logs->count() > 0)
        {
            foreach($cleaning_logs as $cleaning_log)
            {
                $cleaning_date = date('d M Y',strtotime($cleaning_log->cleaning_log_date));

                $result[] = array('id'=>$cleaning_log->cleaning_log_id,'date'=>$cleaning_date,'driver'=>$cleaning_log->cleaning_log_driver,'type'=>$cleaning_log->cleaning_log_type,'location'=>$cleaning_log->cleaning_log_location,'provider'=>$cleaning_log->cleaning_log_provider,'cost'=>$cleaning_log->cleaning_log_cost);
            }

            return $this->sendResponse($result, 'Cleaning Log List');
        }
        else
        {
            return $this->sendError('Cleaning Logs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_cleaning_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'driver' => 'required',  
                  'type' => 'required',  
                  'location' => 'required',
                  'provider' => 'required',
                  'cost' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'driver.required' => 'Please Enter Driver',
                     'type.required' => 'Please Enter Type',
                     'location.required' => 'Please Enter Location',
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
            $ins['cleaning_log_vehicle']    = $request->segment(3);
            $ins['cleaning_log_date']       = date('Y-m-d',strtotime($request->date));
            $ins['cleaning_log_driver']     = $request->driver;
            $ins['cleaning_log_type']       = $request->type;
            $ins['cleaning_log_location']   = $request->location;
            $ins['cleaning_log_provider']   = $request->provider;
            $ins['cleaning_log_cost']       = $request->cost;
            $ins['cleaning_log_notes']      = $request->notes;
            $ins['cleaning_log_added_on']   = date('Y-m-d H:i:s');
            $ins['cleaning_log_added_by']   = $request->user()->staff_id;
            $ins['cleaning_log_updated_on'] = date('Y-m-d H:i:s');
            $ins['cleaning_log_updated_by'] = $request->user()->staff_id;
            $ins['cleaning_log_status']     = 1;
            
            $add = CleaningLog::create($ins);

            if($add)
            {
                $result = array('cleaning_log_id' => $add->cleaning_log_id);

                return $this->sendResponse($result, 'Cleaning Log Added Successfully');
            }
            else
            {
                return $this->sendError('Cleaning Log Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function cleaning_log_detail(Request $request)
    {
        $cleaning_log = CleaningLog::where('cleaning_log_id',$request->segment(3))->first();

        if(isset($cleaning_log))
        {
            $result = array('id'=>$cleaning_log->cleaning_log_id,'date'=>date('d-m-Y',strtotime($cleaning_log->cleaning_log_date)),'driver'=>$cleaning_log->cleaning_log_driver,'type'=>$cleaning_log->cleaning_log_type,'location'=>$cleaning_log->cleaning_log_location,'provider'=>$cleaning_log->cleaning_log_provider,'cost'=>$cleaning_log->cleaning_log_cost,'notes'=>$cleaning_log->cleaning_log_notes);

            return $this->sendResponse($result, 'Cleaning Log Details');
        }
        else
        {
            return $this->sendError('Cleaning Log Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_cleaning_log(Request $request)
    {
        $rules = ['date' => 'required',
                  'driver' => 'required',  
                  'type' => 'required',  
                  'location' => 'required',
                  'provider' => 'required',
                  'cost' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'driver.required' => 'Please Enter Driver',
                     'type.required' => 'Please Enter Type',
                     'location.required' => 'Please Enter Location',
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
            $upd['cleaning_log_date']       = date('Y-m-d',strtotime($request->date));
            $upd['cleaning_log_driver']     = $request->driver;
            $upd['cleaning_log_type']       = $request->type;
            $upd['cleaning_log_location']   = $request->location;
            $upd['cleaning_log_provider']   = $request->provider;
            $upd['cleaning_log_cost']       = $request->cost;
            $upd['cleaning_log_notes']      = $request->notes;
            $upd['cleaning_log_updated_on'] = date('Y-m-d H:i:s');
            $upd['cleaning_log_updated_by'] = $request->user()->staff_id;

            CleaningLog::where('cleaning_log_id',$request->segment(3))->update($upd);

            $result = array('cleaning_log_id' => $request->segment(3));

            return $this->sendResponse($result, 'Cleaning Log Updated Successfully');
        }
    }
}