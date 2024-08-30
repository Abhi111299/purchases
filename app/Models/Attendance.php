<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $primaryKey = 'attendance_id';

    public $timestamps = false;

    protected $fillable = ['attendance_staff','attendance_date','attendance_type','attendance_notes','attendance_added_on','attendance_added_by','attendance_updated_on','attendance_updated_by','attendance_status'];

    public static function getDetails()
    {
        $attendance = new Attendance;

        return $attendance->select('*')
                    ->join('staffs','staffs.staff_id','attendances.attendance_staff')
                    ->orderby('attendance_id','desc')
                    ->get();
    }

    public static function getWhereDetails($where)
    {
        $attendance = new Attendance;

        return $attendance->select('*')
                    ->join('staffs','staffs.staff_id','attendances.attendance_staff')
                    ->whereRaw($where)
                    ->orderby('attendance_id','desc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $attendance = new Attendance;

        return $attendance->select('*')
                    ->join('staffs','staffs.staff_id','attendances.attendance_staff')
                    ->where($where)
                    ->first();
    }
}