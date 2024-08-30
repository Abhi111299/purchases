<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairLog extends Model
{
    protected $table = 'repair_logs';

    protected $primaryKey = 'repair_log_id';

    public $timestamps = false;

    protected $fillable = ['repair_log_vehicle','repair_log_date','repair_log_odometer','repair_log_performed','repair_log_replaced','repair_log_lcost','repair_log_pcost','repair_log_cost','repair_log_provider','repair_log_notes','repair_log_added_on','repair_log_added_by','repair_log_updated_on','repair_log_updated_by','repair_log_status'];

    public static function getDetails($where)
    {
        $repair_log = new RepairLog;

        return $repair_log->select('*')
                    ->join('staffs','staffs.staff_id','repair_logs.repair_log_performed')
                    ->where($where)
                    ->orderby('repair_log_id','desc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $repair_log = new RepairLog;

        return $repair_log->select('*')
                    ->join('staffs','staffs.staff_id','repair_logs.repair_log_performed')
                    ->where($where)
                    ->first();
    }
}