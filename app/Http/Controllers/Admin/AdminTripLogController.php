<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vehicle;
use App\Models\TripLog;

class AdminTripLogController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['vehicle'] = Vehicle::where('vehicle_id', $request->segment(3))->first();

        if (!isset($data['vehicle'])) {
            return redirect('admin/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('admin.trip_log.trip_logs', $data);
    }

    public function get_trip_logs(Request $request)
    {
        if ($request->ajax()) {
            $where['trip_log_vehicle'] = $request->vehicle_id;
            $data = TripLog::where($where)->orderby('trip_log_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('trip_date', function ($row) {

                    $trip_date = date('d M Y', strtotime($row->trip_log_date));

                    return $trip_date;
                })
                ->addColumn('start_time', function ($row) {

                    $start_time = date('h:i A', strtotime($row->trip_log_stime));

                    return $start_time;
                })
                ->addColumn('end_time', function ($row) {

                    $end_time = date('h:i A', strtotime($row->trip_log_etime));

                    return $end_time;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/admin/edit_trip_log/' . $row->trip_log_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_trip_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'trip_log_date' => 'required',
                'trip_log_driver' => 'required',
                'trip_log_stime' => 'required',
                'trip_log_sodometer' => 'required'
            ];

            $messages = [
                'trip_log_date.required' => 'Please Select Date',
                'trip_log_driver.required' => 'Please Enter Driver',
                'trip_log_stime.required' => 'Please Select Start Time',
                'trip_log_sodometer.required' => 'Please Enter Start Odometer'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['trip_log_vehicle']    = $request->segment(3);
                $ins['trip_log_date']       = date('Y-m-d', strtotime($request->trip_log_date));
                $ins['trip_log_driver']     = $request->trip_log_driver;
                $ins['trip_log_stime']      = date('H:i', strtotime($request->trip_log_stime));
                $ins['trip_log_sodometer']  = $request->trip_log_sodometer;
                $ins['trip_log_eodometer']  = $request->trip_log_eodometer;
                $ins['trip_log_details']    = $request->trip_log_details;
                $ins['trip_log_notes']      = $request->trip_log_notes;
                $ins['trip_log_added_on']   = date('Y-m-d H:i:s');
                $ins['trip_log_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['trip_log_updated_on'] = date('Y-m-d H:i:s');
                $ins['trip_log_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['trip_log_status']     = 1;

                if (!empty($request->trip_log_etime)) {
                    $ins['trip_log_etime'] = date('H:i', strtotime($request->trip_log_etime));
                } else {
                    $ins['trip_log_etime'] = NULL;
                }

                $add = TripLog::create($ins);

                if ($add) {
                    return redirect('admin/trip_logs/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['last_trip'] = TripLog::where('trip_log_vehicle', $request->segment(3))->orderby('trip_log_id', 'desc')->first();

        $data['set'] = 'vehicles';
        return view('admin.trip_log.add_trip_log', $data);
    }

    public function edit_trip_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'trip_log_date' => 'required',
                'trip_log_driver' => 'required',
                'trip_log_stime' => 'required',
                'trip_log_etime' => 'required',
                'trip_log_sodometer' => 'required'
            ];

            $messages = [
                'trip_log_date.required' => 'Please Select Date',
                'trip_log_driver.required' => 'Please Enter Driver',
                'trip_log_stime.required' => 'Please Select Start Time',
                'trip_log_etime.required' => 'Please Select End Time',
                'trip_log_sodometer.required' => 'Please Enter Start Odometer'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['trip_log_date']       = date('Y-m-d', strtotime($request->trip_log_date));
                $upd['trip_log_driver']     = $request->trip_log_driver;
                $upd['trip_log_stime']      = date('H:i', strtotime($request->trip_log_stime));
                $upd['trip_log_etime']      = date('H:i', strtotime($request->trip_log_etime));
                $upd['trip_log_sodometer']  = $request->trip_log_sodometer;
                $upd['trip_log_eodometer']  = $request->trip_log_eodometer;
                $upd['trip_log_details']    = $request->trip_log_details;
                $upd['trip_log_notes']      = $request->trip_log_notes;
                $upd['trip_log_updated_on'] = date('Y-m-d H:i:s');
                $upd['trip_log_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = TripLog::where('trip_log_id', $request->segment(3))->update($upd);

                return redirect('admin/trip_logs/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['trip_log'] = TripLog::where('trip_log_id', $request->segment(3))->first();

        if (!isset($data['trip_log'])) {
            return redirect('admin/vehicles');
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'vehicles';
        return view('admin.trip_log.edit_trip_log', $data);
    }

    public function trip_log_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['trip_log_status'] = 0;
        } else {
            $upd['trip_log_status'] = 1;
        }

        $where['trip_log_id'] = $id;

        $update = TripLog::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
