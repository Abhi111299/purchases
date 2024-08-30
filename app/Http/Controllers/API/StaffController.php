<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Training;
use App\Models\StaffInduction;
use App\Models\StaffLicence;
use App\Models\Staff;
   
class StaffController extends BaseController
{
    public function index(Request $request)
    {
        $staffs = Staff::where('staff_status',1)->orderby('staff_fname','asc')->get();

        if($staffs->count() > 0)
        {
            foreach($staffs as $staff)
            {
                $result[] = array('id'=>$staff->staff_id,'name'=>$staff->staff_fname.' '.$staff->staff_lname);
            }

            return $this->sendResponse($result, 'Staff List');
        }
        else
        {
            return $this->sendError('Staffs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function safety_inductions(Request $request)
    {
        $where['sinduction_status'] = 1;
        $where['staff_id'] = $request->user()->staff_id;
        $inductions = StaffInduction::getDetails($where);

        if($inductions->count() > 0)
        {
            foreach($inductions as $induction)
            {
                if($induction->sinduction_type == 1)
                {
                    $type_name = 'Online';
                }
                elseif($induction->sinduction_type == 2)
                {
                    $type_name = 'Face to Face';
                }
                elseif($induction->sinduction_type == 3)
                {
                    $type_name = 'Other';
                }

                if($induction->sinduction_pstatus == 1)
                {
                    $pay_status = 'Self';
                }
                elseif($induction->sinduction_pstatus == 2)
                {
                    $pay_status = 'Company';
                }
                elseif($induction->sinduction_pstatus == 3)
                {
                    $pay_status = 'Others';
                }

                $induction_date = date('d M Y',strtotime($induction->sinduction_date));
                $expiry_date = date('d M Y',strtotime($induction->sinduction_edate));

                $evidence_copy = NULL;

                if(!empty($induction->sinduction_copy))
                {
                    $evidence_copy = asset(config('constants.admin_path').'uploads/staff').'/'.$induction->sinduction_copy;
                }

                $result[] = array('id'=>$induction->sinduction_id,'client'=>$induction->customer_name,'client_id'=>$induction->customer_id,'site'=>$induction->sinduction_site,'name'=>$induction->sinduction_name,'type'=>$type_name,'type_id'=>$induction->sinduction_type,'induction_date'=>$induction_date,'expiry_date'=>$expiry_date,'payment_status'=>$pay_status,'payment_status_id'=>$induction->sinduction_pstatus,'evidence'=>$evidence_copy);
            }

            return $this->sendResponse($result, 'Safety Induction Details');
        }
        else
        {
            return $this->sendError('Safety Inductions Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_safety_induction(Request $request)
    {
        $rules = ['client' => 'required',
                  'site' => 'required',
                  'induction' => 'required',
                  'type' => 'required',
                  'date' => 'required',
                  'expiry_date' => 'required',
                  'pay_status' => 'required'
                 ];
    
        $messages = ['client.required' => 'Please Select Client',
                     'site.required' => 'Please Enter Inducted Site',
                     'induction.required' => 'Please Enter Induction',
                     'type.required' => 'Please Select Type',
                     'date.required' => 'Please Select Date',
                     'expiry_date.required' => 'Please Select Expiry Date',
                     'pay_status.required' => 'Please Select Payment Status'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['sinduction_staff']      = $request->user()->staff_id;
            $ins['sinduction_client']     = $request->client;
            $ins['sinduction_site']       = $request->site;
            $ins['sinduction_name']       = $request->induction;
            $ins['sinduction_type']       = $request->type;
            $ins['sinduction_date']       = date('Y-m-d',strtotime($request->date));
            $ins['sinduction_edate']      = date('Y-m-d',strtotime($request->expiry_date));
            $ins['sinduction_pstatus']    = $request->pay_status;
            $ins['sinduction_added_on']   = date('Y-m-d H:i:s');
            $ins['sinduction_added_by']   = $request->user()->staff_id;
            $ins['sinduction_updated_on'] = date('Y-m-d H:i:s');
            $ins['sinduction_updated_by'] = $request->user()->staff_id;
            $ins['sinduction_status']     = 1;
            
            if($request->hasFile('evidence'))
            {
                $evidence = $request->evidence->store('assets/admin/uploads/staff');
                
                $evidence = explode('/',$evidence);
                $evidence = end($evidence);
                $ins['sinduction_copy'] = $evidence;
            }

            $add = StaffInduction::create($ins);

            if($add)
            {
                $result = array('induction_id' => $add->sinduction_id);

                return $this->sendResponse($result, 'Safety Inductions Added Successfully');
            }
            else
            {
                return $this->sendError('Safety Induction Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function safety_induction_details(Request $request)
    {
        $where['sinduction_status'] = 1;
        $where['staff_id'] = $request->user()->staff_id;
        $where['sinduction_id'] = $request->segment(3);
        $induction = StaffInduction::getDetail($where);

        if(isset($induction))
        {
            if($induction->sinduction_type == 1)
            {
                $type_name = 'Online';
            }
            elseif($induction->sinduction_type == 2)
            {
                $type_name = 'Face to Face';
            }
            elseif($induction->sinduction_type == 3)
            {
                $type_name = 'Other';
            }

            if($induction->sinduction_pstatus == 1)
            {
                $pay_status = 'Self';
            }
            elseif($induction->sinduction_pstatus == 2)
            {
                $pay_status = 'Company';
            }
            elseif($induction->sinduction_pstatus == 3)
            {
                $pay_status = 'Others';
            }

            $induction_date = date('d M Y',strtotime($induction->sinduction_date));
            $expiry_date = date('d M Y',strtotime($induction->sinduction_edate));

            $evidence_copy = NULL;

            if(!empty($induction->sinduction_copy))
            {
                $evidence_copy = asset(config('constants.admin_path').'uploads/staff').'/'.$induction->sinduction_copy;
            }

            $result = array('id'=>$induction->sinduction_id,'client'=>$induction->customer_name,'client_id'=>$induction->customer_id,'site'=>$induction->sinduction_site,'name'=>$induction->sinduction_name,'type'=>$type_name,'type_id'=>$induction->sinduction_type,'induction_date'=>$induction_date,'expiry_date'=>$expiry_date,'payment_status'=>$pay_status,'payment_status_id'=>$induction->sinduction_pstatus,'evidence'=>$evidence_copy);

            return $this->sendResponse($result, 'Safety Induction Details');
        }
        else
        {
            return $this->sendError('Safety Induction Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_safety_induction(Request $request)
    {
        $rules = ['client' => 'required',
                  'site' => 'required',
                  'induction' => 'required',
                  'type' => 'required',
                  'date' => 'required',
                  'expiry_date' => 'required',
                  'pay_status' => 'required'
                 ];
    
        $messages = ['client.required' => 'Please Select Client',
                     'site.required' => 'Please Enter Inducted Site',
                     'induction.required' => 'Please Enter Induction',
                     'type.required' => 'Please Select Type',
                     'date.required' => 'Please Select Date',
                     'expiry_date.required' => 'Please Select Expiry Date',
                     'pay_status.required' => 'Please Select Payment Status'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['sinduction_client']     = $request->client;
            $upd['sinduction_site']       = $request->site;
            $upd['sinduction_name']       = $request->induction;
            $upd['sinduction_type']       = $request->type;
            $upd['sinduction_date']       = date('Y-m-d',strtotime($request->date));
            $upd['sinduction_edate']      = date('Y-m-d',strtotime($request->expiry_date));
            $upd['sinduction_pstatus']    = $request->pay_status;
            $upd['sinduction_updated_on'] = date('Y-m-d H:i:s');
            $upd['sinduction_updated_by'] = $request->user()->staff_id;
            
            if($request->hasFile('evidence'))
            {
                $evidence = $request->evidence->store('assets/admin/uploads/staff');
                
                $evidence = explode('/',$evidence);
                $evidence = end($evidence);
                $upd['sinduction_copy'] = $evidence;
            }

            StaffInduction::where('sinduction_id',$request->segment(3))->update($upd);

            $result = array('induction_id' => $request->segment(3));

            return $this->sendResponse($result, 'Safety Induction Updated Successfully');
        }
    }

    public function safety_licences(Request $request)
    {
        $where['slicence_status'] = 1;
        $where['staff_id'] = $request->user()->staff_id;
        $licences = StaffLicence::getDetails($where);

        if($licences->count() > 0)
        {
            foreach($licences as $licence)
            {
                if($licence->slicence_training_type == 1)
                {
                    $type_name = 'Online';
                }
                elseif($licence->slicence_training_type == 2)
                {
                    $type_name = 'Face to Face';
                }
                elseif($licence->slicence_training_type == 3)
                {
                    $type_name = 'Other';
                }

                if($licence->slicence_pstatus == 1)
                {
                    $pay_status = 'Self';
                }
                elseif($licence->slicence_pstatus == 2)
                {
                    $pay_status = 'Company';
                }
                elseif($licence->slicence_pstatus == 3)
                {
                    $pay_status = 'Others';
                }

                $validation_date = date('d M Y',strtotime($licence->slicence_date));
                $expiry_date = date('d M Y',strtotime($licence->slicence_edate));

                $licence_copy = NULL;

                if(!empty($licence->slicence_copy))
                {
                    $licence_copy = asset(config('constants.admin_path').'uploads/staff').'/'.$licence->slicence_copy;
                }

                $result[] = array('id'=>$licence->slicence_id,'training'=>$licence->training_name,'training_id'=>$licence->training_id,'location'=>$licence->slicence_tlocation,'name'=>$licence->slicence_torganisation,'type'=>$type_name,'type_id'=>$licence->slicence_training_type,'validation_date'=>$validation_date,'expiry_date'=>$expiry_date,'payment_status'=>$pay_status,'payment_status_id'=>$licence->slicence_pstatus,'licence'=>$licence_copy);
            }

            return $this->sendResponse($result, 'Safety Licence Details');
        }
        else
        {
            return $this->sendError('Safety Licences Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_safety_licence(Request $request)
    {
        $rules = ['training' => 'required',
                  'location' => 'required',
                  'organisation' => 'required',
                  'type' => 'required',
                  'validation_date' => 'required',
                  'expiry_date' => 'required',
                  'pay_status' => 'required'
                 ];
    
        $messages = ['training.required' => 'Please Select Training',
                     'location.required' => 'Please Enter Location',
                     'organisation.required' => 'Please Enter Organisation',
                     'type.required' => 'Please Select Type',
                     'validation_date.required' => 'Please Select Date',
                     'expiry_date.required' => 'Please Select Expiry Date',
                     'pay_status.required' => 'Please Select Payment Status'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['slicence_staff']         = $request->user()->staff_id;
            $ins['slicence_training']      = $request->training;
            $ins['slicence_tlocation']     = $request->location;
            $ins['slicence_torganisation'] = $request->organisation;
            $ins['slicence_training_type'] = $request->type;
            $ins['slicence_date']          = date('Y-m-d',strtotime($request->validation_date));
            $ins['slicence_edate']         = date('Y-m-d',strtotime($request->expiry_date));
            $ins['slicence_pstatus']       = $request->pay_status;
            $ins['slicence_added_on']      = date('Y-m-d H:i:s');
            $ins['slicence_added_by']      = $request->user()->staff_id;
            $ins['slicence_updated_on']    = date('Y-m-d H:i:s');
            $ins['slicence_updated_by']    = $request->user()->staff_id;
            $ins['slicence_status']        = 1;
            
            if($request->hasFile('licency_copy'))
            {
                $licency_copy = $request->licency_copy->store('assets/admin/uploads/staff');
                
                $licency_copy = explode('/',$licency_copy);
                $licency_copy = end($licency_copy);
                $ins['slicence_copy'] = $licency_copy;
            }

            $add = StaffLicence::create($ins);

            if($add)
            {
                $result = array('licence_id' => $add->slicence_id);

                return $this->sendResponse($result, 'Safety Licence Added Successfully');
            }
            else
            {
                return $this->sendError('Safety Licence Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function safety_licence_details(Request $request)
    {
        $where['slicence_status'] = 1;
        $where['staff_id'] = $request->user()->staff_id;
        $where['slicence_id'] = $request->segment(3);
        $licence = StaffLicence::getDetail($where);

        if(isset($licence))
        {
            if($licence->slicence_training_type == 1)
            {
                $type_name = 'Online';
            }
            elseif($licence->slicence_training_type == 2)
            {
                $type_name = 'Face to Face';
            }
            elseif($licence->slicence_training_type == 3)
            {
                $type_name = 'Other';
            }

            if($licence->slicence_pstatus == 1)
            {
                $pay_status = 'Self';
            }
            elseif($licence->slicence_pstatus == 2)
            {
                $pay_status = 'Company';
            }
            elseif($licence->slicence_pstatus == 3)
            {
                $pay_status = 'Others';
            }

            $validation_date = date('d M Y',strtotime($licence->slicence_date));
            $expiry_date = date('d M Y',strtotime($licence->slicence_edate));

            $licence_copy = NULL;

            if(!empty($licence->slicence_copy))
            {
                $licence_copy = asset(config('constants.admin_path').'uploads/staff').'/'.$licence->slicence_copy;
            }

            $result = array('id'=>$licence->slicence_id,'training'=>$licence->training_name,'training_id'=>$licence->training_id,'location'=>$licence->slicence_tlocation,'name'=>$licence->slicence_torganisation,'type'=>$type_name,'type_id'=>$licence->slicence_training_type,'validation_date'=>$validation_date,'expiry_date'=>$expiry_date,'payment_status'=>$pay_status,'payment_status_id'=>$licence->slicence_pstatus,'licence'=>$licence_copy);

            return $this->sendResponse($result, 'Safety Licence Details');
        }
        else
        {
            return $this->sendError('Safety Licence Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_safety_licence(Request $request)
    {
        $rules = ['training' => 'required',
                  'location' => 'required',
                  'organisation' => 'required',
                  'type' => 'required',
                  'validation_date' => 'required',
                  'expiry_date' => 'required',
                  'pay_status' => 'required'
                 ];
    
        $messages = ['training.required' => 'Please Select Training',
                     'location.required' => 'Please Enter Location',
                     'organisation.required' => 'Please Enter Organisation',
                     'type.required' => 'Please Select Type',
                     'validation_date.required' => 'Please Select Date',
                     'expiry_date.required' => 'Please Select Expiry Date',
                     'pay_status.required' => 'Please Select Payment Status'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['slicence_training']      = $request->training;
            $upd['slicence_tlocation']     = $request->location;
            $upd['slicence_torganisation'] = $request->organisation;
            $upd['slicence_training_type'] = $request->type;
            $upd['slicence_date']          = date('Y-m-d',strtotime($request->validation_date));
            $upd['slicence_edate']         = date('Y-m-d',strtotime($request->expiry_date));
            $upd['slicence_pstatus']       = $request->pay_status;
            $upd['slicence_updated_on']    = date('Y-m-d H:i:s');
            $upd['slicence_updated_by']    = $request->user()->staff_id;
            
            if($request->hasFile('licency_copy'))
            {
                $licency_copy = $request->licency_copy->store('assets/admin/uploads/staff');
                
                $licency_copy = explode('/',$licency_copy);
                $licency_copy = end($licency_copy);
                $upd['slicence_copy'] = $licency_copy;
            }

            StaffLicence::where('slicence_id',$request->segment(3))->update($upd);

            $result = array('licence_id' => $request->segment(3));

            return $this->sendResponse($result, 'Safety Licence Updated Successfully');
        }
    }

    public function safety_type(Request $request)
    {
        $types = array(1=>'Online',2=>'Face to Face',3=>'Other');

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

    public function payment_status(Request $request)
    {
        $statuses = array(1=>'Self',2=>'Company',3=>'Others');

        if(count($statuses) > 0)
        {
            foreach($statuses as $id => $status)
            {
                $result[] = array('id'=>$id,'name'=>$status);
            }

            return $this->sendResponse($result, 'Payment Status List');
        } 
        else
        {
            return $this->sendError('Payment Status Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function trainings(Request $request)
    {
        $trainings = Training::where('training_status',1)->orderby('training_name','asc')->get();

        if(count($trainings) > 0)
        {
            foreach($trainings as $training)
            {
                $result[] = array('id'=>$training->training_id,'name'=>$training->training_name);
            }

            return $this->sendResponse($result, 'Training List');
        } 
        else
        {
            return $this->sendError('Trainings Not Available.', ['error'=>'Data Not Available']);
        }
    }
}