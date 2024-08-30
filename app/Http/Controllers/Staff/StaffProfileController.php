<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Department;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Training;
use App\Models\StaffQualification;
use App\Models\StaffInduction;
use App\Models\StaffLicence;
use App\Models\Staff;

class StaffProfileController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['staff_fname' => 'required',
                      'staff_lname' => 'required',
                      'staff_dob' => 'required',
                      'staff_email' => 'required|email',
                      'staff_mobile' => 'required',
                      'staff_haddress' => 'required',
                      'staff_hsuburb' => 'required',
                      'staff_hstate' => 'required',
                      'staff_hpost_code' => 'required',
                      'staff_ename' => 'required',
                      'staff_erelationship' => 'required',
                      'staff_ephone' => 'required',
                      'staff_residence' => 'required',
                      'staff_nationality' => 'required'  
                     ];
            
            $messages = ['staff_fname.required' => 'Please Enter First Name',
                         'staff_lname.required' => 'Please Enter Last Name',
                         'staff_dob.required' => 'Please Select DOB',
                         'staff_email.required' => 'Please Enter Email Address',
                         'staff_email.email' => 'Please Enter Valid Email Address',
                         'staff_mobile.required' => 'Please Enter Mobile',
                         'staff_haddress.required' => 'Please Enter Home Address',
                         'staff_hsuburb.required' => 'Please Enter Suburb',
                         'staff_hstate.required' => 'Please Enter State',
                         'staff_hpost_code.required' => 'Please Enter Post Code',
                         'staff_ename.required' => 'Please Enter Name',
                         'staff_erelationship.required' => 'Please Enter Relationship',
                         'staff_ephone.required' => 'Please Enter Phone',
                         'staff_residence.required' => 'Please Select Residence status',
                         'staff_nationality.required' => 'Please Enter Nationality'
                        ];
                        
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $check_staff = Staff::where('staff_email',$request->staff_email)->where('staff_id','!=',Auth::guard('staff')->user()->staff_id)->count();

                if($check_staff > 0)
                {
                    return redirect()->back()->with('error','Staff Already Added')->withInput();
                }
                
                $upd['staff_fname']            = $request->staff_fname;
                $upd['staff_lname']            = $request->staff_lname;
                $upd['staff_email']            = $request->staff_email;
                $upd['staff_mobile']           = $request->staff_mobile;
                $upd['staff_phone']            = $request->staff_phone;
                $upd['staff_dob']              = date('Y-m-d',strtotime($request->staff_dob));
                $upd['staff_haddress']         = $request->staff_haddress;
                $upd['staff_hsuburb']          = $request->staff_hsuburb;
                $upd['staff_hstate']           = $request->staff_hstate;
                $upd['staff_hpost_code']       = $request->staff_hpost_code;
                $upd['staff_oaddress']         = $request->staff_oaddress;
                $upd['staff_ostate']           = $request->staff_ostate;
                $upd['staff_ocountry']         = $request->staff_ocountry;
                $upd['staff_ophone']           = $request->staff_ophone;
                $upd['staff_ename']            = $request->staff_ename;
                $upd['staff_erelationship']    = $request->staff_erelationship;
                $upd['staff_ephone']           = $request->staff_ephone;
                $upd['staff_residence']        = $request->staff_residence;
                $upd['staff_country']          = $request->staff_country;
                $upd['staff_nationality']      = $request->staff_nationality;
                $upd['staff_dlicense_country'] = $request->staff_dlicense_country;
                $upd['staff_sannuation_funds'] = $request->staff_sannuation_funds;
                $upd['staff_tax_no']           = $request->staff_tax_no;
                $upd['staff_updated_on']       = date('Y-m-d H:i:s');
                $upd['staff_updated_by']       = Auth::guard('staff')->user()->staff_id;

                if($request->hasFile('staff_image'))
                {
                    $staff_image = $request->staff_image->store('assets/admin/uploads/profile');
                    
                    $staff_image = explode('/',$staff_image);
                    $staff_image = end($staff_image);
                    $upd['staff_image'] = $staff_image;
                }

                $add = Staff::where('staff_id',Auth::guard('staff')->user()->staff_id)->update($upd);

                return redirect()->back()->with('success','Details Updated Successfully');
            }
        }

        $where_staff['staff_id'] = Auth::guard('staff')->user()->staff_id;
        $data['staff'] = Staff::getDetail($where_staff);

        $data['qualifications'] = StaffQualification::where('squalification_staff',Auth::guard('staff')->user()->staff_id)->get();

        $data['inductions'] = StaffInduction::where('sinduction_staff',Auth::guard('staff')->user()->staff_id)->get();

        $data['licences'] = StaffLicence::where('slicence_staff',Auth::guard('staff')->user()->staff_id)->get();

        $data['departments'] = Department::where('department_status',1)->orderby('department_name','asc')->get();

        $data['roles'] = Role::where('role_status',1)->get();

        $data['customers'] = Customer::where('customer_status',1)->orderby('customer_name','asc')->get();

        $data['trainings'] = Training::where('training_status',1)->orderby('training_name','asc')->get();

        $data['set'] = 'profile';
        return view('staff.profile.profile',$data);
    }

    public function add_staff_qualification(Request $request)
    {
        if($request->has('submit'))
        {
            $upd['staff_education_details'] = json_encode($request->education_details);
            $upd['staff_updated_on']        = date('Y-m-d H:i:s');
            $upd['staff_updated_by']        = Auth::guard('staff')->user()->staff_id;

            $add = Staff::where('staff_id',Auth::guard('staff')->user()->staff_id)->update($upd);

            $file_names = array();

            if(!empty($request->certification_copy))
            {
                $file_names = $request->certification_copy;
            }

            if(!empty($request->certification_details['FILE']))
            {
                foreach($request->certification_details['FILE'] as $fkey => $certificate_file) 
                {
                    $file_path = $certificate_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/staff';

                    $certificate_file->storeAs($final_file_path, $file_name);

                    $file_names[$fkey] = $file_name;
                }
            }

            $staff_certification_details = array('CBODY' => $request->certification_details['CBODY'],'CHELD' => $request->certification_details['CHELD'],'CLEVEL' => $request->certification_details['CLEVEL'],'CDATE' => $request->certification_details['CDATE'],'EDATE' => $request->certification_details['EDATE'],'PSTATUS' => $request->certification_details['PSTATUS'],'FILE' => $file_names);

            
            StaffQualification::where('squalification_staff',Auth::guard('staff')->user()->staff_id)->delete();

            foreach($staff_certification_details['CBODY'] as $key => $staff_certification_detail)
            {
                if(isset($staff_certification_details['FILE'][$key])){ $staff_file = $staff_certification_details['FILE'][$key]; }else{ $staff_file = NULL; }

                $ins_certificate['squalification_staff']      = Auth::guard('staff')->user()->staff_id;
                $ins_certificate['squalification_cbody']      = $staff_certification_details['CBODY'][$key];
                $ins_certificate['squalification_held']       = $staff_certification_details['CHELD'][$key];
                $ins_certificate['squalification_level']      = $staff_certification_details['CLEVEL'][$key];
                $ins_certificate['squalification_date']       = date('Y-m-d',strtotime($staff_certification_details['CDATE'][$key]));
                $ins_certificate['squalification_edate']      = date('Y-m-d',strtotime($staff_certification_details['EDATE'][$key]));
                $ins_certificate['squalification_pstatus']    = $staff_certification_details['PSTATUS'][$key];
                $ins_certificate['squalification_copy']       = $staff_file;
                $ins_certificate['squalification_added_on']   = date('Y-m-d H:i:s');
                $ins_certificate['squalification_added_by']   = Auth::guard('staff')->user()->staff_id;
                $ins_certificate['squalification_updated_on'] = date('Y-m-d H:i:s');
                $ins_certificate['squalification_updated_by'] = Auth::guard('staff')->user()->staff_id;
                $ins_certificate['squalification_status']     = 1;

                StaffQualification::create($ins_certificate);
            }

            return redirect()->back()->with('success','Details Updated Successfully');
        }
    }

    public function add_staff_induction(Request $request)
    {
        if($request->has('submit'))
        {
            $file_names = array();

            if(!empty($request->induction_evidence))
            {
                $file_names = $request->induction_evidence;
            }

            if(!empty($request->induction_details['FILE']))
            {
                foreach($request->induction_details['FILE'] as $ikey => $induction_file) 
                {
                    $file_path = $induction_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/staff';

                    $induction_file->storeAs($final_file_path, $file_name);

                    $file_names[$ikey] = $file_name;
                }
            }

            $staff_induction_details = array('CLIENT' => $request->induction_details['CLIENT'],'SITE' => $request->induction_details['SITE'],'NAME' => $request->induction_details['NAME'],'TYPE' => $request->induction_details['TYPE'],'IDATE' => $request->induction_details['IDATE'],'EDATE' => $request->induction_details['EDATE'],'PSTATUS' => $request->induction_details['PSTATUS'],'FILE' => $file_names);

            StaffInduction::where('sinduction_staff',Auth::guard('staff')->user()->staff_id)->delete();

            foreach($staff_induction_details['IDATE'] as $key => $staff_induction_detail)
            {
                if(isset($staff_induction_details['FILE'][$key])){ $staff_file = $staff_induction_details['FILE'][$key]; }else{ $staff_file = NULL; }
                
                $ins_induction['sinduction_staff']      = Auth::guard('staff')->user()->staff_id;
                $ins_induction['sinduction_client']     = $staff_induction_details['CLIENT'][$key];
                $ins_induction['sinduction_site']       = $staff_induction_details['SITE'][$key];
                $ins_induction['sinduction_name']       = $staff_induction_details['NAME'][$key];
                $ins_induction['sinduction_type']       = $staff_induction_details['TYPE'][$key];
                $ins_induction['sinduction_date']       = date('Y-m-d',strtotime($staff_induction_details['IDATE'][$key]));
                $ins_induction['sinduction_edate']      = date('Y-m-d',strtotime($staff_induction_details['EDATE'][$key]));
                $ins_induction['sinduction_pstatus']    = $staff_induction_details['PSTATUS'][$key];
                $ins_induction['sinduction_copy']       = $staff_file;
                $ins_induction['sinduction_added_on']   = date('Y-m-d H:i:s');
                $ins_induction['sinduction_added_by']   = Auth::guard('staff')->user()->staff_id;
                $ins_induction['sinduction_updated_on'] = date('Y-m-d H:i:s');
                $ins_induction['sinduction_updated_by'] = Auth::guard('staff')->user()->staff_id;
                $ins_induction['sinduction_status']     = 1;

                StaffInduction::create($ins_induction);
            }

            return redirect()->back()->with('success','Details Updated Successfully');
        }
    }

    public function add_staff_licence(Request $request)
    {
        if($request->has('submit'))
        {
            $file_names = array();

            if(!empty($request->licence_copy))
            {
                $file_names = $request->licence_copy;
            }

            if(!empty($request->validation_details['FILE']))
            {
                foreach($request->validation_details['FILE'] as $vkey => $validation_file) 
                {
                    $file_path = $validation_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/staff';

                    $validation_file->storeAs($final_file_path, $file_name);

                    $file_names[$vkey] = $file_name;
                }
            }

            $staff_validation_details = array('TRAINING' => $request->validation_details['TRAINING'],'LOCATION' => $request->validation_details['LOCATION'],'ORGANISATION' => $request->validation_details['ORGANISATION'],'TYPE' => $request->validation_details['TYPE'],'VDATE' => $request->validation_details['VDATE'],'EDATE' => $request->validation_details['EDATE'],'PSTATUS' => $request->validation_details['PSTATUS'],'FILE' => $file_names);

            StaffLicence::where('slicence_staff',Auth::guard('staff')->user()->staff_id)->delete();

            foreach($staff_validation_details['VDATE'] as $key => $staff_validation_detail)
            {
                if(isset($staff_validation_details['FILE'][$key])){ $staff_file = $staff_validation_details['FILE'][$key]; }else{ $staff_file = NULL; }
                
                $ins_validation['slicence_staff']         = Auth::guard('staff')->user()->staff_id;
                $ins_validation['slicence_training']      = $staff_validation_details['TRAINING'][$key];
                $ins_validation['slicence_tlocation']     = $staff_validation_details['LOCATION'][$key];
                $ins_validation['slicence_torganisation'] = $staff_validation_details['ORGANISATION'][$key];
                $ins_validation['slicence_training_type'] = $staff_validation_details['TYPE'][$key];
                $ins_validation['slicence_date']          = date('Y-m-d',strtotime($staff_validation_details['VDATE'][$key]));
                $ins_validation['slicence_edate']         = date('Y-m-d',strtotime($staff_validation_details['EDATE'][$key]));
                $ins_validation['slicence_pstatus']       = $staff_validation_details['PSTATUS'][$key];
                $ins_validation['slicence_copy']          = $staff_file;
                $ins_validation['slicence_added_on']      = date('Y-m-d H:i:s');
                $ins_validation['slicence_added_by']      = Auth::guard('staff')->user()->staff_id;
                $ins_validation['slicence_updated_on']    = date('Y-m-d H:i:s');
                $ins_validation['slicence_updated_by']    = Auth::guard('staff')->user()->staff_id;
                $ins_validation['slicence_status']        = 1;

                StaffLicence::create($ins_validation);
            }

            return redirect()->back()->with('success','Details Updated Successfully');
        }
    }

    public function add_staff_identification(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['staff_id_country' => 'required',
                      'staff_id_type' => 'required'
                     ];
            
            $messages = ['staff_id_country.required' => 'Please Enter County of Issue',
                         'staff_id_type.required' => 'Please Select Type'
                        ];
                        
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {                
                $upd['staff_id_country']        = $request->staff_id_country;
                $upd['staff_id_type']           = $request->staff_id_type;
                $upd['staff_id_classification'] = $request->staff_id_classification;
                $upd['staff_id_other']          = $request->staff_id_other;
                $upd['staff_id_oissue']         = $request->staff_id_oissue;
                $upd['staff_updated_on']        = date('Y-m-d H:i:s');
                $upd['staff_updated_by']        = Auth::guard('staff')->user()->staff_id;

                if(!empty($request->staff_id_expiry))
                {
                    $upd['staff_id_expiry'] = date('Y-m-d',strtotime($request->staff_id_expiry));
                }
                else
                {
                    $upd['staff_id_oexpiry'] = NULL;
                }

                if(!empty($request->staff_id_oexpiry))
                {
                    $upd['staff_id_oexpiry'] = date('Y-m-d',strtotime($request->staff_id_oexpiry));
                }
                else
                {
                    $upd['staff_id_oexpiry'] = NULL;
                }

                if($request->hasFile('staff_id_copy'))
                {
                    $staff_id_copy = $request->staff_id_copy->store('assets/admin/uploads/staff');
                    
                    $staff_id_copy = explode('/',$staff_id_copy);
                    $staff_id_copy = end($staff_id_copy);
                    $upd['staff_id_copy'] = $staff_id_copy;
                }

                $add = Staff::where('staff_id',Auth::guard('staff')->user()->staff_id)->update($upd);

                return redirect()->back()->with('success','Details Updated Successfully');
            }
        }
    }

    public function add_staff_document(Request $request)
    {
        if($request->has('submit'))
        {
            $upd['staff_updated_on'] = date('Y-m-d H:i:s');
            $upd['staff_updated_by'] = Auth::guard('staff')->user()->staff_id;

            $file_names = array();

            if(!empty($request->documents))
            {
                $file_names = $request->documents;
            }

            if(!empty($request->document['FILE']))
            {
                foreach($request->document['FILE'] as $dkey => $document_file) 
                {
                    $file_path = $document_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/staff';

                    $document_file->storeAs($final_file_path, $file_name);

                    $file_names[$dkey] = $file_name;
                }
            }

            $staff_documents = array('NAME' => $request->document['NAME'],'FILE' => $file_names);

            $upd['staff_documents'] = json_encode($staff_documents);

            $add = Staff::where('staff_id',Auth::guard('staff')->user()->staff_id)->update($upd);

            return redirect()->back()->with('success','Details Updated Successfully');
        }
    }

    public function change_password(Request $request)
    {        
        if($request->has('submit'))
        {            
            $rules = ['old_password' => 'required',
                      'new_password' => 'required',
                      'confirm_password' => 'required|same:new_password'];
                      
            $messages = ['old_password.required' => 'Please Enter Old Password',
                         'new_password.required' => 'Please Enter New Password',
                         'confirm_password.required' => 'Please Enter Confirm Password'];
          
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['staff_id'] = Auth::guard('staff')->user()->staff_id;
                $where['staff_vpassword'] = base64_encode($request->old_password);
        
                $check = Staff::where($where)->count();
                
                if($check > 0)
                {
                    $upd['staff_password']   = bcrypt($request->confirm_password);
                    $upd['staff_vpassword']  = base64_encode($request->confirm_password);
                    $upd['staff_updated_on'] = date('Y-m-d H:i:s');
                    $upd['staff_updated_by'] = Auth::guard('staff')->user()->staff_id;

                    $update = Staff::where('staff_id',Auth::guard('staff')->user()->staff_id)->update($upd);
                    
                    return redirect()->back()->with('success','Password Changed Successfully');
                }
                else
                {
                    return redirect()->back()->with('error','Old Password Does Not Match');
                }
            }
        }

        $data['set'] = 'change_password';
        return view('staff.profile.change_password',$data);
    }

    public function check_old_password(Request $request)
    {   
        $where['staff_id']  = Auth::guard('staff')->user()->staff_id;
        $where['staff_vpassword'] = base64_encode($request->old_password);
        
        $check = Staff::where($where)->count();

        if($check > 0)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }
}
