<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripLog extends Model
{
    protected $table = 'trip_logs';

    protected $primaryKey = 'trip_log_id';

    public $timestamps = false;

    protected $fillable = ['trip_log_vehicle','trip_log_date','trip_log_driver','trip_log_stime','trip_log_etime','trip_log_sodometer','trip_log_eodometer','trip_log_details','trip_log_notes','trip_log_added_on','trip_log_added_by','trip_log_updated_on','trip_log_updated_by','trip_log_status'];
}