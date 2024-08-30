<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vehicle;
use App\Models\Inspection;

class StaffInspectionController extends Controller
{
    public function index(Request $request)
    {
        $data['vehicle'] = Vehicle::where('vehicle_id', $request->segment(3))->first();

        if (!isset($data['vehicle'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.inspections', $data);
    }

    public function get_inspections(Request $request)
    {
        if ($request->ajax()) {
            $where['inspection_vehicle'] = $request->vehicle_id;
            $data = Inspection::where($where)->orderby('inspection_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('inspection_date', function ($row) {

                    $inspection_date = date('d M Y', strtotime($row->inspection_date));

                    return $inspection_date;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/staff/edit_inspection/' . $row->inspection_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_inspection(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'inspection_date' => 'required',
                'inspection_odometer' => 'required',
                'inspection_inspected' => 'required'
            ];

            $messages = [
                'inspection_date.required' => 'Please Select Date',
                'inspection_odometer.required' => 'Please Enter Odometer Reading',
                'inspection_inspected.required' => 'Please Enter Inspected By'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['inspection_vehicle']     = $request->segment(3);
                $ins['inspection_date']        = date('Y-m-d', strtotime($request->inspection_date));
                $ins['inspection_odometer']    = $request->inspection_odometer;
                $ins['inspection_inspected']   = $request->inspection_inspected;
                $ins['inspection_frequency']   = $request->inspection_frequency;
                $ins['inspection_ninspection'] = $request->inspection_ninspection;
                $ins['inspection_notes']       = $request->inspection_notes;
                $ins['inspection_added_on']    = date('Y-m-d H:i:s');
                $ins['inspection_added_by']    = Auth::guard('staff')->user()->staff_id;
                $ins['inspection_updated_on']  = date('Y-m-d H:i:s');
                $ins['inspection_updated_by']  = Auth::guard('staff')->user()->staff_id;
                $ins['inspection_status']      = 1;

                $add = Inspection::create($ins);

                if ($add) {
                    return redirect('staff/inspections/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.add_inspection', $data);
    }

    public function edit_inspection(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'inspection_date' => 'required',
                'inspection_odometer' => 'required',
                'inspection_inspected' => 'required'
            ];

            $messages = [
                'inspection_date.required' => 'Please Select Date',
                'inspection_odometer.required' => 'Please Enter Odometer Reading',
                'inspection_inspected.required' => 'Please Enter Inspected By'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['inspection_date']        = date('Y-m-d', strtotime($request->inspection_date));
                $upd['inspection_odometer']    = $request->inspection_odometer;
                $upd['inspection_inspected']   = $request->inspection_inspected;
                $upd['inspection_frequency']   = $request->inspection_frequency;
                $upd['inspection_ninspection'] = $request->inspection_ninspection;
                $upd['inspection_notes']       = $request->inspection_notes;
                $upd['inspection_updated_on']  = date('Y-m-d H:i:s');
                $upd['inspection_updated_by']  = Auth::guard('staff')->user()->staff_id;

                $add = Inspection::where('inspection_id', $request->segment(3))->update($upd);

                return redirect('staff/inspections/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['inspection'] = Inspection::where('inspection_id', $request->segment(3))->first();

        if (!isset($data['inspection'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.edit_inspection', $data);
    }

    public function add_exterior_inspection(Request $request)
    {
        if ($request->has('submit')) {
            $upd['inspection_edents']           = $request->inspection_edents;
            $upd['inspection_epaints']          = $request->inspection_epaints;
            $upd['inspection_ehead_light']      = $request->inspection_ehead_light;
            $upd['inspection_elight_lense']     = $request->inspection_elight_lense;
            $upd['inspection_etire_depth']      = $request->inspection_etire_depth;
            $upd['inspection_etire_pressure']   = $request->inspection_etire_pressure;
            $upd['inspection_etire_damage']     = $request->inspection_etire_damage;
            $upd['inspection_ewindow_crack']    = $request->inspection_ewindow_crack;
            $upd['inspection_ewindow_power']    = $request->inspection_ewindow_power;
            $upd['inspection_ewiper_condition'] = $request->inspection_ewiper_condition;
            $upd['inspection_ewiper_fluid']     = $request->inspection_ewiper_fluid;
            $upd['inspection_updated_on']       = date('Y-m-d H:i:s');
            $upd['inspection_updated_by']       = Auth::guard('staff')->user()->staff_id;

            $add = Inspection::where('inspection_id', $request->segment(3))->update($upd);

            return redirect('staff/inspections/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
        }

        $data['inspection'] = Inspection::where('inspection_id', $request->segment(3))->first();

        if (!isset($data['inspection'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.edit_inspection', $data);
    }

    public function add_interior_inspection(Request $request)
    {
        if ($request->has('submit')) {
            $upd['inspection_iseat_tear']        = $request->inspection_iseat_tear;
            $upd['inspection_iseat_belts']       = $request->inspection_iseat_belts;
            $upd['inspection_idashboard_light']  = $request->inspection_idashboard_light;
            $upd['inspection_idashboard_ac']     = $request->inspection_idashboard_ac;
            $upd['inspection_imirror_condition'] = $request->inspection_imirror_condition;
            $upd['inspection_ipedal_wear']       = $request->inspection_ipedal_wear;
            $upd['inspection_ifloor_position']   = $request->inspection_ifloor_position;
            $upd['inspection_updated_on']        = date('Y-m-d H:i:s');
            $upd['inspection_updated_by']        = Auth::guard('staff')->user()->staff_id;

            $add = Inspection::where('inspection_id', $request->segment(3))->update($upd);

            return redirect('staff/inspections/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
        }

        $data['inspection'] = Inspection::where('inspection_id', $request->segment(3))->first();

        if (!isset($data['inspection'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.edit_inspection', $data);
    }

    public function add_hood_inspection(Request $request)
    {
        if ($request->has('submit')) {
            $upd['inspection_hengine_oil']       = $request->inspection_hengine_oil;
            $upd['inspection_hengine_leak']      = $request->inspection_hengine_leak;
            $upd['inspection_hcoolant_level']    = $request->inspection_hcoolant_level;
            $upd['inspection_hcoolant_leak']     = $request->inspection_hcoolant_leak;
            $upd['inspection_hbrake_level']      = $request->inspection_hbrake_level;
            $upd['inspection_hbrake_leak']       = $request->inspection_hbrake_leak;
            $upd['inspection_htrans_level']      = $request->inspection_htrans_level;
            $upd['inspection_hpower_level']      = $request->inspection_hpower_level;
            $upd['inspection_hbelt_crack']       = $request->inspection_hbelt_crack;
            $upd['inspection_hbelt_hose']        = $request->inspection_hbelt_hose;
            $upd['inspection_hbattery_terminal'] = $request->inspection_hbattery_terminal;
            $upd['inspection_hbattery_level']    = $request->inspection_hbattery_level;
            $upd['inspection_updated_on']        = date('Y-m-d H:i:s');
            $upd['inspection_updated_by']        = Auth::guard('staff')->user()->staff_id;

            $add = Inspection::where('inspection_id', $request->segment(3))->update($upd);

            return redirect('staff/inspections/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
        }

        $data['inspection'] = Inspection::where('inspection_id', $request->segment(3))->first();

        if (!isset($data['inspection'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.edit_inspection', $data);
    }

    public function add_uvehicle_inspection(Request $request)
    {
        if ($request->has('submit')) {
            $upd['inspection_vexhaust_rust']    = $request->inspection_vexhaust_rust;
            $upd['inspection_vexhaust_hanger']  = $request->inspection_vexhaust_hanger;
            $upd['inspection_vsuspension_wear'] = $request->inspection_vsuspension_wear;
            $upd['inspection_vsuspension_play'] = $request->inspection_vsuspension_play;
            $upd['inspection_vbrake_pads']      = $request->inspection_vbrake_pads;
            $upd['inspection_vbrake_leak']      = $request->inspection_vbrake_leak;
            $upd['inspection_vfluid_leak']      = $request->inspection_vfluid_leak;
            $upd['inspection_updated_on']       = date('Y-m-d H:i:s');
            $upd['inspection_updated_by']       = Auth::guard('staff')->user()->staff_id;

            $add = Inspection::where('inspection_id', $request->segment(3))->update($upd);

            return redirect('staff/inspections/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
        }

        $data['inspection'] = Inspection::where('inspection_id', $request->segment(3))->first();

        if (!isset($data['inspection'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.edit_inspection', $data);
    }

    public function add_test_inspection(Request $request)
    {
        if ($request->has('submit')) {
            $upd['inspection_tengine_start']     = $request->inspection_tengine_start;
            $upd['inspection_tengine_sound']     = $request->inspection_tengine_sound;
            $upd['inspection_tbrake_function']   = $request->inspection_tbrake_function;
            $upd['inspection_tbrake_parking']    = $request->inspection_tbrake_parking;
            $upd['inspection_tsteer_operation']  = $request->inspection_tsteer_operation;
            $upd['inspection_tsteer_play']       = $request->inspection_tsteer_play;
            $upd['inspection_ttrans_gear']       = $request->inspection_ttrans_gear;
            $upd['inspection_ttrans_sound']      = $request->inspection_ttrans_sound;
            $upd['inspection_twinter_level']     = $request->inspection_twinter_level;
            $upd['inspection_twinter_heater']    = $request->inspection_twinter_heater;
            $upd['inspection_tsummer_air']       = $request->inspection_tsummer_air;
            $upd['inspection_tsummer_level']     = $request->inspection_tsummer_level;
            $upd['inspection_tsummer_condition'] = $request->inspection_tsummer_condition;
            $upd['inspection_updated_on']        = date('Y-m-d H:i:s');
            $upd['inspection_updated_by']        = Auth::guard('staff')->user()->staff_id;

            $add = Inspection::where('inspection_id', $request->segment(3))->update($upd);

            return redirect('staff/inspections/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
        }

        $data['inspection'] = Inspection::where('inspection_id', $request->segment(3))->first();

        if (!isset($data['inspection'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.inspection.edit_inspection', $data);
    }

    public function inspection_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['inspection_status'] = 0;
        } else {
            $upd['inspection_status'] = 1;
        }

        $where['inspection_id'] = $id;

        $update = Inspection::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
