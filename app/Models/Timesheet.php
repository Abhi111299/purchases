<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $table = 'timesheets';

    protected $primaryKey = 'timesheet_id';

    public $timestamps = false;

    protected $fillable = ['timesheet_staff','timesheet_date','timesheet_wtype','timesheet_start','timesheet_end','timesheet_client','timesheet_desc','timesheet_location','timesheet_added_on','timesheet_added_by','timesheet_updated_on','timesheet_updated_by','timesheet_status'];

    public static function getDetails()
    {
        $timesheet = new Timesheet;

        return $timesheet->select('*')
                    ->join('staffs','staffs.staff_id','timesheets.timesheet_staff')
                    ->orderby('timesheet_id','desc')
                    ->get();
    }

    public static function getWhereDetails($where)
    {
        $timesheet = new Timesheet;

        return $timesheet->select('*')
                    ->join('staffs','staffs.staff_id','timesheets.timesheet_staff')
                    ->whereRaw($where)
                    ->orderby('timesheet_id','desc')
                    ->get();
    }

    public static function getStaffDetails($where)
    {
        $timesheet = new Timesheet;

        return $timesheet->select('*')
                    ->join('staffs','staffs.staff_id','timesheets.timesheet_staff')
                    ->leftjoin('customers','customers.customer_id','timesheets.timesheet_client')
                    ->leftjoin('locations','locations.location_id','timesheets.timesheet_location')
                    ->where($where)
                    ->orderby('timesheet_id','desc')
                    ->get();
    }

    public static function getWhereStaffDetails($where)
    {
        $timesheet = new Timesheet;

        return $timesheet->select('*')
                    ->join('staffs','staffs.staff_id','timesheets.timesheet_staff')
                    ->leftjoin('customers','customers.customer_id','timesheets.timesheet_client')
                    ->leftjoin('locations','locations.location_id','timesheets.timesheet_location')
                    ->whereRaw($where)
                    ->orderby('timesheet_id','desc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $timesheet = new Timesheet;

        return $timesheet->select('*')
                    ->join('staffs','staffs.staff_id','timesheets.timesheet_staff')
                    ->where($where)
                    ->first();
    }
}