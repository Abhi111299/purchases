<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\TripLog;
use App\Models\Vehicle;

class StaffVehicleController extends Controller
{
    public function index()
    {
        $data['set'] = 'vehicles';
        return view('staff.vehicle.vehicles',$data);
    }

    public function get_vehicles(Request $request)
    {
        if($request->ajax())
        {
            $where['vehicle_driver'] = Auth::guard('staff')->user()->staff_id;
            $where['vehicle_status'] = 1;
            $data = Vehicle::getWhereDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('staff_name', function($row){
                        
                        $staff_name = $row->staff_fname.' '.$row->staff_mname.' '.$row->staff_lname;

                        return $staff_name;
                    })
                    ->addColumn('start_odometer', function($row){
                        
                        $where_trip['trip_log_vehicle'] = $row->vehicle_id;
                        $where_trip['trip_log_status'] = 1;
                        $trip_log = TripLog::where($where_trip)->orderby('trip_log_id','asc')->first();
                        
                        if(isset($trip_log->trip_log_sodometer))
                        {
                            $start_odometer = $trip_log->trip_log_sodometer;
                        }
                        else
                        {
                            $start_odometer = 0;
                        }
                        
                        return $start_odometer;
                    })
                    ->addColumn('last_odometer', function($row){
                        
                        $where_trip['trip_log_vehicle'] = $row->vehicle_id;
                        $where_trip['trip_log_status'] = 1;
                        $trip_log = TripLog::where($where_trip)->orderby('trip_log_id','desc')->first();
                        
                        if(isset($trip_log->trip_log_eodometer))
                        {
                            $last_odometer = $trip_log->trip_log_eodometer;
                        }
                        else
                        {
                            $last_odometer = 0;
                        }
                        
                        return $last_odometer;
                    })
                    ->addColumn('total_km', function($row){
                        
                        $where_trip['trip_log_vehicle'] = $row->vehicle_id;
                        $where_trip['trip_log_status'] = 1;
                        
                        $start_log = TripLog::where($where_trip)->orderby('trip_log_id','asc')->first();
                        
                        if(isset($start_log->trip_log_sodometer))
                        {
                            $start_odometer = $start_log->trip_log_sodometer;
                        }
                        else
                        {
                            $start_odometer = 0;
                        }
                        
                        $last_log = TripLog::where($where_trip)->orderby('trip_log_id','desc')->first();
                        
                        if(isset($last_log->trip_log_eodometer))
                        {
                            $last_odometer = $last_log->trip_log_eodometer;
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
                        
                        return $total_km;
                    })
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="trip_logs/'.$row->vehicle_id.'" class="btn btn-success btn-sm" title="Logs"><i class="fa fa-database"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }
}