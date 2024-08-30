<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffInduction extends Model
{
    protected $table = 'staff_inductions';

    protected $primaryKey = 'sinduction_id';

    public $timestamps = false;

    protected $fillable = ['sinduction_staff','sinduction_client','sinduction_site','sinduction_name','sinduction_type','sinduction_date','sinduction_edate','sinduction_pstatus','sinduction_copy','sinduction_added_on','sinduction_added_by','sinduction_updated_on','sinduction_updated_by','sinduction_status'];

    public static function getDetails($where)
    {
        $induction = new StaffInduction;

        return $induction->select('*')
                    ->join('staffs','staffs.staff_id','staff_inductions.sinduction_staff')
                    ->join('customers','customers.customer_id','staff_inductions.sinduction_client')
                    ->where($where)
                    ->orderby('sinduction_edate','asc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $induction = new StaffInduction;

        return $induction->select('*')
                    ->join('staffs','staffs.staff_id','staff_inductions.sinduction_staff')
                    ->join('customers','customers.customer_id','staff_inductions.sinduction_client')
                    ->where($where)
                    ->first();
    }
}