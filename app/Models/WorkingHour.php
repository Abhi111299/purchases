<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $table = 'working_hours';

    protected $primaryKey = 'wh_id';

    public $timestamps = false;

    protected $fillable = ['wh_booking_id','wh_date','wh_technician','wh_left_base','wh_start_time','wh_finish_time','wh_return_base','wh_added_on','wh_added_by','wh_updated_on','wh_updated_by','wh_status'];
}