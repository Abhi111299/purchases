<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\TripLog;
use App\Models\Location;
use App\Models\State;
use App\Models\Staff;
use App\Models\Manufacturer;
use App\Models\Models;
use App\Models\Vehicle;

class AdminVehicleController extends Controller
{
    public function index()
    {
        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'vehicles';
        return view('admin.vehicle.vehicles', $data);
    }

    public function get_vehicles(Request $request)
    {
        if ($request->ajax()) {
            $data = Vehicle::getDetails();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = $row->staff_fname . ' ' . $row->staff_mname . ' ' . $row->staff_lname;

                    return $staff_name;
                })
                ->addColumn('start_odometer', function ($row) {

                    $where_trip['trip_log_vehicle'] = $row->vehicle_id;
                    $where_trip['trip_log_status'] = 1;
                    $trip_log = TripLog::where($where_trip)->orderby('trip_log_id', 'asc')->first();

                    if (isset($trip_log->trip_log_sodometer)) {
                        $start_odometer = $trip_log->trip_log_sodometer;
                    } else {
                        $start_odometer = 0;
                    }

                    return $start_odometer;
                })
                ->addColumn('last_odometer', function ($row) {

                    $where_trip['trip_log_vehicle'] = $row->vehicle_id;
                    $where_trip['trip_log_status'] = 1;
                    $trip_log = TripLog::where($where_trip)->orderby('trip_log_id', 'desc')->first();

                    if (isset($trip_log->trip_log_eodometer)) {
                        $last_odometer = $trip_log->trip_log_eodometer;
                    } else {
                        $last_odometer = 0;
                    }

                    return $last_odometer;
                })
                ->addColumn('total_km', function ($row) {

                    $where_trip['trip_log_vehicle'] = $row->vehicle_id;
                    $where_trip['trip_log_status'] = 1;

                    $start_log = TripLog::where($where_trip)->orderby('trip_log_id', 'asc')->first();

                    if (isset($start_log->trip_log_sodometer)) {
                        $start_odometer = $start_log->trip_log_sodometer;
                    } else {
                        $start_odometer = 0;
                    }

                    $last_log = TripLog::where($where_trip)->orderby('trip_log_id', 'desc')->first();

                    if (isset($last_log->trip_log_eodometer)) {
                        $last_odometer = $last_log->trip_log_eodometer;
                    } else {
                        $last_odometer = 0;
                    }

                    if ($last_odometer == 0) {
                        $total_km = 0;
                    } else {
                        $total_km = $last_odometer - $start_odometer;
                    }

                    return $total_km;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/trip_logs/' . $row->vehicle_id . '" class="btn btn-success btn-sm rounded-circle" title="Logs"><i class="fa fa-database"></i></a> ';

                    $btn .= '<a href="/admin/edit_vehicle/' . $row->vehicle_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->vehicle_status == 1) {
                        $btn .= '<a href="/admin/vehicle_status/' . $row->vehicle_id . '/' . $row->vehicle_status . '" class="btn btn-danger btn-sm rounded-circle" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/vehicle_status/' . $row->vehicle_id . '/' . $row->vehicle_status . '" class="btn btn-success btn-sm rounded-circle" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_vehicle(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'vehicle_manufacturer' => 'required',
                'vehicle_model' => 'required',
                'vehicle_year' => 'required',
                'vehicle_license_no' => 'required',
                'vehicle_no' => 'required'
            ];

            $messages = [
                'vehicle_manufacturer.required' => 'Please Select Manufacturer',
                'vehicle_model.required' => 'Please Select Model',
                'vehicle_year.required' => 'Please Select Year',
                'vehicle_license_no.required' => 'Please Enter License Plate No',
                'vehicle_no.required' => 'Please Enter Vehicle Identification No'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['vehicle_manufacturer'] = $request->vehicle_manufacturer;
                $ins['vehicle_model']        = $request->vehicle_model;
                $ins['vehicle_year']         = $request->vehicle_year;
                $ins['vehicle_license_no']   = $request->vehicle_license_no;
                $ins['vehicle_no']           = $request->vehicle_no;
                $ins['vehicle_added_on']     = date('Y-m-d H:i:s');
                $ins['vehicle_added_by']     = Auth::guard('admin')->user()->admin_id;
                $ins['vehicle_updated_on']   = date('Y-m-d H:i:s');
                $ins['vehicle_updated_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['vehicle_status']       = 1;

                $add = Vehicle::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Vehicle Added Successfully');
                }
            }
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['manufacturers'] = Manufacturer::where('manufacturer_status', 1)->orderby('manufacturer_name', 'asc')->get();

        $data['set'] = 'add_vehicle';
        return view('admin.vehicle.add_vehicle', $data);
    }

    public function select_model(Request $request)
    {
        $where['model_manufacturer'] = $request->manufacturer_id;
        $where['model_status'] = 1;
        $data['models'] = Models::where($where)->orderby('model_name', 'asc')->get();

        return view('admin.vehicle.select_model', $data);
    }

    public function edit_vehicle(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'vehicle_manufacturer' => 'required',
                'vehicle_model' => 'required',
                'vehicle_year' => 'required',
                'vehicle_license_no' => 'required',
                'vehicle_no' => 'required'
            ];

            $messages = [
                'vehicle_manufacturer.required' => 'Please Select Manufacturer',
                'vehicle_model.required' => 'Please Select Model',
                'vehicle_year.required' => 'Please Select Year',
                'vehicle_license_no.required' => 'Please Enter License Plate No',
                'vehicle_no.required' => 'Please Enter Vehicle Identification No'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['vehicle_manufacturer'] = $request->vehicle_manufacturer;
                $upd['vehicle_model']        = $request->vehicle_model;
                $upd['vehicle_year']         = $request->vehicle_year;
                $upd['vehicle_license_no']   = $request->vehicle_license_no;
                $upd['vehicle_no']           = $request->vehicle_no;
                $upd['vehicle_updated_on']   = date('Y-m-d H:i:s');
                $upd['vehicle_updated_by']   = Auth::guard('admin')->user()->admin_id;

                $add = Vehicle::where('vehicle_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Vehicle Updated Successfully');
            }
        }

        $data['vehicle'] = Vehicle::where('vehicle_id', $request->segment(3))->first();

        if (!isset($data['vehicle'])) {
            return redirect('admin/vehicles');
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['manufacturers'] = Manufacturer::where('manufacturer_status', 1)->orderby('manufacturer_name', 'asc')->get();

        $where_model['model_manufacturer'] = $data['vehicle']->vehicle_manufacturer;
        $where_model['model_status'] = 1;
        $data['models'] = Models::where($where_model)->orderby('model_name', 'asc')->get();

        $data['locations'] = Location::where('location_status', 1)->orderby('location_name', 'asc')->get();
        $data['states'] = State::where('state_status', 1)->orderby('state_name', 'asc')->get();

        //$where_staff['staff_role'] = 7;
        $where_staff['staff_status'] = 1;
        $data['staffs'] = Staff::where($where_staff)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'edit_vehicle';
        return view('admin.vehicle.edit_vehicle', $data);
    }

    public function add_vehicle_ownership(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'vehicle_owner' => 'required',
                'vehicle_address' => 'required',
                'vehicle_reg_date' => 'required',
                'vehicle_exp_date' => 'required',
                'vehicle_authority' => 'required',
                'vehicle_state' => 'required',
                'vehicle_location' => 'required',
                'vehicle_driver' => 'required'
            ];

            $messages = [
                'vehicle_owner.required' => 'Please Enter Owner Name',
                'vehicle_address.required' => 'Please Enter Address',
                'vehicle_reg_date.required' => 'Please Select Date of Registration',
                'vehicle_exp_date.required' => 'Please Select Expiry Date',
                'vehicle_authority.required' => 'Please Enter Issuing Authority',
                'vehicle_state.required' => 'Please Select State',
                'vehicle_location.required' => 'Please Select Car Location',
                'vehicle_driver.required' => 'Please Select Assigned Driver'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['vehicle_owner']      = $request->vehicle_owner;
                $upd['vehicle_address']    = $request->vehicle_address;
                $upd['vehicle_reg_date']   = date('Y-m-d', strtotime($request->vehicle_reg_date));
                $upd['vehicle_exp_date']   = date('Y-m-d', strtotime($request->vehicle_exp_date));
                $upd['vehicle_authority']  = $request->vehicle_authority;
                $upd['vehicle_state']      = $request->vehicle_state;
                $upd['vehicle_location']   = $request->vehicle_location;
                $upd['vehicle_driver']     = $request->vehicle_driver;
                $upd['vehicle_updated_on'] = date('Y-m-d H:i:s');
                $upd['vehicle_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Vehicle::where('vehicle_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Details Updated Successfully');
            }
        }
    }

    public function add_vehicle_specification(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'vehicle_engine_type' => 'required',
                'vehicle_transmission' => 'required',
                'vehicle_fuel_type' => 'required',
                'vehicle_body_type' => 'required',
                'vehicle_color' => 'required',
                'vehicle_odometer_reading' => 'required'
            ];

            $messages = [
                'vehicle_engine_type.required' => 'Please Enter Engine Type',
                'vehicle_transmission.required' => 'Please Select Transmission',
                'vehicle_fuel_type.required' => 'Please Select Fuel Type',
                'vehicle_body_type.required' => 'Please Select Body Type',
                'vehicle_color.required' => 'Please Enter Color',
                'vehicle_odometer_reading.required' => 'Please Enter Odometer Reading'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['vehicle_engine_type']      = $request->vehicle_engine_type;
                $upd['vehicle_transmission']     = $request->vehicle_transmission;
                $upd['vehicle_fuel_type']        = $request->vehicle_fuel_type;
                $upd['vehicle_body_type']        = $request->vehicle_body_type;
                $upd['vehicle_color']            = $request->vehicle_color;
                $upd['vehicle_odometer_reading'] = $request->vehicle_odometer_reading;
                $upd['vehicle_features']         = $request->vehicle_features;
                $upd['vehicle_average_milegae']  = $request->vehicle_average_milegae;
                $upd['vehicle_updated_on']       = date('Y-m-d H:i:s');
                $upd['vehicle_updated_by']       = Auth::guard('admin')->user()->admin_id;

                $add = Vehicle::where('vehicle_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Details Updated Successfully');
            }
        }
    }

    public function add_vehicle_financial(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['vehicle_type' => 'required'];

            $messages = ['vehicle_type.required' => 'Please Select Type'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['vehicle_type']           = $request->vehicle_type;
                $upd['vehicle_loan_amount']    = $request->vehicle_loan_amount;
                $upd['vehicle_purchase_price'] = $request->vehicle_purchase_price;
                $upd['vehicle_depreciation']   = $request->vehicle_depreciation;
                $upd['vehicle_updated_on']     = date('Y-m-d H:i:s');
                $upd['vehicle_updated_by']     = Auth::guard('admin')->user()->admin_id;

                $add = Vehicle::where('vehicle_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Details Updated Successfully');
            }
        }
    }

    public function add_vehicle_document(Request $request)
    {
        if ($request->has('submit')) {
            if (!empty($request->document['NAME'][1])) {
                $upd['vehicle_updated_on'] = date('Y-m-d H:i:s');
                $upd['vehicle_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $file_names = array();

                if (!empty($request->documents)) {
                    $file_names = $request->documents;
                }

                if (!empty($request->document['FILE'])) {
                    foreach ($request->document['FILE'] as $dkey => $document_file) {
                        $file_path = $document_file->getClientOriginalName();
                        $file_name = time() . '-' . $file_path;

                        $final_file_path = 'assets/admin/uploads/vehicle';

                        $document_file->storeAs($final_file_path, $file_name);

                        $file_names[$dkey] = $file_name;
                    }
                }

                $vehicle_documents = array('NAME' => $request->document['NAME'], 'FILE' => $file_names);

                $upd['vehicle_documents'] = json_encode($vehicle_documents);

                $add = Vehicle::where('vehicle_id', $request->segment(3))->update($upd);
            }

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function vehicle_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['vehicle_status'] = 0;
        } else {
            $upd['vehicle_status'] = 1;
        }

        $where['vehicle_id'] = $id;

        $update = Vehicle::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
