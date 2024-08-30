<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vehicle;
use App\Models\FuelLog;

class StaffFuelLogController extends Controller
{
    public function index(Request $request)
    {
        $data['vehicle'] = Vehicle::where('vehicle_id', $request->segment(3))->first();

        if (!isset($data['vehicle'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.fuel_log.fuel_logs', $data);
    }

    public function get_fuel_logs(Request $request)
    {
        if ($request->ajax()) {
            $where['fuel_log_vehicle'] = $request->vehicle_id;
            $data = FuelLog::where($where)->orderby('fuel_log_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('fuel_date', function ($row) {

                    $fuel_date = date('d M Y', strtotime($row->fuel_log_date));

                    return $fuel_date;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/staff/edit_fuel_log/' . $row->fuel_log_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_fuel_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'fuel_log_date' => 'required',
                'fuel_log_driver' => 'required',
                'fuel_log_odometer' => 'required',
                'fuel_log_fadded' => 'required',
                'fuel_log_cost' => 'required'
            ];

            $messages = [
                'fuel_log_date.required' => 'Please Select Date',
                'fuel_log_driver.required' => 'Please Enter Driver',
                'fuel_log_odometer.required' => 'Please Enter Odometer Reading',
                'fuel_log_fadded.required' => 'Please Enter Fuel Added',
                'fuel_log_cost.required' => 'Please Enter Cost'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['fuel_log_vehicle']    = $request->segment(3);
                $ins['fuel_log_date']       = date('Y-m-d', strtotime($request->fuel_log_date));
                $ins['fuel_log_driver']     = $request->fuel_log_driver;
                $ins['fuel_log_odometer']   = $request->fuel_log_odometer;
                $ins['fuel_log_fadded']     = $request->fuel_log_fadded;
                $ins['fuel_log_cost']       = $request->fuel_log_cost;
                $ins['fuel_log_notes']      = $request->fuel_log_notes;
                $ins['fuel_log_added_on']   = date('Y-m-d H:i:s');
                $ins['fuel_log_added_by']   = Auth::guard('staff')->user()->staff_id;
                $ins['fuel_log_updated_on'] = date('Y-m-d H:i:s');
                $ins['fuel_log_updated_by'] = Auth::guard('staff')->user()->staff_id;
                $ins['fuel_log_status']     = 1;

                $add = FuelLog::create($ins);

                if ($add) {
                    return redirect('staff/fuel_logs/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        $data['set'] = 'vehicles';
        return view('staff.fuel_log.add_fuel_log', $data);
    }

    public function edit_fuel_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'fuel_log_date' => 'required',
                'fuel_log_driver' => 'required',
                'fuel_log_odometer' => 'required',
                'fuel_log_fadded' => 'required',
                'fuel_log_cost' => 'required'
            ];

            $messages = [
                'fuel_log_date.required' => 'Please Select Date',
                'fuel_log_driver.required' => 'Please Enter Driver',
                'fuel_log_odometer.required' => 'Please Enter Odometer Reading',
                'fuel_log_fadded.required' => 'Please Enter Fuel Added',
                'fuel_log_cost.required' => 'Please Enter Cost'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['fuel_log_date']       = date('Y-m-d', strtotime($request->fuel_log_date));
                $upd['fuel_log_driver']     = $request->fuel_log_driver;
                $upd['fuel_log_odometer']   = $request->fuel_log_odometer;
                $upd['fuel_log_fadded']     = $request->fuel_log_fadded;
                $upd['fuel_log_cost']       = $request->fuel_log_cost;
                $upd['fuel_log_notes']      = $request->fuel_log_notes;
                $upd['fuel_log_updated_on'] = date('Y-m-d H:i:s');
                $upd['fuel_log_updated_by'] = Auth::guard('staff')->user()->staff_id;

                $add = FuelLog::where('fuel_log_id', $request->segment(3))->update($upd);

                return redirect('staff/fuel_logs/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['fuel_log'] = FuelLog::where('fuel_log_id', $request->segment(3))->first();

        if (!isset($data['fuel_log'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.fuel_log.edit_fuel_log', $data);
    }

    public function fuel_log_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['fuel_log_status'] = 0;
        } else {
            $upd['fuel_log_status'] = 1;
        }

        $where['fuel_log_id'] = $id;

        $update = FuelLog::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
