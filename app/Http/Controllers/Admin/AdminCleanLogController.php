<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vehicle;
use App\Models\CleaningLog;

class AdminCleanLogController extends Controller
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
        return view('admin.cleaning_log.cleaning_logs', $data);
    }

    public function get_cleaning_logs(Request $request)
    {
        if ($request->ajax()) {
            $where['cleaning_log_vehicle'] = $request->vehicle_id;
            $data = CleaningLog::where($where)->orderby('cleaning_log_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('cleaning_date', function ($row) {

                    $cleaning_date = date('d M Y', strtotime($row->cleaning_log_date));

                    return $cleaning_date;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/admin/edit_cleaning_log/' . $row->cleaning_log_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_cleaning_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'cleaning_log_date' => 'required',
                'cleaning_log_driver' => 'required',
                'cleaning_log_type' => 'required',
                'cleaning_log_location' => 'required',
                'cleaning_log_provider' => 'required',
                'cleaning_log_cost' => 'required'
            ];

            $messages = [
                'cleaning_log_date.required' => 'Please Select Date',
                'cleaning_log_driver.required' => 'Please Enter Driver',
                'cleaning_log_type.required' => 'Please Enter Type',
                'cleaning_log_location.required' => 'Please Enter Location',
                'cleaning_log_provider.required' => 'Please Enter Service Provider',
                'cleaning_log_cost.required' => 'Please Enter Cost'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['cleaning_log_vehicle']    = $request->segment(3);
                $ins['cleaning_log_date']       = date('Y-m-d', strtotime($request->cleaning_log_date));
                $ins['cleaning_log_driver']     = $request->cleaning_log_driver;
                $ins['cleaning_log_type']       = $request->cleaning_log_type;
                $ins['cleaning_log_location']   = $request->cleaning_log_location;
                $ins['cleaning_log_provider']   = $request->cleaning_log_provider;
                $ins['cleaning_log_cost']       = $request->cleaning_log_cost;
                $ins['cleaning_log_notes']      = $request->cleaning_log_notes;
                $ins['cleaning_log_added_on']   = date('Y-m-d H:i:s');
                $ins['cleaning_log_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['cleaning_log_updated_on'] = date('Y-m-d H:i:s');
                $ins['cleaning_log_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['cleaning_log_status']     = 1;

                $add = CleaningLog::create($ins);

                if ($add) {
                    return redirect('admin/cleaning_logs/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'vehicles';
        return view('admin.cleaning_log.add_cleaning_log', $data);
    }

    public function edit_cleaning_log(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'cleaning_log_date' => 'required',
                'cleaning_log_driver' => 'required',
                'cleaning_log_type' => 'required',
                'cleaning_log_location' => 'required',
                'cleaning_log_provider' => 'required',
                'cleaning_log_cost' => 'required'
            ];

            $messages = [
                'cleaning_log_date.required' => 'Please Select Date',
                'cleaning_log_driver.required' => 'Please Enter Driver',
                'cleaning_log_type.required' => 'Please Enter Type',
                'cleaning_log_location.required' => 'Please Enter Location',
                'cleaning_log_provider.required' => 'Please Enter Service Provider',
                'cleaning_log_cost.required' => 'Please Enter Cost'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['cleaning_log_date']       = date('Y-m-d', strtotime($request->cleaning_log_date));
                $upd['cleaning_log_driver']     = $request->cleaning_log_driver;
                $upd['cleaning_log_type']       = $request->cleaning_log_type;
                $upd['cleaning_log_location']   = $request->cleaning_log_location;
                $upd['cleaning_log_provider']   = $request->cleaning_log_provider;
                $upd['cleaning_log_cost']       = $request->cleaning_log_cost;
                $upd['cleaning_log_notes']      = $request->cleaning_log_notes;
                $upd['cleaning_log_updated_on'] = date('Y-m-d H:i:s');
                $upd['cleaning_log_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = CleaningLog::where('cleaning_log_id', $request->segment(3))->update($upd);

                return redirect('admin/cleaning_logs/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['cleaning_log'] = CleaningLog::where('cleaning_log_id', $request->segment(3))->first();

        if (!isset($data['cleaning_log'])) {
            return redirect('admin/vehicles');
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'vehicles';
        return view('admin.cleaning_log.edit_cleaning_log', $data);
    }

    public function cleaning_log_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['cleaning_log_status'] = 0;
        } else {
            $upd['cleaning_log_status'] = 1;
        }

        $where['cleaning_log_id'] = $id;

        $update = CleaningLog::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
