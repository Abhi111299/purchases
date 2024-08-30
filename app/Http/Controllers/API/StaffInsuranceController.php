<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Insurance;
   
class StaffInsuranceController extends BaseController
{
    public function index(Request $request)
    {
        $where['insurance_vehicle'] = $request->segment(3);
        $insurances = Insurance::where($where)->orderby('insurance_id','desc')->get();

        if($insurances->count() > 0)
        {
            foreach($insurances as $insurance)
            {
                $expiry_date = date('d M Y',strtotime($insurance->insurance_expiry));

                $coverage = '';

                if($insurance->insurance_coverage == 1)
                {
                    $coverage = 'Liability';    
                }
                elseif($insurance->insurance_coverage == 2)
                {
                    $coverage = 'Comprehensive';    
                }
                elseif($insurance->insurance_coverage == 3)
                {
                    $coverage = 'Collision';    
                }
                elseif($insurance->insurance_coverage == 4)
                {
                    $coverage = 'Third Part';    
                }

                $result[] = array('id'=>$insurance->insurance_id,'policy_no'=>$insurance->insurance_policy_no,'expiry_date'=>$expiry_date,'provider'=>$insurance->insurance_provider,'coverage'=>$coverage);
            }

            return $this->sendResponse($result, 'Insurance List');
        }
        else
        {
            return $this->sendError('Insurances Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_insurance(Request $request)
    {
        $rules = ['policy_no' => 'required',
                  'expiry_date' => 'required',  
                  'provider' => 'required',  
                  'coverage' => 'required'
                 ];
        
        $messages = ['policy_no.required' => 'Please Enter Policy Number',
                     'expiry_date.required' => 'Please Select Date',
                     'provider.required' => 'Please Enter Provider',
                     'coverage.required' => 'Please Select Coverage'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['insurance_vehicle']    = $request->segment(3);
            $ins['insurance_policy_no']  = $request->policy_no;
            $ins['insurance_expiry']     = date('Y-m-d',strtotime($request->expiry_date));
            $ins['insurance_provider']   = $request->provider;
            $ins['insurance_coverage']   = $request->coverage;
            $ins['insurance_notes']      = $request->notes;
            $ins['insurance_added_on']   = date('Y-m-d H:i:s');
            $ins['insurance_added_by']   = $request->user()->staff_id;
            $ins['insurance_updated_on'] = date('Y-m-d H:i:s');
            $ins['insurance_updated_by'] = $request->user()->staff_id;
            $ins['insurance_status']     = 1;

            $add = Insurance::create($ins);

            if($add)
            {
                $result = array('insurance_id' => $add->insurance_id);

                return $this->sendResponse($result, 'Insurance Added Successfully');
            }
            else
            {
                return $this->sendError('Insurance Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function insurance_detail(Request $request)
    {
        $insurance = Insurance::where('insurance_id',$request->segment(3))->first();

        if(isset($insurance))
        {
            $coverage = '';

            if($insurance->insurance_coverage == 1)
            {
                $coverage = 'Liability';    
            }
            elseif($insurance->insurance_coverage == 2)
            {
                $coverage = 'Comprehensive';    
            }
            elseif($insurance->insurance_coverage == 3)
            {
                $coverage = 'Collision';    
            }
            elseif($insurance->insurance_coverage == 4)
            {
                $coverage = 'Third Part';    
            }

            $result = array('id'=>$insurance->insurance_id,'policy_no'=>$insurance->insurance_policy_no,'expiry_date'=>date('d-m-Y',strtotime($insurance->insurance_expiry)),'provider'=>$insurance->insurance_provider,'coverage_id'=>$insurance->insurance_coverage,'coverage'=>$coverage,'notes'=>$insurance->insurance_notes);

            return $this->sendResponse($result, 'Insurance Details');
        }
        else
        {
            return $this->sendError('Insurance Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_insurance(Request $request)
    {
        $rules = ['policy_no' => 'required',
                  'expiry_date' => 'required',  
                  'provider' => 'required',  
                  'coverage' => 'required'
                 ];
        
        $messages = ['policy_no.required' => 'Please Enter Policy Number',
                     'expiry_date.required' => 'Please Select Date',
                     'provider.required' => 'Please Enter Provider',
                     'coverage.required' => 'Please Select Coverage'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['insurance_policy_no']  = $request->policy_no;
            $upd['insurance_expiry']     = date('Y-m-d',strtotime($request->expiry_date));
            $upd['insurance_provider']   = $request->provider;
            $upd['insurance_coverage']   = $request->coverage;
            $upd['insurance_notes']      = $request->notes;
            $upd['insurance_updated_on'] = date('Y-m-d H:i:s');
            $upd['insurance_updated_by'] = $request->user()->staff_id;

            Insurance::where('insurance_id',$request->segment(3))->update($upd);

            $result = array('insurance_id' => $request->segment(3));

            return $this->sendResponse($result, 'Insurance Updated Successfully');
        }
    }

    public function coverages(Request $request)
    {
        $coverages = array(1=>'Liability',2=>'Comprehensive',3=>'Collision',4=>'Third Part');

        if(count($coverages) > 0)
        {
            foreach($coverages as $id => $coverage)
            {                
                $result[] = array('id'=>$id,'name'=>$coverage);
            }

            return $this->sendResponse($result, 'Coverage List');
        } 
        else
        {
            return $this->sendError('Coverage Not Available.', ['error'=>'Data Not Available']);
        }
    }
}