<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accident extends Model
{
    protected $table = 'accidents';

    protected $primaryKey = 'accident_id';

    public $timestamps = false;

    protected $fillable = ['accident_vehicle','accident_date','accident_time','accident_driver','accident_location','accident_parties','accident_desc','accident_damage','accident_notes','accident_photographs','accident_added_on','accident_added_by','accident_updated_on','accident_updated_by','accident_status'];
}