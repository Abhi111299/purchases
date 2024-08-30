<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'booking_id';

    public $timestamps = false;

    protected $fillable = ['booking_job_id','booking_service','booking_customer','booking_start','booking_end','booking_activities','booking_lname','booking_llink','booking_order_no','booking_crequest_no','booking_cjob_no','booking_file','booking_branch','booking_instruction','booking_worksheet','booking_drawing','booking_frequest','booking_description','booking_equipments','booking_consumables','booking_nata','booking_nvehicles','booking_rhours','booking_aexpenses','booking_vname','booking_vemail','booking_vphone','booking_vsignature','booking_cname','booking_cemail','booking_cphone','booking_csignature','booking_photographs','booking_added_on','booking_added_by','booking_updated_on','booking_updated_by','booking_status','booking_trash'];

    public static function getDetails()
    {
        $booking = new Booking;

        return $booking->select('*')
                    ->join('services','services.service_id','bookings.booking_service')
                    ->join('customers','customers.customer_id','bookings.booking_customer')
                    ->orderby('booking_id','desc')
                    ->get();
    }

    public static function getWhereDetails($where)
    {
        $booking = new Booking;

        return $booking->select('*')
                    ->join('services','services.service_id','bookings.booking_service')
                    ->join('customers','customers.customer_id','bookings.booking_customer')
                    ->whereRaw($where)
                    ->orderby('booking_id','desc')
                    ->get();
    }

    public static function getStaffWhereDetails($where)
    {
        $booking = new Booking;

        return $booking->select('*')
                    ->join('services','services.service_id','bookings.booking_service')
                    ->join('customers','customers.customer_id','bookings.booking_customer')
                    ->join('booking_staffs','booking_staffs.bstaff_booking','bookings.booking_id')
                    ->whereRaw($where)
                    ->orderby('booking_id','desc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $booking = new Booking;

        return $booking->select('*')
                    ->join('services','services.service_id','bookings.booking_service')
                    ->join('customers','customers.customer_id','bookings.booking_customer')
                    ->where($where)
                    ->first();
    }

    public static function getAllDetail($where)
    {
        $booking = new Booking;

        return $booking->select('*')
                    ->join('services','services.service_id','bookings.booking_service')
                    ->join('customers','customers.customer_id','bookings.booking_customer')
                    ->where($where)
                    ->first();
    }

    public static function getBookingStaffs($where)
    {
        $booking = new Booking;

        return $booking->select('*')
                    ->join('booking_staffs','booking_staffs.bstaff_booking','bookings.booking_id')
                    ->where('booking_status','!=',5)
                    ->where($where)
                    ->get();
    }
}