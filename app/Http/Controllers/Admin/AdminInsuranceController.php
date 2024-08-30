<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vehicle;
use App\Models\Insurance;

class AdminInsuranceController extends Controller
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
        return view('admin.insurance.insurances', $data);
    }

    public function get_insurances(Request $request)
    {
        if ($request->ajax()) {
            $where['insurance_vehicle'] = $request->vehicle_id;
            $data = Insurance::where($where)->orderby('insurance_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('expiry_date', function ($row) {

                    $expiry_date = date('d M Y', strtotime($row->insurance_expiry));

                    return $expiry_date;
                })
                ->addColumn('coverage', function ($row) {

                    $coverage = '';

                    if ($row->insurance_coverage == 1) {
                        $coverage = 'Liability';
                    } elseif ($row->insurance_coverage == 2) {
                        $coverage = 'Comprehensive';
                    } elseif ($row->insurance_coverage == 3) {
                        $coverage = 'Collision';
                    } elseif ($row->insurance_coverage == 4) {
                        $coverage = 'Third Part';
                    }

                    return $coverage;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/admin/edit_insurance/' . $row->insurance_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_insurance(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'insurance_policy_no' => 'required',
                'insurance_expiry' => 'required',
                'insurance_provider' => 'required',
                'insurance_coverage' => 'required'
            ];

            $messages = [
                'insurance_policy_no.required' => 'Please Enter Policy Number',
                'insurance_expiry.required' => 'Please Select Date',
                'insurance_provider.required' => 'Please Enter Provider',
                'insurance_coverage.required' => 'Please Select Coverage'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['insurance_vehicle']    = $request->segment(3);
                $ins['insurance_policy_no']  = $request->insurance_policy_no;
                $ins['insurance_expiry']     = date('Y-m-d', strtotime($request->insurance_expiry));
                $ins['insurance_provider']   = $request->insurance_provider;
                $ins['insurance_coverage']   = $request->insurance_coverage;
                $ins['insurance_notes']      = $request->insurance_notes;
                $ins['insurance_added_on']   = date('Y-m-d H:i:s');
                $ins['insurance_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['insurance_updated_on'] = date('Y-m-d H:i:s');
                $ins['insurance_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['insurance_status']     = 1;

                $add = Insurance::create($ins);

                if ($add) {
                    return redirect('admin/insurances/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'vehicles';
        return view('admin.insurance.add_insurance', $data);
    }

    public function edit_insurance(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'insurance_policy_no' => 'required',
                'insurance_expiry' => 'required',
                'insurance_provider' => 'required',
                'insurance_coverage' => 'required'
            ];

            $messages = [
                'insurance_policy_no.required' => 'Please Enter Policy Number',
                'insurance_expiry.required' => 'Please Select Date',
                'insurance_provider.required' => 'Please Enter Provider',
                'insurance_coverage.required' => 'Please Select Coverage'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $upd['insurance_policy_no']  = $request->insurance_policy_no;
                $upd['insurance_expiry']     = date('Y-m-d', strtotime($request->insurance_expiry));
                $upd['insurance_provider']   = $request->insurance_provider;
                $upd['insurance_coverage']   = $request->insurance_coverage;
                $upd['insurance_notes']      = $request->insurance_notes;
                $upd['insurance_updated_on'] = date('Y-m-d H:i:s');
                $upd['insurance_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Insurance::where('insurance_id', $request->segment(3))->update($upd);

                return redirect('admin/insurances/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['insurance'] = Insurance::where('insurance_id', $request->segment(3))->first();

        if (!isset($data['insurance'])) {
            return redirect('admin/vehicles');
        }

        if (!in_array('15', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'vehicles';
        return view('admin.insurance.edit_insurance', $data);
    }

    public function insurance_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['insurance_status'] = 0;
        } else {
            $upd['insurance_status'] = 1;
        }

        $where['insurance_id'] = $id;

        $update = Insurance::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
