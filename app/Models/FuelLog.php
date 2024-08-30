<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    protected $table = 'fuel_logs';

    protected $primaryKey = 'fuel_log_id';

    public $timestamps = false;

    protected $fillable = ['fuel_log_vehicle','fuel_log_date','fuel_log_driver','fuel_log_odometer','fuel_log_fadded','fuel_log_cost','fuel_log_notes','fuel_log_added_on','fuel_log_added_by','fuel_log_updated_on','fuel_log_updated_by','fuel_log_status'];
}