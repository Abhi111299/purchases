<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Accident;
   
class StaffAccidentController extends BaseController
{
    public function index(Request $request)
    {
        $where['accident_vehicle'] = $request->segment(3);
        $accidents = Accident::where($where)->orderby('accident_id','desc')->get();

        if($accidents->count() > 0)
        {
            foreach($accidents as $accident)
            {
                $accident_date = date('d M Y',strtotime($accident->accident_date));

                $accident_time = date('H:i A',strtotime($accident->accident_time));

                $result[] = array('id'=>$accident->accident_id,'date'=>$accident_date,'time'=>$accident_time,'driver'=>$accident->accident_driver,'location'=>$accident->accident_location,'description'=>$accident->accident_desc);
            }

            return $this->sendResponse($result, 'Accident List');
        }
        else
        {
            return $this->sendError('Accidents Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_accident(Request $request)
    {
        $rules = ['date' => 'required',
                  'time' => 'required',  
                  'driver' => 'required',  
                  'location' => 'required',
                  'parties' => 'required',
                  'description' => 'required',
                  'damage' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'time.required' => 'Please Select Time',
                     'driver.required' => 'Please Enter Driver',
                     'location.required' => 'Please Enter Location',
                     'parties.required' => 'Please Enter Involved Parties',
                     'description.required' => 'Please Enter Description',
                     'damage.required' => 'Please Enter Damage Details'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['accident_vehicle']    = $request->segment(3);
            $ins['accident_date']       = date('Y-m-d',strtotime($request->date));
            $ins['accident_time']       = date('h:i',strtotime($request->time));
            $ins['accident_driver']     = $request->driver;
            $ins['accident_location']   = $request->location;
            $ins['accident_parties']    = $request->parties;
            $ins['accident_desc']       = $request->description;
            $ins['accident_damage']     = $request->damage;
            $ins['accident_notes']      = $request->notes;
            $ins['accident_added_on']   = date('Y-m-d H:i:s');
            $ins['accident_added_by']   = $request->user()->staff_id;
            $ins['accident_updated_on'] = date('Y-m-d H:i:s');
            $ins['accident_updated_by'] = $request->user()->staff_id;
            $ins['accident_status']     = 1;
            
            $file_names = array();

            if($request->hasFile('photographs'))
            {
                foreach($request->photographs as $photograph) 
                {
                    $file_path = $photograph->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/vehicle';

                    $photograph->storeAs($final_file_path, $file_name);

                    $file_names[] = $file_name;
                }

                $ins['accident_photographs'] = json_encode($file_names);
            }

            $add = Accident::create($ins);

            if($add)
            {
                $result = array('accident_id' => $add->accident_id);

                return $this->sendResponse($result, 'Accident Added Successfully');
            }
            else
            {
                return $this->sendError('Accident Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function accident_detail(Request $request)
    {
        $accident = Accident::where('accident_id',$request->segment(3))->first();

        if(isset($accident))
        {
            $photographs = array();
            
            if(!empty($accident->accident_photographs))
            {
                $accident_photographs = json_decode($accident->accident_photographs,true);

                foreach($accident_photographs as $accident_photograph)
                {
                    $photographs[] = asset(config('constants.admin_path').'uploads/vehicle/'.$accident_photograph);
                }
            }

            $result = array('id'=>$accident->accident_id,'date'=>date('d-m-Y',strtotime($accident->accident_date)),'time'=>date('h:i A',strtotime($accident->accident_time)),'driver'=>$accident->accident_driver,'location'=>$accident->accident_location,'parties'=>$accident->accident_parties,'description'=>$accident->accident_desc,'damage'=>$accident->accident_damage,'notes'=>$accident->accident_notes,'photographs'=>$photographs);

            return $this->sendResponse($result, 'Accident Details');
        }
        else
        {
            return $this->sendError('Accident Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_accident(Request $request)
    {
        $rules = ['date' => 'required',
                  'time' => 'required',  
                  'driver' => 'required',  
                  'location' => 'required',
                  'parties' => 'required',
                  'description' => 'required',
                  'damage' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'time.required' => 'Please Select Time',
                     'driver.required' => 'Please Enter Driver',
                     'location.required' => 'Please Enter Location',
                     'parties.required' => 'Please Enter Involved Parties',
                     'description.required' => 'Please Enter Description',
                     'damage.required' => 'Please Enter Damage Details'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $accident_detail = Accident::where('accident_id',$request->segment(3))->first();

            $upd['accident_date']       = date('Y-m-d',strtotime($request->date));
            $upd['accident_time']       = date('h:i',strtotime($request->time));
            $upd['accident_driver']     = $request->driver;
            $upd['accident_location']   = $request->location;
            $upd['accident_parties']    = $request->parties;
            $upd['accident_desc']       = $request->description;
            $upd['accident_damage']     = $request->damage;
            $upd['accident_notes']      = $request->notes;
            $upd['accident_updated_on'] = date('Y-m-d H:i:s');
            $upd['accident_updated_by'] = $request->user()->staff_id;

            $file_names = array();

            if($request->hasFile('photographs'))
            {
                $old_file = array();

                if(!empty($accident_detail->accident_photographs))
                {
                    $old_file = json_decode($accident_detail->accident_photographs,true);
                }

                foreach($request->photographs as $photograph) 
                {
                    $file_path = $photograph->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/vehicle';

                    $photograph->storeAs($final_file_path, $file_name);

                    $file_names[] = $file_name;
                }

                $new_files = array_merge($old_file,$file_names);

                $upd['accident_photographs'] = json_encode($new_files);
            }

            Accident::where('accident_id',$request->segment(3))->update($upd);

            $result = array('accident_id' => $request->segment(3));

            return $this->sendResponse($result, 'Accident Updated Successfully');
        }
    }
}