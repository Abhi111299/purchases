<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\RepairLog;

class StaffRepairLogController extends Controller
{
    public function index(Request $request)
    {
        $data['vehicle'] = Vehicle::where('vehicle_id', $request->segment(3))->first();

        if (!isset($data['vehicle'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.repair_log.repair_logs', $data);
    }

    public function get_repair_logs(Request $request)
    {
        if ($request->ajax()) {
            $where['repair_log_vehicle'] = $request->vehicle_id;
            $data = RepairLog::getDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {

                    $staff_name = $row->staff_fname . ' ' . $row->staff_lname;

                    return $staff_name;
                })
                ->addColumn('repair_date', function ($row) {

                    $repair_date = date('d M Y', strtotime($row->repair_log_date));

                    return $repair_date;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/staff/edit_repair_log/' . $row->repair_log_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_repair_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'repair_log_date' => 'required',
                'repair_log_odometer' => 'required',
                'repair_log_performed' => 'required',
                'repair_log_replaced' => 'required',
                'repair_log_lcost' => 'required',
                'repair_log_pcost' => 'required',
                'repair_log_cost' => 'required',
                'repair_log_provider' => 'required'
            ];

            $messages = [
                'repair_log_date.required' => 'Please Select Date',
                'repair_log_odometer.required' => 'Please Enter Odometer Reading',
                'repair_log_performed.required' => 'Please Select Repair requested by',
                'repair_log_replaced.required' => 'Please Enter Parts Replaced',
                'repair_log_lcost.required' => 'Please Enter Labor Cost',
                'repair_log_pcost.required' => 'Please Enter Parts Cost',
                'repair_log_cost.required' => 'Please Enter Total Cost',
                'repair_log_provider.required' => 'Please Enter Service Provider'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['repair_log_vehicle']    = $request->segment(3);
                $ins['repair_log_date']       = date('Y-m-d', strtotime($request->repair_log_date));
                $ins['repair_log_odometer']   = $request->repair_log_odometer;
                $ins['repair_log_performed']  = $request->repair_log_performed;
                $ins['repair_log_replaced']   = $request->repair_log_replaced;
                $ins['repair_log_lcost']      = $request->repair_log_lcost;
                $ins['repair_log_pcost']      = $request->repair_log_pcost;
                $ins['repair_log_cost']       = $request->repair_log_cost;
                $ins['repair_log_provider']   = $request->repair_log_provider;
                $ins['repair_log_notes']      = $request->repair_log_notes;
                $ins['repair_log_added_on']   = date('Y-m-d H:i:s');
                $ins['repair_log_added_by']   = Auth::guard('staff')->user()->staff_id;
                $ins['repair_log_updated_on'] = date('Y-m-d H:i:s');
                $ins['repair_log_updated_by'] = Auth::guard('staff')->user()->staff_id;
                $ins['repair_log_status']     = 1;

                $add = RepairLog::create($ins);

                if ($add) {
                    return redirect('staff/repair_logs/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        $data['staffs'] = Staff::where('staff_status', 1)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'vehicles';
        return view('staff.repair_log.add_repair_log', $data);
    }

    public function edit_repair_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'repair_log_date' => 'required',
                'repair_log_odometer' => 'required',
                'repair_log_performed' => 'required',
                'repair_log_replaced' => 'required',
                'repair_log_lcost' => 'required',
                'repair_log_pcost' => 'required',
                'repair_log_cost' => 'required',
                'repair_log_provider' => 'required'
            ];

            $messages = [
                'repair_log_date.required' => 'Please Select Date',
                'repair_log_odometer.required' => 'Please Enter Odometer Reading',
                'repair_log_performed.required' => 'Please Select Repair requested by',
                'repair_log_replaced.required' => 'Please Enter Parts Replaced',
                'repair_log_lcost.required' => 'Please Enter Labor Cost',
                'repair_log_pcost.required' => 'Please Enter Parts Cost',
                'repair_log_cost.required' => 'Please Enter Total Cost',
                'repair_log_provider.required' => 'Please Enter Service Provider'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['repair_log_date']       = date('Y-m-d', strtotime($request->repair_log_date));
                $upd['repair_log_odometer']   = $request->repair_log_odometer;
                $upd['repair_log_performed']  = $request->repair_log_performed;
                $upd['repair_log_replaced']   = $request->repair_log_replaced;
                $upd['repair_log_lcost']      = $request->repair_log_lcost;
                $upd['repair_log_pcost']      = $request->repair_log_pcost;
                $upd['repair_log_cost']       = $request->repair_log_cost;
                $upd['repair_log_provider']   = $request->repair_log_provider;
                $upd['repair_log_notes']      = $request->repair_log_notes;
                $upd['repair_log_updated_on'] = date('Y-m-d H:i:s');
                $upd['repair_log_updated_by'] = Auth::guard('staff')->user()->staff_id;

                $add = RepairLog::where('repair_log_id', $request->segment(3))->update($upd);

                return redirect('staff/repair_logs/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['repair_log'] = RepairLog::where('repair_log_id', $request->segment(3))->first();

        if (!isset($data['repair_log'])) {
            return redirect('staff/vehicles');
        }

        $data['staffs'] = Staff::where('staff_status', 1)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'vehicles';
        return view('staff.repair_log.edit_repair_log', $data);
    }

    public function repair_log_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['repair_log_status'] = 0;
        } else {
            $upd['repair_log_status'] = 1;
        }

        $where['repair_log_id'] = $id;

        $update = RepairLog::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
