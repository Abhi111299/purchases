<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $primaryKey = 'location_id';

    public $timestamps = false;

    protected $fillable = ['location_name','location_added_on','location_added_by','location_updated_on','location_updated_by','location_status'];
}