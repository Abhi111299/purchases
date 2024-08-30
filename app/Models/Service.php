<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $primaryKey = 'service_id';

    public $timestamps = false;

    protected $fillable = ['service_name','service_desc','service_added_on','service_added_by','service_updated_on','service_updated_by','service_status'];
}