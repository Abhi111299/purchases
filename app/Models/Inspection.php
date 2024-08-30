<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = 'inspections';

    protected $primaryKey = 'inspection_id';

    public $timestamps = false;

    protected $fillable = ['inspection_vehicle','inspection_date','inspection_odometer','inspection_inspected','inspection_frequency','inspection_ninspection','inspection_notes','inspection_edents','inspection_epaints','inspection_ehead_light','inspection_elight_lense','inspection_etire_depth','inspection_etire_pressure','inspection_etire_damage','inspection_ewindow_crack','inspection_ewindow_power','inspection_ewiper_condition','inspection_ewiper_fluid','inspection_iseat_tear','inspection_iseat_belts','inspection_idashboard_light','inspection_idashboard_ac','inspection_imirror_condition','inspection_ipedal_wear','inspection_ifloor_position','inspection_hengine_oil','inspection_hengine_leak','inspection_hcoolant_level','inspection_hcoolant_leak','inspection_hbrake_level','inspection_hbrake_leak','inspection_htrans_level','inspection_hpower_level','inspection_hbelt_crack','inspection_hbelt_hose','inspection_hbattery_terminal','inspection_hbattery_level','inspection_vexhaust_rust','inspection_vexhaust_hanger','inspection_vsuspension_wear','inspection_vsuspension_play','inspection_vbrake_pads','inspection_vbrake_leak','inspection_vfluid_leak','inspection_tengine_start','inspection_tengine_sound','inspection_tbrake_function','inspection_tbrake_parking','inspection_tsteer_operation','inspection_tsteer_play','inspection_ttrans_gear','inspection_ttrans_sound','inspection_twinter_level','inspection_twinter_heater','inspection_tsummer_air','inspection_tsummer_level','inspection_tsummer_condition','inspection_added_on','inspection_added_by','inspection_updated_on','inspection_updated_by','inspection_status'];
}