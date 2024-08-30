<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';

    protected $primaryKey = 'manufacturer_id';

    public $timestamps = false;

    protected $fillable = ['manufacturer_name','manufacturer_added_on','manufacturer_added_by','manufacturer_updated_on','manufacturer_updated_by','manufacturer_status'];
}