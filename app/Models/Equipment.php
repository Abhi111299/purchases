<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $primaryKey = 'equipment_id';

    public $timestamps = false;

    protected $fillable = ['equipment_name','equipment_added_on','equipment_added_by','equipment_updated_on','equipment_updated_by','equipment_status'];
}