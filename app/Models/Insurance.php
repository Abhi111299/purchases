<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $table = 'insurances';

    protected $primaryKey = 'insurance_id';

    public $timestamps = false;

    protected $fillable = ['insurance_vehicle','insurance_policy_no','insurance_expiry','insurance_provider','insurance_coverage','insurance_notes','insurance_added_on','insurance_added_by','insurance_updated_on','insurance_updated_by','insurance_status'];
}