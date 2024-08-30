<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    public $timestamps = false;

    protected $fillable = ['admin_role','admin_name','admin_email','admin_password','admin_vpassword','admin_phone','admin_image','admin_modules','admin_added_on','admin_added_by','admin_updated_on','admin_updated_by','admin_status'];

    protected $hidden = ['admin_password'];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    public function purchaseRequests()
    {   
        return $this->hasMany(PurchaseRequest::class, 'staff_id', 'admin_id');
    }
}