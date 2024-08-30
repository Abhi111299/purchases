<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\TripLog;
use App\Models\Vehicle;
   
class StaffVehicleController extends BaseController
{
    public function index(Request $request)
    {
        $where['vehicle_driver'] = $request->user()->staff_id;
        $where['vehicle_status'] = 1;
        $vehicles = Vehicle::getWhereDetails($where);

        if($vehicles->count() > 0)
        {
            foreach($vehicles as $vehicle)
            {
                $staff_name = $vehicle->staff_fname.' '.$vehicle->staff_mname.' '.$vehicle->staff_lname;

                $where_strip['trip_log_vehicle'] = $vehicle->vehicle_id;
                $where_strip['trip_log_status'] = 1;
                $strip_log = TripLog::where($where_strip)->orderby('trip_log_id','asc')->first();
                
                if(isset($strip_log->trip_log_sodometer))
                {
                    $start_odometer = $strip_log->trip_log_sodometer;
                }
                else
                {
                    $start_odometer = 0;
                }

                $where_ltrip['trip_log_vehicle'] = $vehicle->vehicle_id;
                $where_ltrip['trip_log_status'] = 1;
                $ltrip_log = TripLog::where($where_ltrip)->orderby('trip_log_id','desc')->first();
                
                if(isset($ltrip_log->trip_log_eodometer))
                {
                    $last_odometer = $ltrip_log->trip_log_eodometer;
                }
                else
                {
                    $last_odometer = 0;
                }

                if($last_odometer == 0)
                {
                    $total_km = 0;
                }
                else
                {
                    $total_km = $last_odometer - $start_odometer;
                }

                $result[] = array('id'=>$vehicle->vehicle_id,'manufacturer'=>$vehicle->manufacturer_name,'model'=>$vehicle->model_name,'year'=>$vehicle->vehicle_year,'license_plate_no'=>$vehicle->vehicle_license_no,'driver'=>$staff_name,'start_odometer'=>$start_odometer,'last_odometer'=>$last_odometer,'total_kilometer'=>$total_km);
            }

            return $this->sendResponse($result, 'Vehicle List');
        }
        else
        {
            return $this->sendError('Vehicles Not Available.', ['error'=>'Data Not Available']);
        }
    }
}