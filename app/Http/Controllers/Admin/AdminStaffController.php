<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Excel;
use Validator;
use DataTables;
use App\Exports\CertificateExport;
use App\Exports\InductionExport;
use App\Exports\LicenceExport;
use App\Models\Department;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Training;
use App\Models\StaffQualification;
use App\Models\StaffInduction;
use App\Models\StaffLicence;
use App\Models\Staff;

class AdminStaffController extends Controller
{
    public function index()
    {
        if (!in_array('2', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'staffs';
        return view('admin.staff.staffs', $data);
    }

    public function get_staffs(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->employment_status)) {
                $where['staff_employement'] = $request->employment_status;
            }

            $where['staff_trash'] = 1;
            $data = Staff::getDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = $row->staff_fname . ' ' . $row->staff_lname;

                    return $staff_name;
                })
                ->addColumn('dob', function ($row) {

                    $dob = date('d M Y', strtotime($row->staff_dob));

                    return $dob;
                })
                ->addColumn('employment_status', function ($row) {

                    if ($row->staff_employement == 1) {
                        $employment_status = 'Current';
                    } elseif ($row->staff_employement == 2) {
                        $employment_status = 'Ex-Employee';
                    }

                    return $employment_status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_staff/' . $row->staff_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->staff_status == 1) {
                        $btn .= '<a href="/admin/staff_status/' . $row->staff_id . '/' . $row->staff_status . '" class="btn btn-danger btn-sm rounded-circle" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/staff_status/' . $row->staff_id . '/' . $row->staff_status . '" class="btn btn-success btn-sm rounded-circle" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_staff(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'staff_no' => 'required',
                'staff_dept' => 'required',
                'staff_role' => 'required',
                'staff_job_type' => 'required',
                'staff_fname' => 'required',
                'staff_lname' => 'required',
                'staff_dob' => 'required',
                'staff_email' => 'required|email',
                'staff_mobile' => 'required',
                'staff_password' => 'required',
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

            $messages = [
                'staff_no.required' => 'Please Enter Employee No',
                'staff_dept.required' => 'Please Select Department',
                'staff_role.required' => 'Please Select Job Title',
                'staff_job_type.required' => 'Please Select Job Status',
                'staff_fname.required' => 'Please Enter First Name',
                'staff_lname.required' => 'Please Enter Last Name',
                'staff_dob.required' => 'Please Select DOB',
                'staff_email.required' => 'Please Enter Email Address',
                'staff_email.email' => 'Please Enter Valid Email Address',
                'staff_mobile.required' => 'Please Enter Mobile',
                'staff_password.required' => 'Please Enter Password',
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

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_staff = Staff::where('staff_email', $request->staff_email)->count();

                if ($check_staff > 0) {
                    return redirect()->back()->with('error', 'Staff Already Added')->withInput();
                }

                $ins['staff_no']               = $request->staff_no;
                $ins['staff_dept']             = $request->staff_dept;
                $ins['staff_role']             = $request->staff_role;
                $ins['staff_job_type']         = $request->staff_job_type;
                $ins['staff_fname']            = $request->staff_fname;
                $ins['staff_lname']            = $request->staff_lname;
                $ins['staff_email']            = $request->staff_email;
                $ins['staff_password']         = bcrypt($request->staff_password);
                $ins['staff_vpassword']        = base64_encode($request->staff_password);
                $ins['staff_mobile']           = $request->staff_mobile;
                $ins['staff_phone']            = $request->staff_phone;
                $ins['staff_dob']              = date('Y-m-d', strtotime($request->staff_dob));
                $ins['staff_haddress']         = $request->staff_haddress;
                $ins['staff_hsuburb']          = $request->staff_hsuburb;
                $ins['staff_hstate']           = $request->staff_hstate;
                $ins['staff_hpost_code']       = $request->staff_hpost_code;
                $ins['staff_oaddress']         = $request->staff_oaddress;
                $ins['staff_ostate']           = $request->staff_ostate;
                $ins['staff_ocountry']         = $request->staff_ocountry;
                $ins['staff_ophone']           = $request->staff_ophone;
                $ins['staff_ename']            = $request->staff_ename;
                $ins['staff_erelationship']    = $request->staff_erelationship;
                $ins['staff_ephone']           = $request->staff_ephone;
                $ins['staff_residence']        = $request->staff_residence;
                $ins['staff_country']          = $request->staff_country;
                $ins['staff_nationality']      = $request->staff_nationality;
                $ins['staff_dlicense_country'] = $request->staff_dlicense_country;
                $ins['staff_sannuation_funds'] = $request->staff_sannuation_funds;
                $ins['staff_tax_no']           = $request->staff_tax_no;
                $ins['staff_employement']      = 1;
                $ins['staff_added_on']         = date('Y-m-d H:i:s');
                $ins['staff_added_by']         = Auth::guard('admin')->user()->admin_id;
                $ins['staff_updated_on']       = date('Y-m-d H:i:s');
                $ins['staff_updated_by']       = Auth::guard('admin')->user()->admin_id;
                $ins['staff_status']           = 1;
                $ins['staff_trash']            = 1;

                $add = Staff::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Staff Added Successfully');
                }
            }
        }

        if (!in_array('2', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['departments'] = Department::where('department_status', 1)->orderby('department_name', 'asc')->get();

        $data['roles'] = Role::where('role_status', 1)->get();

        $data['set'] = 'add_staff';
        return view('admin.staff.add_staff', $data);
    }

    public function edit_staff(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'staff_no' => 'required',
                'staff_dept' => 'required',
                'staff_role' => 'required',
                'staff_job_type' => 'required',
                'staff_fname' => 'required',
                'staff_lname' => 'required',
                'staff_dob' => 'required',
                'staff_email' => 'required|email',
                'staff_mobile' => 'required',
                'staff_password' => 'required',
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

            $messages = [
                'staff_no.required' => 'Please Enter Employee No',
                'staff_dept.required' => 'Please Select Department',
                'staff_role.required' => 'Please Select Job Title',
                'staff_job_type.required' => 'Please Select Job Status',
                'staff_fname.required' => 'Please Enter First Name',
                'staff_lname.required' => 'Please Enter Last Name',
                'staff_dob.required' => 'Please Select DOB',
                'staff_email.required' => 'Please Enter Email Address',
                'staff_email.email' => 'Please Enter Valid Email Address',
                'staff_mobile.required' => 'Please Enter Mobile',
                'staff_password.required' => 'Please Enter Password',
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

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_staff = Staff::where('staff_email', $request->staff_email)->where('staff_id', '!=', $request->segment(3))->count();

                if ($check_staff > 0) {
                    return redirect()->back()->with('error', 'Staff Already Added')->withInput();
                }

                $upd['staff_no']               = $request->staff_no;
                $upd['staff_dept']             = $request->staff_dept;
                $upd['staff_role']             = $request->staff_role;
                $upd['staff_job_type']         = $request->staff_job_type;
                $upd['staff_fname']            = $request->staff_fname;
                $upd['staff_lname']            = $request->staff_lname;
                $upd['staff_email']            = $request->staff_email;
                $upd['staff_password']         = bcrypt($request->staff_password);
                $upd['staff_vpassword']        = base64_encode($request->staff_password);
                $upd['staff_mobile']           = $request->staff_mobile;
                $upd['staff_phone']            = $request->staff_phone;
                $upd['staff_dob']              = date('Y-m-d', strtotime($request->staff_dob));
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
                $upd['staff_employement']      = $request->staff_employement;
                $upd['staff_updated_on']       = date('Y-m-d H:i:s');
                $upd['staff_updated_by']       = Auth::guard('admin')->user()->admin_id;

                $add = Staff::where('staff_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Details Updated Successfully');
            }
        }

        $data['staff'] = Staff::where('staff_id', $request->segment(3))->first();

        if (!isset($data['staff'])) {
            return redirect('admin/staffs');
        }

        if (!in_array('2', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['qualifications'] = StaffQualification::where('squalification_staff', $request->segment(3))->get();

        $data['inductions'] = StaffInduction::where('sinduction_staff', $request->segment(3))->get();

        $data['licences'] = StaffLicence::where('slicence_staff', $request->segment(3))->get();

        $data['departments'] = Department::where('department_status', 1)->orderby('department_name', 'asc')->get();

        $data['roles'] = Role::where('role_status', 1)->get();

        $data['customers'] = Customer::where('customer_status', 1)->orderby('customer_name', 'asc')->get();

        $data['trainings'] = Training::where('training_status', 1)->orderby('training_name', 'asc')->get();

        $data['set'] = 'edit_staff';
        return view('admin.staff.edit_staff', $data);
    }

    public function add_staff_qualification(Request $request)
    {
        if ($request->has('submit')) {
            $upd['staff_education_details'] = json_encode($request->education_details);
            $upd['staff_updated_on']        = date('Y-m-d H:i:s');
            $upd['staff_updated_by']        = Auth::guard('admin')->user()->admin_id;

            $add = Staff::where('staff_id', $request->segment(3))->update($upd);

            $file_names = array();

            if (!empty($request->certification_copy)) {
                $file_names = $request->certification_copy;
            }

            if (!empty($request->certification_details['FILE'])) {
                foreach ($request->certification_details['FILE'] as $fkey => $certificate_file) {
                    $file_path = $certificate_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/staff';

                    $certificate_file->storeAs($final_file_path, $file_name);

                    $file_names[$fkey] = $file_name;
                }
            }

            $staff_certification_details = array('CBODY' => $request->certification_details['CBODY'], 'CHELD' => $request->certification_details['CHELD'], 'CLEVEL' => $request->certification_details['CLEVEL'], 'CDATE' => $request->certification_details['CDATE'], 'EDATE' => $request->certification_details['EDATE'], 'PSTATUS' => $request->certification_details['PSTATUS'], 'FILE' => $file_names);


            StaffQualification::where('squalification_staff', $request->segment(3))->delete();

            foreach ($staff_certification_details['CBODY'] as $key => $staff_certification_detail) {
                if (isset($staff_certification_details['FILE'][$key])) {
                    $staff_file = $staff_certification_details['FILE'][$key];
                } else {
                    $staff_file = NULL;
                }

                $ins_certificate['squalification_staff']      = $request->segment(3);
                $ins_certificate['squalification_cbody']      = $staff_certification_details['CBODY'][$key];
                $ins_certificate['squalification_held']       = $staff_certification_details['CHELD'][$key];
                $ins_certificate['squalification_level']      = $staff_certification_details['CLEVEL'][$key];
                $ins_certificate['squalification_date']       = date('Y-m-d', strtotime($staff_certification_details['CDATE'][$key]));
                $ins_certificate['squalification_edate']      = date('Y-m-d', strtotime($staff_certification_details['EDATE'][$key]));
                $ins_certificate['squalification_pstatus']    = $staff_certification_details['PSTATUS'][$key];
                $ins_certificate['squalification_copy']       = $staff_file;
                $ins_certificate['squalification_added_on']   = date('Y-m-d H:i:s');
                $ins_certificate['squalification_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins_certificate['squalification_updated_on'] = date('Y-m-d H:i:s');
                $ins_certificate['squalification_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins_certificate['squalification_status']     = 1;

                StaffQualification::create($ins_certificate);
            }

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function add_staff_induction(Request $request)
    {
        if ($request->has('submit')) {
            $file_names = array();

            if (!empty($request->induction_evidence)) {
                $file_names = $request->induction_evidence;
            }

            if (!empty($request->induction_details['FILE'])) {
                foreach ($request->induction_details['FILE'] as $ikey => $induction_file) {
                    $file_path = $induction_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/staff';

                    $induction_file->storeAs($final_file_path, $file_name);

                    $file_names[$ikey] = $file_name;
                }
            }

            $staff_induction_details = array('CLIENT' => $request->induction_details['CLIENT'], 'SITE' => $request->induction_details['SITE'], 'NAME' => $request->induction_details['NAME'], 'TYPE' => $request->induction_details['TYPE'], 'IDATE' => $request->induction_details['IDATE'], 'EDATE' => $request->induction_details['EDATE'], 'PSTATUS' => $request->induction_details['PSTATUS'], 'FILE' => $file_names);

            StaffInduction::where('sinduction_staff', $request->segment(3))->delete();

            foreach ($staff_induction_details['IDATE'] as $key => $staff_induction_detail) {
                if (isset($staff_induction_details['FILE'][$key])) {
                    $staff_file = $staff_induction_details['FILE'][$key];
                } else {
                    $staff_file = NULL;
                }

                $ins_induction['sinduction_staff']      = $request->segment(3);
                $ins_induction['sinduction_client']     = $staff_induction_details['CLIENT'][$key];
                $ins_induction['sinduction_site']       = $staff_induction_details['SITE'][$key];
                $ins_induction['sinduction_name']       = $staff_induction_details['NAME'][$key];
                $ins_induction['sinduction_type']       = $staff_induction_details['TYPE'][$key];
                $ins_induction['sinduction_date']       = date('Y-m-d', strtotime($staff_induction_details['IDATE'][$key]));
                $ins_induction['sinduction_edate']      = date('Y-m-d', strtotime($staff_induction_details['EDATE'][$key]));
                $ins_induction['sinduction_pstatus']    = $staff_induction_details['PSTATUS'][$key];
                $ins_induction['sinduction_copy']       = $staff_file;
                $ins_induction['sinduction_added_on']   = date('Y-m-d H:i:s');
                $ins_induction['sinduction_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins_induction['sinduction_updated_on'] = date('Y-m-d H:i:s');
                $ins_induction['sinduction_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins_induction['sinduction_status']     = 1;

                StaffInduction::create($ins_induction);
            }

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function add_staff_licence(Request $request)
    {
        if ($request->has('submit')) {
            $file_names = array();

            if (!empty($request->licence_copy)) {
                $file_names = $request->licence_copy;
            }

            if (!empty($request->validation_details['FILE'])) {
                foreach ($request->validation_details['FILE'] as $vkey => $validation_file) {
                    $file_path = $validation_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/staff';

                    $validation_file->storeAs($final_file_path, $file_name);

                    $file_names[$vkey] = $file_name;
                }
            }

            $staff_validation_details = array('TRAINING' => $request->validation_details['TRAINING'], 'LOCATION' => $request->validation_details['LOCATION'], 'ORGANISATION' => $request->validation_details['ORGANISATION'], 'TYPE' => $request->validation_details['TYPE'], 'VDATE' => $request->validation_details['VDATE'], 'EDATE' => $request->validation_details['EDATE'], 'PSTATUS' => $request->validation_details['PSTATUS'], 'FILE' => $file_names);

            StaffLicence::where('slicence_staff', $request->segment(3))->delete();

            foreach ($staff_validation_details['VDATE'] as $key => $staff_validation_detail) {
                if (isset($staff_validation_details['FILE'][$key])) {
                    $staff_file = $staff_validation_details['FILE'][$key];
                } else {
                    $staff_file = NULL;
                }

                $ins_validation['slicence_staff']         = $request->segment(3);
                $ins_validation['slicence_training']      = $staff_validation_details['TRAINING'][$key];
                $ins_validation['slicence_tlocation']     = $staff_validation_details['LOCATION'][$key];
                $ins_validation['slicence_torganisation'] = $staff_validation_details['ORGANISATION'][$key];
                $ins_validation['slicence_training_type'] = $staff_validation_details['TYPE'][$key];
                $ins_validation['slicence_date']          = date('Y-m-d', strtotime($staff_validation_details['VDATE'][$key]));
                $ins_validation['slicence_edate']         = date('Y-m-d', strtotime($staff_validation_details['EDATE'][$key]));
                $ins_validation['slicence_pstatus']       = $staff_validation_details['PSTATUS'][$key];
                $ins_validation['slicence_copy']          = $staff_file;
                $ins_validation['slicence_added_on']      = date('Y-m-d H:i:s');
                $ins_validation['slicence_added_by']      = Auth::guard('admin')->user()->admin_id;
                $ins_validation['slicence_updated_on']    = date('Y-m-d H:i:s');
                $ins_validation['slicence_updated_by']    = Auth::guard('admin')->user()->admin_id;
                $ins_validation['slicence_status']        = 1;

                StaffLicence::create($ins_validation);
            }

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function add_staff_identification(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'staff_id_country' => 'required',
                'staff_id_type' => 'required'
            ];

            $messages = [
                'staff_id_country.required' => 'Please Enter County of Issue',
                'staff_id_type.required' => 'Please Select Type'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['staff_id_country']        = $request->staff_id_country;
                $upd['staff_id_type']           = $request->staff_id_type;
                $upd['staff_id_classification'] = $request->staff_id_classification;
                $upd['staff_id_other']          = $request->staff_id_other;
                $upd['staff_id_oissue']         = $request->staff_id_oissue;
                $upd['staff_updated_on']        = date('Y-m-d H:i:s');
                $upd['staff_updated_by']        = Auth::guard('admin')->user()->admin_id;

                if (!empty($request->staff_id_expiry)) {
                    $upd['staff_id_expiry'] = date('Y-m-d', strtotime($request->staff_id_expiry));
                } else {
                    $upd['staff_id_oexpiry'] = NULL;
                }

                if (!empty($request->staff_id_oexpiry)) {
                    $upd['staff_id_oexpiry'] = date('Y-m-d', strtotime($request->staff_id_oexpiry));
                } else {
                    $upd['staff_id_oexpiry'] = NULL;
                }

                if ($request->hasFile('staff_id_copy')) {
                    $staff_id_copy = $request->staff_id_copy->store('assets/admin/uploads/staff');

                    $staff_id_copy = explode('/', $staff_id_copy);
                    $staff_id_copy = end($staff_id_copy);
                    $upd['staff_id_copy'] = $staff_id_copy;
                }

                $add = Staff::where('staff_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Details Updated Successfully');
            }
        }
    }

    public function add_staff_document(Request $request)
    {
        if ($request->has('submit')) {
            if (!empty($request->document['NAME'][1])) {
                $upd['staff_updated_on'] = date('Y-m-d H:i:s');
                $upd['staff_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $file_names = array();

                if (!empty($request->documents)) {
                    $file_names = $request->documents;
                }

                if (!empty($request->document['FILE'])) {
                    foreach ($request->document['FILE'] as $dkey => $document_file) {
                        $file_path = $document_file->getClientOriginalName();
                        $file_name = time() . '-' . $file_path;

                        $final_file_path = 'assets/admin/uploads/staff';

                        $document_file->storeAs($final_file_path, $file_name);

                        $file_names[$dkey] = $file_name;
                    }
                }

                $staff_documents = array('NAME' => $request->document['NAME'], 'FILE' => $file_names);

                $upd['staff_documents'] = json_encode($staff_documents);

                $add = Staff::where('staff_id', $request->segment(3))->update($upd);
            }

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function certificates()
    {
        if (!in_array('2', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['staffs'] = Staff::orderby('staff_fname')->get();

        $data['set'] = 'certificates';
        return view('admin.staff.certificates', $data);
    }

    public function get_certificates(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->staff_id)) {
                $where['staff_id'] = $request->staff_id;
            }

            $where['squalification_status'] = 1;
            $data = StaffQualification::getDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = '<a href="edit_staff/' . $row->staff_id . '">' . $row->staff_fname . ' ' . $row->staff_lname . '</a>';

                    return $staff_name;
                })
                ->addColumn('certificate_date', function ($row) {

                    $certificate_date = date('d M Y', strtotime($row->squalification_date));

                    return $certificate_date;
                })
                ->addColumn('expiry_date', function ($row) {

                    $expiry_date = date('d M Y', strtotime($row->squalification_edate));

                    return $expiry_date;
                })
                ->addColumn('pay_status', function ($row) {

                    if ($row->squalification_pstatus == 1) {
                        $pay_status = 'Self';
                    } elseif ($row->squalification_pstatus == 2) {
                        $pay_status = 'Company';
                    } elseif ($row->squalification_pstatus == 3) {
                        $pay_status = 'Others';
                    }

                    return $pay_status;
                })
                ->addColumn('certificate_copy', function ($row) {

                    $certificate_copy = '';

                    if (!empty($row->squalification_copy)) {
                        $copy_url = asset(config('constants.admin_path') . 'uploads/staff') . '/' . $row->squalification_copy;

                        $certificate_copy = '<a href="' . $copy_url . '" target="_blank">Click Here</a> to View Document';
                    }

                    return $certificate_copy;
                })
                ->rawColumns(['certificate_copy', 'staff_name'])
                ->make(true);
        }
    }

    public function certificates_download_excel(Request $request)
    {
        $filename = 'certificates_' . date('Y_m_d_H_i_s') . '.xlsx';

        return Excel::download(new CertificateExport($request->staff_id), $filename);
    }

    public function safety_inductions()
    {
        if (!in_array('2', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['staffs'] = Staff::orderby('staff_fname')->get();

        $data['set'] = 'safety_inductions';
        return view('admin.staff.safety_inductions', $data);
    }

    public function get_safety_inductions(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->staff_id)) {
                $where['staff_id'] = $request->staff_id;
            }

            $where['sinduction_status'] = 1;
            $data = StaffInduction::getDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = '<a href="edit_staff/' . $row->staff_id . '">' . $row->staff_fname . ' ' . $row->staff_lname . '</a>';

                    return $staff_name;
                })
                ->addColumn('type_name', function ($row) {

                    if ($row->sinduction_type == 1) {
                        $type_name = 'Online';
                    } elseif ($row->sinduction_type == 2) {
                        $type_name = 'Face to Face';
                    } elseif ($row->sinduction_type == 3) {
                        $type_name = 'Other';
                    }

                    return $type_name;
                })
                ->addColumn('induction_date', function ($row) {

                    $induction_date = date('d M Y', strtotime($row->sinduction_date));

                    return $induction_date;
                })
                ->addColumn('expiry_date', function ($row) {

                    $expiry_date = date('d M Y', strtotime($row->sinduction_edate));

                    return $expiry_date;
                })
                ->addColumn('pay_status', function ($row) {

                    if ($row->sinduction_pstatus == 1) {
                        $pay_status = 'Self';
                    } elseif ($row->sinduction_pstatus == 2) {
                        $pay_status = 'Company';
                    } elseif ($row->sinduction_pstatus == 3) {
                        $pay_status = 'Others';
                    }

                    return $pay_status;
                })
                ->addColumn('evidence_copy', function ($row) {

                    $evidence_copy = '';

                    if (!empty($row->sinduction_copy)) {
                        $copy_url = asset(config('constants.admin_path') . 'uploads/staff') . '/' . $row->sinduction_copy;

                        $evidence_copy = '<a href="' . $copy_url . '" target="_blank">Click Here</a> to View Document';
                    }

                    return $evidence_copy;
                })
                ->rawColumns(['evidence_copy', 'staff_name'])
                ->make(true);
        }
    }

    public function safety_inductions_download_excel(Request $request)
    {
        $filename = 'safety_inductions_' . date('Y_m_d_H_i_s') . '.xlsx';

        return Excel::download(new InductionExport($request->staff_id), $filename);
    }

    public function safety_licences()
    {
        if (!in_array('2', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['staffs'] = Staff::orderby('staff_fname')->get();

        $data['set'] = 'safety_licences';
        return view('admin.staff.safety_licences', $data);
    }

    public function get_safety_licences(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->staff_id)) {
                $where['staff_id'] = $request->staff_id;
            }

            $where['slicence_status'] = 1;
            $data = StaffLicence::getDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = '<a href="edit_staff/' . $row->staff_id . '">' . $row->staff_fname . ' ' . $row->staff_lname . '</a>';

                    return $staff_name;
                })
                ->addColumn('type_name', function ($row) {

                    if ($row->slicence_training_type == 1) {
                        $type_name = 'Online';
                    } elseif ($row->slicence_training_type == 2) {
                        $type_name = 'Face to Face';
                    } elseif ($row->slicence_training_type == 3) {
                        $type_name = 'Other';
                    }

                    return $type_name;
                })
                ->addColumn('validation_date', function ($row) {

                    $validation_date = date('d M Y', strtotime($row->slicence_date));

                    return $validation_date;
                })
                ->addColumn('expiry_date', function ($row) {

                    $expiry_date = date('d M Y', strtotime($row->slicence_edate));

                    return $expiry_date;
                })
                ->addColumn('pay_status', function ($row) {

                    if ($row->slicence_pstatus == 1) {
                        $pay_status = 'Self';
                    } elseif ($row->slicence_pstatus == 2) {
                        $pay_status = 'Company';
                    } elseif ($row->slicence_pstatus == 3) {
                        $pay_status = 'Others';
                    }

                    return $pay_status;
                })
                ->addColumn('licence_copy', function ($row) {

                    $licence_copy = '';

                    if (!empty($row->slicence_copy)) {
                        $copy_url = asset(config('constants.admin_path') . 'uploads/staff') . '/' . $row->slicence_copy;

                        $licence_copy = '<a href="' . $copy_url . '" target="_blank">Click Here</a> to View Document';
                    }

                    return $licence_copy;
                })
                ->rawColumns(['licence_copy', 'staff_name'])
                ->make(true);
        }
    }

    public function safety_licences_download_excel(Request $request)
    {
        $filename = 'safety_licences_' . date('Y_m_d_H_i_s') . '.xlsx';

        return Excel::download(new LicenceExport($request->staff_id), $filename);
    }

    public function staff_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['staff_status'] = 0;
        } else {
            $upd['staff_status'] = 1;
        }

        $where['staff_id'] = $id;

        $update = Staff::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
