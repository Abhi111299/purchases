<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Inspection;
   
class StaffInspectionController extends BaseController
{
    public function index(Request $request)
    {
        $where['inspection_vehicle'] = $request->segment(3);
        $inspections = Inspection::where($where)->orderby('inspection_id','desc')->get();

        if($inspections->count() > 0)
        {
            foreach($inspections as $inspection)
            {
                $inspection_date = date('d M Y',strtotime($inspection->inspection_date));

                $result[] = array('id'=>$inspection->inspection_id,'date'=>$inspection_date,'odometer_reading'=>$inspection->inspection_odometer,'inspected_by'=>$inspection->inspection_inspected,'inspection_frequency'=>$inspection->inspection_frequency,'next_inspection'=>$inspection->inspection_ninspection);
            }

            return $this->sendResponse($result, 'Inspection List');
        }
        else
        {
            return $this->sendError('Inspections Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_inspection(Request $request)
    {
        $rules = ['date' => 'required',
                  'odometer_reading' => 'required',  
                  'inspected_by' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'inspected_by.required' => 'Please Enter Inspected By'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['inspection_vehicle']     = $request->segment(3);
            $ins['inspection_date']        = date('Y-m-d',strtotime($request->date));
            $ins['inspection_odometer']    = $request->odometer_reading;
            $ins['inspection_inspected']   = $request->inspected_by;
            $ins['inspection_frequency']   = $request->inspection_frequency;
            $ins['inspection_ninspection'] = $request->next_inspection;
            $ins['inspection_notes']       = $request->notes;
            $ins['inspection_added_on']    = date('Y-m-d H:i:s');
            $ins['inspection_added_by']    = $request->user()->staff_id;
            $ins['inspection_updated_on']  = date('Y-m-d H:i:s');
            $ins['inspection_updated_by']  = $request->user()->staff_id;
            $ins['inspection_status']      = 1;
            
            $add = Inspection::create($ins);

            if($add)
            {
                $result = array('inspection_id' => $add->inspection_id);

                return $this->sendResponse($result, 'Inspection Added Successfully');
            }
            else
            {
                return $this->sendError('Inspection Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function inspection_detail(Request $request)
    {
        $inspection = Inspection::where('inspection_id',$request->segment(3))->first();

        if(isset($inspection))
        {
            $result = array('id'=>$inspection->inspection_id,'date'=>date('d-m-Y',strtotime($inspection->inspection_date)),'odometer_reading'=>$inspection->inspection_odometer,'inspected_by'=>$inspection->inspection_inspected,'inspection_frequency'=>$inspection->inspection_frequency,'next_inspection'=>$inspection->inspection_ninspection,'notes'=>$inspection->inspection_notes);

            return $this->sendResponse($result, 'Inspection Details');
        }
        else
        {
            return $this->sendError('Inspection Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_inspection(Request $request)
    {
        $rules = ['date' => 'required',
                  'odometer_reading' => 'required',  
                  'inspected_by' => 'required'
                 ];
        
        $messages = ['date.required' => 'Please Select Date',
                     'odometer_reading.required' => 'Please Enter Odometer Reading',
                     'inspected_by.required' => 'Please Enter Inspected By'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['inspection_date']        = date('Y-m-d',strtotime($request->date));
            $upd['inspection_odometer']    = $request->odometer_reading;
            $upd['inspection_inspected']   = $request->inspected_by;
            $upd['inspection_frequency']   = $request->inspection_frequency;
            $upd['inspection_ninspection'] = $request->next_inspection;
            $upd['inspection_notes']       = $request->notes;
            $upd['inspection_updated_on']  = date('Y-m-d H:i:s');
            $upd['inspection_updated_by']  = $request->user()->staff_id;

            Inspection::where('inspection_id',$request->segment(3))->update($upd);

            $result = array('inspection_id' => $request->segment(3));

            return $this->sendResponse($result, 'Inspection Updated Successfully');
        }
    }

    public function exterior_inspection_detail(Request $request)
    {
        $inspection = Inspection::where('inspection_id',$request->segment(3))->first();

        if(isset($inspection))
        {
            $status = array(1=>'Satisfactory',2=>'Unsatisfactory',3=>'N/A');

            if(isset($status[$inspection->inspection_edents])){ $check_dents = $status[$inspection->inspection_edents]; }else{ $check_dents = NULL; }

            if(isset($status[$inspection->inspection_epaints])){ $paint_condition = $status[$inspection->inspection_epaints]; }else{ $paint_condition = NULL; }

            if(isset($status[$inspection->inspection_ehead_light])){ $test_lights = $status[$inspection->inspection_ehead_light]; }else{ $test_lights = NULL; }

            if(isset($status[$inspection->inspection_elight_lense])){ $light_condition = $status[$inspection->inspection_elight_lense]; }else{ $light_condition = NULL; }

            if(isset($status[$inspection->inspection_etire_depth])){ $tire_depth = $status[$inspection->inspection_etire_depth]; }else{ $tire_depth = NULL; }

            if(isset($status[$inspection->inspection_etire_pressure])){ $tire_pressure = $status[$inspection->inspection_etire_pressure]; }else{ $tire_pressure = NULL; }

            if(isset($status[$inspection->inspection_etire_damage])){ $tire_damage = $status[$inspection->inspection_etire_damage]; }else{ $tire_damage = NULL; }

            if(isset($status[$inspection->inspection_ewindow_crack])){ $inspect_cracks = $status[$inspection->inspection_ewindow_crack]; }else{ $inspect_cracks = NULL; }

            if(isset($status[$inspection->inspection_ewindow_power])){ $test_windows = $status[$inspection->inspection_ewindow_power]; }else{ $test_windows = NULL; }

            if(isset($status[$inspection->inspection_ewiper_condition])){ $condition_wiper = $status[$inspection->inspection_ewiper_condition]; }else{ $condition_wiper = NULL; }

            if(isset($status[$inspection->inspection_ewiper_fluid])){ $ensure_resorvoir = $status[$inspection->inspection_ewiper_fluid]; }else{ $ensure_resorvoir = NULL; }

            $result = array('id'=>$inspection->inspection_id,'check_dents_id'=>$inspection->inspection_edents,'check_dents'=>$check_dents,'paint_condition_id'=>$inspection->inspection_epaints,'paint_condition'=>$paint_condition,'test_lights_id'=>$inspection->inspection_ehead_light,'test_lights'=>$test_lights,'light_condition_id'=>$inspection->inspection_elight_lense,'light_condition'=>$light_condition,'tire_depth_id'=>$inspection->inspection_etire_depth,'tire_depth'=>$tire_depth,'tire_pressure_id'=>$inspection->inspection_etire_pressure,'tire_pressure'=>$tire_pressure,'tire_damage_id'=>$inspection->inspection_etire_damage,'tire_damage'=>$tire_damage,'inspect_cracks_id'=>$inspection->inspection_ewindow_crack,'inspect_cracks'=>$inspect_cracks,'test_windows_id'=>$inspection->inspection_ewindow_power,'test_windows'=>$test_windows,'condition_wiper_id'=>$inspection->inspection_ewiper_condition,'condition_wiper'=>$condition_wiper,'ensure_resorvoir_id'=>$inspection->inspection_ewiper_fluid,'ensure_resorvoir'=>$ensure_resorvoir);

            return $this->sendResponse($result, 'Exterior Inspection Details');
        }
        else
        {
            return $this->sendError('Exterior Inspection Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_exterior_inspection(Request $request)
    {
        $upd['inspection_edents']           = $request->check_dents;
        $upd['inspection_epaints']          = $request->paint_condition;
        $upd['inspection_ehead_light']      = $request->test_lights;
        $upd['inspection_elight_lense']     = $request->light_condition;
        $upd['inspection_etire_depth']      = $request->tire_depth;
        $upd['inspection_etire_pressure']   = $request->tire_pressure;
        $upd['inspection_etire_damage']     = $request->tire_damage;
        $upd['inspection_ewindow_crack']    = $request->inspect_cracks;
        $upd['inspection_ewindow_power']    = $request->test_windows;
        $upd['inspection_ewiper_condition'] = $request->condition_wiper;
        $upd['inspection_ewiper_fluid']     = $request->ensure_resorvoir;
        $upd['inspection_updated_on']       = date('Y-m-d H:i:s');
        $upd['inspection_updated_by']       = $request->user()->staff_id;

        Inspection::where('inspection_id',$request->segment(3))->update($upd);

        $result = array('inspection_id' => $request->segment(3));

        return $this->sendResponse($result, 'Exterior Inspection Updated Successfully');
    }

    public function interior_inspection_detail(Request $request)
    {
        $inspection = Inspection::where('inspection_id',$request->segment(3))->first();

        if(isset($inspection))
        {
            $status = array(1=>'Satisfactory',2=>'Unsatisfactory',3=>'N/A');

            if(isset($status[$inspection->inspection_iseat_tear])){ $inspect_tears = $status[$inspection->inspection_iseat_tear]; }else{ $inspect_tears = NULL; }

            if(isset($status[$inspection->inspection_iseat_belts])){ $test_seat = $status[$inspection->inspection_iseat_belts]; }else{ $test_seat = NULL; }

            if(isset($status[$inspection->inspection_idashboard_light])){ $ensure_dashboard = $status[$inspection->inspection_idashboard_light]; }else{ $ensure_dashboard = NULL; }

            if(isset($status[$inspection->inspection_idashboard_ac])){ $test_control = $status[$inspection->inspection_idashboard_ac]; }else{ $test_control = NULL; }

            if(isset($status[$inspection->inspection_imirror_condition])){ $condition_mirror = $status[$inspection->inspection_imirror_condition]; }else{ $condition_mirror = NULL; }

            if(isset($status[$inspection->inspection_ipedal_wear])){ $inspect_wear = $status[$inspection->inspection_ipedal_wear]; }else{ $inspect_wear = NULL; }

            if(isset($status[$inspection->inspection_ifloor_position])){ $proper_position = $status[$inspection->inspection_ifloor_position]; }else{ $proper_position = NULL; }

            $result = array('id'=>$inspection->inspection_id,'inspect_tears_id'=>$inspection->inspection_iseat_tear,'inspect_tears'=>$inspect_tears,'test_seat_id'=>$inspection->inspection_iseat_belts,'test_seat'=>$test_seat,'ensure_dashboard_id'=>$inspection->inspection_idashboard_light,'ensure_dashboard'=>$ensure_dashboard,'test_control_id'=>$inspection->inspection_idashboard_ac,'test_control'=>$test_control,'condition_mirror_id'=>$inspection->inspection_imirror_condition,'condition_mirror'=>$condition_mirror,'inspect_wear_id'=>$inspection->inspection_ipedal_wear,'inspect_wear'=>$inspect_wear,'proper_position_id'=>$inspection->inspection_ifloor_position,'proper_position'=>$proper_position);

            return $this->sendResponse($result, 'Interior Inspection Details');
        }
        else
        {
            return $this->sendError('Interior Inspection Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_interior_inspection(Request $request)
    {
        $upd['inspection_iseat_tear']        = $request->inspect_tears;
        $upd['inspection_iseat_belts']       = $request->test_seat;
        $upd['inspection_idashboard_light']  = $request->ensure_dashboard;
        $upd['inspection_idashboard_ac']     = $request->test_control;
        $upd['inspection_imirror_condition'] = $request->condition_mirror;
        $upd['inspection_ipedal_wear']       = $request->inspect_wear;
        $upd['inspection_ifloor_position']   = $request->proper_position;
        $upd['inspection_updated_on']        = date('Y-m-d H:i:s');
        $upd['inspection_updated_by']        = $request->user()->staff_id;

        Inspection::where('inspection_id',$request->segment(3))->update($upd);

        $result = array('inspection_id' => $request->segment(3));

        return $this->sendResponse($result, 'Interior Inspection Updated Successfully');
    }

    public function under_hood_detail(Request $request)
    {
        $inspection = Inspection::where('inspection_id',$request->segment(3))->first();

        if(isset($inspection))
        {
            $status = array(1=>'Satisfactory',2=>'Unsatisfactory',3=>'N/A');

            if(isset($status[$inspection->inspection_hengine_oil])){ $oil_level = $status[$inspection->inspection_hengine_oil]; }else{ $oil_level = NULL; }

            if(isset($status[$inspection->inspection_hengine_leak])){ $oil_leak = $status[$inspection->inspection_hengine_leak]; }else{ $oil_leak = NULL; }

            if(isset($status[$inspection->inspection_hcoolant_level])){ $coolant_level = $status[$inspection->inspection_hcoolant_level]; }else{ $coolant_level = NULL; }

            if(isset($status[$inspection->inspection_hcoolant_leak])){ $radiator_leak = $status[$inspection->inspection_hcoolant_leak]; }else{ $radiator_leak = NULL; }

            if(isset($status[$inspection->inspection_hbrake_level])){ $brake_level = $status[$inspection->inspection_hbrake_level]; }else{ $brake_level = NULL; }

            if(isset($status[$inspection->inspection_hbrake_leak])){ $brake_leak = $status[$inspection->inspection_hbrake_leak]; }else{ $brake_leak = NULL; }

            if(isset($status[$inspection->inspection_htrans_level])){ $transmission_level = $status[$inspection->inspection_htrans_level]; }else{ $transmission_level = NULL; }

            if(isset($status[$inspection->inspection_hpower_level])){ $steering_level = $status[$inspection->inspection_hpower_level]; }else{ $steering_level = NULL; }

            if(isset($status[$inspection->inspection_hbelt_crack])){ $check_cracks = $status[$inspection->inspection_hbelt_crack]; }else{ $check_cracks = NULL; }

            if(isset($status[$inspection->inspection_hbelt_hose])){ $ensure_hoses = $status[$inspection->inspection_hbelt_hose]; }else{ $ensure_hoses = NULL; }

            if(isset($status[$inspection->inspection_hbattery_terminal])){ $battery_terminals = $status[$inspection->inspection_hbattery_terminal]; }else{ $battery_terminals = NULL; }

            if(isset($status[$inspection->inspection_hbattery_level])){ $battery_level = $status[$inspection->inspection_hbattery_level]; }else{ $battery_level = NULL; }

            $result = array('id'=>$inspection->inspection_id,'oil_level_id'=>$inspection->inspection_hengine_oil,'oil_level'=>$oil_level,'oil_leak_id'=>$inspection->inspection_hengine_leak,'oil_leak'=>$oil_leak,'coolant_level_id'=>$inspection->inspection_hcoolant_level,'coolant_level'=>$coolant_level,'radiator_leak_id'=>$inspection->inspection_hcoolant_leak,'radiator_leak'=>$radiator_leak,'brake_level_id'=>$inspection->inspection_hbrake_level,'brake_level'=>$brake_level,'brake_leak_id'=>$inspection->inspection_hbrake_leak,'brake_leak'=>$brake_leak,'transmission_level_id'=>$inspection->inspection_htrans_level,'transmission_level'=>$transmission_level,'steering_level_id'=>$inspection->inspection_hpower_level,'steering_level'=>$steering_level,'check_cracks_id'=>$inspection->inspection_hbelt_crack,'check_cracks'=>$check_cracks,'ensure_hoses_id'=>$inspection->inspection_hbelt_hose,'ensure_hoses'=>$ensure_hoses,'battery_terminals_id'=>$inspection->inspection_hbattery_terminal,'battery_terminals'=>$battery_terminals,'battery_level_id'=>$inspection->inspection_hbattery_level,'battery_level'=>$battery_level);

            return $this->sendResponse($result, 'Under the Hood Details');
        }
        else
        {
            return $this->sendError('Under the Hood Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_under_hood(Request $request)
    {
        $upd['inspection_hengine_oil']       = $request->oil_level;
        $upd['inspection_hengine_leak']      = $request->oil_leak;
        $upd['inspection_hcoolant_level']    = $request->coolant_level;
        $upd['inspection_hcoolant_leak']     = $request->radiator_leak;
        $upd['inspection_hbrake_level']      = $request->brake_level;
        $upd['inspection_hbrake_leak']       = $request->brake_leak;
        $upd['inspection_htrans_level']      = $request->transmission_level;
        $upd['inspection_hpower_level']      = $request->steering_level;
        $upd['inspection_hbelt_crack']       = $request->check_cracks;
        $upd['inspection_hbelt_hose']        = $request->ensure_hoses;
        $upd['inspection_hbattery_terminal'] = $request->battery_terminals;
        $upd['inspection_hbattery_level']    = $request->battery_level;
        $upd['inspection_updated_on']        = date('Y-m-d H:i:s');
        $upd['inspection_updated_by']        = $request->user()->staff_id;

        Inspection::where('inspection_id',$request->segment(3))->update($upd);

        $result = array('inspection_id' => $request->segment(3));

        return $this->sendResponse($result, 'Under the Hood Updated Successfully');
    }

    public function under_vehicle_detail(Request $request)
    {
        $inspection = Inspection::where('inspection_id',$request->segment(3))->first();

        if(isset($inspection))
        {
            $status = array(1=>'Satisfactory',2=>'Unsatisfactory',3=>'N/A');

            if(isset($status[$inspection->inspection_vexhaust_rust])){ $inspect_rust = $status[$inspection->inspection_vexhaust_rust]; }else{ $inspect_rust = NULL; }

            if(isset($status[$inspection->inspection_vexhaust_hanger])){ $ensure_hangers = $status[$inspection->inspection_vexhaust_hanger]; }else{ $ensure_hangers = NULL; }

            if(isset($status[$inspection->inspection_vsuspension_wear])){ $check_wear = $status[$inspection->inspection_vsuspension_wear]; }else{ $check_wear = NULL; }

            if(isset($status[$inspection->inspection_vsuspension_play])){ $ensure_steering = $status[$inspection->inspection_vsuspension_play]; }else{ $ensure_steering = NULL; }

            if(isset($status[$inspection->inspection_vbrake_pads])){ $inspect_brake = $status[$inspection->inspection_vbrake_pads]; }else{ $inspect_brake = NULL; }

            if(isset($status[$inspection->inspection_vbrake_leak])){ $brake_leak = $status[$inspection->inspection_vbrake_leak]; }else{ $brake_leak = NULL; }

            if(isset($status[$inspection->inspection_vfluid_leak])){ $fluid_leak = $status[$inspection->inspection_vfluid_leak]; }else{ $fluid_leak = NULL; }

            $result = array('id'=>$inspection->inspection_id,'inspect_rust_id'=>$inspection->inspection_vexhaust_rust,'inspect_rust'=>$inspect_rust,'ensure_hangers_id'=>$inspection->inspection_vexhaust_hanger,'ensure_hangers'=>$ensure_hangers,'check_wear_id'=>$inspection->inspection_vsuspension_wear,'check_wear'=>$check_wear,'ensure_steering_id'=>$inspection->inspection_vsuspension_play,'ensure_steering'=>$ensure_steering,'inspect_brake_id'=>$inspection->inspection_vbrake_pads,'inspect_brake'=>$inspect_brake,'brake_leak_id'=>$inspection->inspection_vbrake_leak,'brake_leak'=>$brake_leak,'fluid_leak_id'=>$inspection->inspection_vfluid_leak,'fluid_leak'=>$fluid_leak);

            return $this->sendResponse($result, 'Under the Vehicle Details');
        }
        else
        {
            return $this->sendError('Under the Vehicle Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_under_vehicle(Request $request)
    {
        $upd['inspection_vexhaust_rust']    = $request->inspect_rust;
        $upd['inspection_vexhaust_hanger']  = $request->ensure_hangers;
        $upd['inspection_vsuspension_wear'] = $request->check_wear;
        $upd['inspection_vsuspension_play'] = $request->ensure_steering;
        $upd['inspection_vbrake_pads']      = $request->inspect_brake;
        $upd['inspection_vbrake_leak']      = $request->brake_leak;
        $upd['inspection_vfluid_leak']      = $request->fluid_leak;
        $upd['inspection_updated_on']       = date('Y-m-d H:i:s');
        $upd['inspection_updated_by']       = $request->user()->staff_id;

        Inspection::where('inspection_id',$request->segment(3))->update($upd);

        $result = array('inspection_id' => $request->segment(3));

        return $this->sendResponse($result, 'Under the Vehicle Updated Successfully');
    }

    public function functional_test_detail(Request $request)
    {
        $inspection = Inspection::where('inspection_id',$request->segment(3))->first();

        if(isset($inspection))
        {
            $status = array(1=>'Satisfactory',2=>'Unsatisfactory',3=>'N/A');

            if(isset($status[$inspection->inspection_tengine_start])){ $ensure_engine = $status[$inspection->inspection_tengine_start]; }else{ $ensure_engine = NULL; }

            if(isset($status[$inspection->inspection_tengine_sound])){ $abnormal_sound = $status[$inspection->inspection_tengine_sound]; }else{ $abnormal_sound = NULL; }

            if(isset($status[$inspection->inspection_tbrake_function])){ $test_brake = $status[$inspection->inspection_tbrake_function]; }else{ $test_brake = NULL; }

            if(isset($status[$inspection->inspection_tbrake_parking])){ $ensure_brake = $status[$inspection->inspection_tbrake_parking]; }else{ $ensure_brake = NULL; }

            if(isset($status[$inspection->inspection_tsteer_operation])){ $test_steering = $status[$inspection->inspection_tsteer_operation]; }else{ $test_steering = NULL; }

            if(isset($status[$inspection->inspection_tsteer_play])){ $ensure_steering = $status[$inspection->inspection_tsteer_play]; }else{ $ensure_steering = NULL; }

            if(isset($status[$inspection->inspection_ttrans_gear])){ $ensure_gear = $status[$inspection->inspection_ttrans_gear]; }else{ $ensure_gear = NULL; }

            if(isset($status[$inspection->inspection_ttrans_sound])){ $check_vibration = $status[$inspection->inspection_ttrans_sound]; }else{ $check_vibration = NULL; }

            if(isset($status[$inspection->inspection_twinter_level])){ $check_antifreeze = $status[$inspection->inspection_twinter_level]; }else{ $check_antifreeze = NULL; }

            if(isset($status[$inspection->inspection_twinter_heater])){ $ensure_heater = $status[$inspection->inspection_twinter_heater]; }else{ $ensure_heater = NULL; }

            if(isset($status[$inspection->inspection_tsummer_air])){ $inspect_ac = $status[$inspection->inspection_tsummer_air]; }else{ $inspect_ac = NULL; }

            if(isset($status[$inspection->inspection_tsummer_level])){ $check_coolant = $status[$inspection->inspection_tsummer_level]; }else{ $check_coolant = NULL; }

            if(isset($status[$inspection->inspection_tsummer_condition])){ $inspect_tire = $status[$inspection->inspection_tsummer_condition]; }else{ $inspect_tire = NULL; }

            $result = array('id'=>$inspection->inspection_id,'ensure_engine_id'=>$inspection->inspection_tengine_start,'ensure_engine'=>$ensure_engine,'abnormal_sound_id'=>$inspection->inspection_tengine_sound,'abnormal_sound'=>$abnormal_sound,'test_brake_id'=>$inspection->inspection_tbrake_function,'test_brake'=>$test_brake,'ensure_brake_id'=>$inspection->inspection_tbrake_parking,'ensure_brake'=>$ensure_brake,'test_steering_id'=>$inspection->inspection_tsteer_operation,'test_steering'=>$test_steering,'ensure_steering_id'=>$inspection->inspection_tsteer_play,'ensure_steering'=>$ensure_steering,'ensure_gear_id'=>$inspection->inspection_ttrans_gear,'ensure_gear'=>$ensure_gear,'check_vibration_id'=>$inspection->inspection_ttrans_sound,'check_vibration'=>$check_vibration,'check_antifreeze_id'=>$inspection->inspection_twinter_level,'check_antifreeze'=>$check_antifreeze,'ensure_heater_id'=>$inspection->inspection_twinter_heater,'ensure_heater'=>$ensure_heater,'inspect_ac_id'=>$inspection->inspection_tsummer_air,'inspect_ac'=>$inspect_ac,'check_coolant_id'=>$inspection->inspection_tsummer_level,'check_coolant'=>$check_coolant,'inspect_tire_id'=>$inspection->inspection_tsummer_condition,'inspect_tire'=>$inspect_tire);

            return $this->sendResponse($result, 'Functional Test Details');
        }
        else
        {
            return $this->sendError('Functional Test Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function edit_functional_test(Request $request)
    {
        $upd['inspection_tengine_start']     = $request->ensure_engine;
        $upd['inspection_tengine_sound']     = $request->abnormal_sound;
        $upd['inspection_tbrake_function']   = $request->test_brake;
        $upd['inspection_tbrake_parking']    = $request->ensure_brake;
        $upd['inspection_tsteer_operation']  = $request->test_steering;
        $upd['inspection_tsteer_play']       = $request->ensure_steering;
        $upd['inspection_ttrans_gear']       = $request->ensure_gear;
        $upd['inspection_ttrans_sound']      = $request->check_vibration;
        $upd['inspection_twinter_level']     = $request->check_antifreeze;
        $upd['inspection_twinter_heater']    = $request->ensure_heater;
        $upd['inspection_tsummer_air']       = $request->inspect_ac;
        $upd['inspection_tsummer_level']     = $request->check_coolant;
        $upd['inspection_tsummer_condition'] = $request->inspect_tire;
        $upd['inspection_updated_on']        = date('Y-m-d H:i:s');
        $upd['inspection_updated_by']        = $request->user()->staff_id;

        Inspection::where('inspection_id',$request->segment(3))->update($upd);

        $result = array('inspection_id' => $request->segment(3));

        return $this->sendResponse($result, 'Functional Test Updated Successfully');
    }

    public function inspection_status(Request $request)
    {
        $statuses = array(1=>'Satisfactory',2=>'Unsatisfactory',3=>'N/A');

        if(count($statuses) > 0)
        {
            foreach($statuses as $id => $status)
            {                
                $result[] = array('id'=>$id,'name'=>$status);
            }

            return $this->sendResponse($result, 'Status List');
        } 
        else
        {
            return $this->sendError('Status Not Available.', ['error'=>'Data Not Available']);
        }
    }
}