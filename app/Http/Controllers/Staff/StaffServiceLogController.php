<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vehicle;
use App\Models\Staff;
use App\Models\ServiceLog;

class StaffServiceLogController extends Controller
{
    public function index(Request $request)
    {
        $data['vehicle'] = Vehicle::where('vehicle_id', $request->segment(3))->first();

        if (!isset($data['vehicle'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.service_log.service_logs', $data);
    }

    public function get_service_logs(Request $request)
    {
        if ($request->ajax()) {
            $where['service_log_vehicle'] = $request->vehicle_id;
            $data = ServiceLog::getDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = $row->staff_fname . ' ' . $row->staff_lname;

                    return $staff_name;
                })
                ->addColumn('service_date', function ($row) {

                    $service_date = date('d M Y', strtotime($row->service_log_date));

                    return $service_date;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/staff/edit_service_log/' . $row->service_log_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_service_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'service_log_date' => 'required',
                'service_log_requested' => 'required',
                'service_log_odometer' => 'required',
                'service_log_nodometer' => 'required',
                'service_log_provider' => 'required',
                'service_log_cost' => 'required'
            ];

            $messages = [
                'service_log_date.required' => 'Please Select Date',
                'service_log_requested.required' => 'Please Select Requested By',
                'service_log_odometer.required' => 'Please Enter Odometer Reading',
                'service_log_nodometer.required' => 'Please Enter Next Service Odometer',
                'service_log_provider.required' => 'Please Enter Service Provider',
                'service_log_cost.required' => 'Please Enter Cost'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['service_log_vehicle']    = $request->segment(3);
                $ins['service_log_date']       = date('Y-m-d', strtotime($request->service_log_date));
                $ins['service_log_requested']  = $request->service_log_requested;
                $ins['service_log_odometer']   = $request->service_log_odometer;
                $ins['service_log_nodometer']  = $request->service_log_nodometer;
                $ins['service_log_provider']   = $request->service_log_provider;
                $ins['service_log_cost']       = $request->service_log_cost;
                $ins['service_log_notes']      = $request->service_log_notes;
                $ins['service_log_added_on']   = date('Y-m-d H:i:s');
                $ins['service_log_added_by']   = Auth::guard('staff')->user()->staff_id;
                $ins['service_log_updated_on'] = date('Y-m-d H:i:s');
                $ins['service_log_updated_by'] = Auth::guard('staff')->user()->staff_id;
                $ins['service_log_status']     = 1;

                $add = ServiceLog::create($ins);

                if ($add) {
                    return redirect('staff/service_logs/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        $data['staffs'] = Staff::where('staff_status', 1)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'vehicles';
        return view('staff.service_log.add_service_log', $data);
    }

    public function edit_service_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'service_log_date' => 'required',
                'service_log_requested' => 'required',
                'service_log_odometer' => 'required',
                'service_log_nodometer' => 'required',
                'service_log_provider' => 'required',
                'service_log_cost' => 'required'
            ];

            $messages = [
                'service_log_date.required' => 'Please Select Date',
                'service_log_requested.required' => 'Please Select Requested By',
                'service_log_odometer.required' => 'Please Enter Odometer Reading',
                'service_log_nodometer.required' => 'Please Enter Next Service Odometer',
                'service_log_provider.required' => 'Please Enter Service Provider',
                'service_log_cost.required' => 'Please Enter Cost'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['service_log_date']       = date('Y-m-d', strtotime($request->service_log_date));
                $upd['service_log_requested']  = $request->service_log_requested;
                $upd['service_log_odometer']   = $request->service_log_odometer;
                $upd['service_log_nodometer']  = $request->service_log_nodometer;
                $upd['service_log_provider']   = $request->service_log_provider;
                $upd['service_log_cost']       = $request->service_log_cost;
                $upd['service_log_notes']      = $request->service_log_notes;
                $upd['service_log_updated_on'] = date('Y-m-d H:i:s');
                $upd['service_log_updated_by'] = Auth::guard('staff')->user()->staff_id;

                $add = ServiceLog::where('service_log_id', $request->segment(3))->update($upd);

                return redirect('staff/service_logs/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['service_log'] = ServiceLog::where('service_log_id', $request->segment(3))->first();

        if (!isset($data['service_log'])) {
            return redirect('staff/vehicles');
        }

        $data['staffs'] = Staff::where('staff_status', 1)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'vehicles';
        return view('staff.service_log.edit_service_log', $data);
    }

    public function service_log_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['service_log_status'] = 0;
        } else {
            $upd['service_log_status'] = 1;
        }

        $where['service_log_id'] = $id;

        $update = ServiceLog::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
