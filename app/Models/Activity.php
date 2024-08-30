<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $primaryKey = 'activity_id';

    public $timestamps = false;

    protected $fillable = ['activity_name','activity_code','activity_added_on','activity_added_by','activity_updated_on','activity_updated_by','activity_status'];
}