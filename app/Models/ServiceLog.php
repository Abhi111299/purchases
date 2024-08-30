<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceLog extends Model
{
    protected $table = 'service_logs';

    protected $primaryKey = 'service_log_id';

    public $timestamps = false;

    protected $fillable = ['service_log_vehicle','service_log_date','service_log_requested','service_log_odometer','service_log_nodometer','service_log_provider','service_log_cost','service_log_notes','service_log_added_on','service_log_added_by','service_log_updated_on','service_log_updated_by','service_log_status'];

    public static function getDetails($where)
    {
        $service_log = new ServiceLog;

        return $service_log->select('*')
                    ->join('staffs','staffs.staff_id','service_logs.service_log_requested')
                    ->where($where)
                    ->orderby('service_log_id','desc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $service_log = new ServiceLog;

        return $service_log->select('*')
                    ->join('staffs','staffs.staff_id','service_logs.service_log_requested')
                    ->where($where)
                    ->first();
    }
}