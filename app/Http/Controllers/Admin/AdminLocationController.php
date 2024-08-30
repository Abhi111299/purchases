<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Location;

class AdminLocationController extends Controller
{
    public function index()
    {
        $data['set'] = 'locations';
        return view('admin.location.locations', $data);
    }

    public function get_locations(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $data = Location::where('location_added_by', Auth::guard('admin')->user()->admin_id)->orderby('location_id', 'desc')->get();
            } else {
                $data = Location::orderby('location_id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_location/' . $row->location_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->location_status == 1) {
                        $btn .= '<a href="/admin/location_status/' . $row->location_id . '/' . $row->location_status . '" class="btn rounded-circle btn-danger btn-sm" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/location_status/' . $row->location_id . '/' . $row->location_status . '" class="btn  rounded-circle btn-success btn-sm" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_location(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['location_name' => 'required'];

            $messages = ['location_name.required' => 'Please Enter Location'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_location = Location::where('location_name', $request->location_name)->count();

                if ($check_location > 0) {
                    return redirect()->back()->with('error', 'Location Already Added')->withInput();
                }

                $ins['location_name']       = $request->location_name;
                $ins['location_added_on']   = date('Y-m-d H:i:s');
                $ins['location_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['location_updated_on'] = date('Y-m-d H:i:s');
                $ins['location_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['location_status']     = 1;

                $add = Location::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Location Added Successfully');
                }
            }
        }

        $data['set'] = 'locations';
        return view('admin.location.add_location', $data);
    }

    public function edit_location(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['location_name' => 'required'];

            $messages = ['location_name.required' => 'Please Enter Location'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_location = Location::where('location_name', $request->location_name)->where('location_id', '!=', $request->segment(3))->count();

                if ($check_location > 0) {
                    return redirect()->back()->with('error', 'Location Already Added')->withInput();
                }

                $upd['location_name']       = $request->location_name;
                $upd['location_updated_on'] = date('Y-m-d H:i:s');
                $upd['location_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Location::where('location_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Location Updated Successfully');
            }
        }

        $data['location'] = Location::where('location_id', $request->segment(3))->first();

        if (!isset($data['location'])) {
            return redirect('admin/locations');
        }

        $data['set'] = 'locations';
        return view('admin.location.edit_location', $data);
    }

    public function location_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['location_status'] = 0;
        } else {
            $upd['location_status'] = 1;
        }

        $where['location_id'] = $id;

        $update = Location::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
