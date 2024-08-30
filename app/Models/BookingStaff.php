<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingStaff extends Model
{
    protected $table = 'booking_staffs';

    protected $primaryKey = 'bstaff_id';

    public $timestamps = false;

    protected $fillable = ['bstaff_booking','bstaff_staff','bstaff_added_on','bstaff_added_by','bstaff_updated_on','bstaff_updated_by','bstaff_status'];
}