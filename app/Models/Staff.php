<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens;
    
    protected $table = 'staffs';

    protected $primaryKey = 'staff_id';

    public $timestamps = false;

    protected $fillable = ['staff_no','staff_dept','staff_role','staff_job_type','staff_fname','staff_lname','staff_email','staff_password','staff_vpassword','staff_dob','staff_mobile','staff_phone','staff_haddress','staff_hsuburb','staff_hstate','staff_hpost_code','staff_oaddress','staff_ostate','staff_ocountry','staff_ophone','staff_ename','staff_erelationship','staff_ephone','staff_residence','staff_country','staff_nationality','staff_dlicense_country','staff_sannuation_funds','staff_tax_no','staff_education_details','staff_id_country','staff_id_expiry','staff_id_type','staff_id_classification','staff_id_copy','staff_id_other','staff_id_oissue','staff_id_oexpiry','staff_documents','staff_image','staff_employement','staff_added_on','staff_added_by','staff_updated_on','staff_updated_by','staff_status','staff_trash'];

    protected $hidden = ['staff_password'];

    public function getAuthPassword()
    {
        return $this->staff_password;
    }

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class, 'staff_id', 'staff_id');
    }

    public static function getDetails($where)
    {
        $staff = new Staff;

        return $staff->select('*')
                    ->join('departments','departments.department_id','staffs.staff_dept')
                    ->join('roles','roles.role_id','staffs.staff_role')
                    ->where($where)
                    ->orderby('staff_id','desc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $staff = new Staff;

        return $staff->select('*')
                    ->join('departments','departments.department_id','staffs.staff_dept')
                    ->join('roles','roles.role_id','staffs.staff_role')
                    ->where($where)
                    ->first();
    }

}