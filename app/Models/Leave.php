<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';

    protected $primaryKey = 'leave_id';

    public $timestamps = false;

    protected $fillable = ['leave_staff','leave_type','leave_date','leave_reason','leave_sdate','leave_wdate','leave_added_on','leave_added_by','leave_updated_on','leave_updated_by','leave_status','leave_trash'];

    public static function getDetails($where)
    {
        $leave = new Leave;

        return $leave->select('*')
                    ->join('leave_staffs','leave_staffs.lstaff_leave','leaves.leave_id')
                    ->where($where)
                    ->orderby('leave_id','desc')
                    ->get();
    }

    public static function getAdminDetails()
    {
        $leave = new Leave;

        return $leave->select('*')
                    ->orderby('leave_id','desc')
                    ->get();
    }

    public static function getWhereAdminDetails($where)
    {
        $leave = new Leave;

        return $leave->select('*')
                    ->join('staffs','staffs.staff_id','leaves.leave_staff')
                    ->where($where)
                    ->orderby('leave_id','desc')
                    ->get();
    }
}