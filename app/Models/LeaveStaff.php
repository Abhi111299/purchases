<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveStaff extends Model
{
    protected $table = 'leave_staffs';

    protected $primaryKey = 'lstaff_id';

    public $timestamps = false;

    protected $fillable = ['lstaff_leave','lstaff_staff','lstaff_added_on','lstaff_added_by','lstaff_updated_on','lstaff_updated_by','lstaff_status'];
    
    public static function getDetails($where)
    {
        $leave_staff = new LeaveStaff;

        return $leave_staff->select('*')
                    ->join('staffs','staffs.staff_id','leave_staffs.lstaff_staff')
                    ->where($where)
                    ->get();
    }
}