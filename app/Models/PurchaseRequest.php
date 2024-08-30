<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class PurchaseRequest extends Model
{
    protected $table = 'purchase_requests';

    protected $primaryKey = 'id';

    public $timestamps = false; 

    protected $fillable = ['request_number','request_date', 'staff_id', 'item_name','item_description','unit','price','request_to_approval','status', 'created_at','updated_at'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'staff_id', 'admin_id');
    }

    public static function getDetails()
    {
        return self::select('purchase_requests.*', 
                            DB::raw("CONCAT(staffs.staff_fname, ' ', staffs.staff_lname) as staff_full_name"))
                   ->join('staffs', 'purchase_requests.request_to_approval', '=', 'staffs.staff_id')
                   ->orderBy('purchase_requests.id', 'asc')
                   ->get();
    }

    public static function getDetailsStaff()
    {
        $loggedInUserId = Auth::guard('staff')->user()->staff_id;
        return self::select('purchase_requests.*', 
                            DB::raw("CONCAT(staffs.staff_fname, ' ', staffs.staff_lname) as staff_full_name"))
                   ->join('staffs', 'purchase_requests.request_to_approval', '=', 'staffs.staff_id')
                   ->where('purchase_requests.staff_id', $loggedInUserId)
                   ->orderBy('purchase_requests.id', 'asc')
                   ->get();
    }
}
