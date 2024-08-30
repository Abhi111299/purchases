<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffQualification extends Model
{
    protected $table = 'staff_qualifications';

    protected $primaryKey = 'squalification_id';

    public $timestamps = false;

    protected $fillable = ['squalification_staff','squalification_cbody','squalification_held','squalification_level','squalification_date','squalification_edate','squalification_pstatus','squalification_copy','squalification_added_on','squalification_added_by','squalification_updated_on','squalification_updated_by','squalification_status'];

    public static function getDetails($where)
    {
        $qualification = new StaffQualification;

        return $qualification->select('*')
                    ->join('staffs','staffs.staff_id','staff_qualifications.squalification_staff')
                    ->where($where)
                    ->orderby('squalification_edate','asc')
                    ->get();
    }
}