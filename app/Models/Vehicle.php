<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $primaryKey = 'vehicle_id';

    public $timestamps = false;

    protected $fillable = ['vehicle_manufacturer','vehicle_model','vehicle_year','vehicle_license_no','vehicle_no','vehicle_owner','vehicle_address','vehicle_reg_date','vehicle_exp_date','vehicle_authority','vehicle_state','vehicle_location','vehicle_driver','vehicle_engine_type','vehicle_transmission','vehicle_fuel_type','vehicle_body_type','vehicle_color','vehicle_odometer_reading','vehicle_features','vehicle_average_milegae','vehicle_type','vehicle_loan_amount','vehicle_purchase_price','vehicle_depreciation','vehicle_documents','vehicle_added_on','vehicle_added_by','vehicle_updated_on','vehicle_updated_by','vehicle_status'];

    public static function getDetails()
    {
        $vehicle = new Vehicle;

        return $vehicle->select('*')
                    ->join('manufacturers','manufacturers.manufacturer_id','vehicles.vehicle_manufacturer')
                    ->join('models','models.model_id','vehicles.vehicle_model')
                    ->leftjoin('staffs','staffs.staff_id','vehicles.vehicle_driver')
                    ->orderby('vehicle_id','desc')
                    ->get();
    }

    public static function getWhereDetails($where)
    {
        $vehicle = new Vehicle;

        return $vehicle->select('*')
                    ->join('manufacturers','manufacturers.manufacturer_id','vehicles.vehicle_manufacturer')
                    ->join('models','models.model_id','vehicles.vehicle_model')
                    ->leftjoin('staffs','staffs.staff_id','vehicles.vehicle_driver')
                    ->where($where)
                    ->orderby('vehicle_id','desc')
                    ->get();
    }
}