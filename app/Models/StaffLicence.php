<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffLicence extends Model
{
    protected $table = 'staff_licences';

    protected $primaryKey = 'slicence_id';

    public $timestamps = false;

    protected $fillable = ['slicence_staff','slicence_training','slicence_tlocation','slicence_torganisation','slicence_training_type','slicence_date','slicence_edate','slicence_pstatus','slicence_copy','slicence_added_on','slicence_added_by','slicence_updated_on','slicence_updated_by','slicence_status'];

    public static function getDetails($where)
    {
        $licence = new StaffLicence;

        return $licence->select('*')
                    ->join('staffs','staffs.staff_id','staff_licences.slicence_staff')
                    ->join('trainings','trainings.training_id','staff_licences.slicence_training')
                    ->where($where)
                    ->orderby('slicence_edate','asc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $licence = new StaffLicence;

        return $licence->select('*')
                    ->join('staffs','staffs.staff_id','staff_licences.slicence_staff')
                    ->join('trainings','trainings.training_id','staff_licences.slicence_training')
                    ->where($where)
                    ->first();
    }
}