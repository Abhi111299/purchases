<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Manufacturer;

class AdminManufacturerController extends Controller
{
    public function index()
    {
        $data['set'] = 'manufacturers';
        return view('admin.manufacturer.manufacturers', $data);
    }

    public function get_manufacturers(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $data = Manufacturer::where('manufacturer_added_by', Auth::guard('admin')->user()->admin_id)->orderby('manufacturer_id', 'desc')->get();
            } else {
                $data = Manufacturer::orderby('manufacturer_id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_manufacturer/' . $row->manufacturer_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->manufacturer_status == 1) {
                        $btn .= '<a href="/admin/manufacturer_status/' . $row->manufacturer_id . '/' . $row->manufacturer_status . '" class="btn rounded-circle btn-danger btn-sm" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/manufacturer_status/' . $row->manufacturer_id . '/' . $row->manufacturer_status . '" class="btn rounded-circle btn-success btn-sm" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_manufacturer(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['manufacturer_name' => 'required'];

            $messages = ['manufacturer_name.required' => 'Please Enter Manufacturer'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_manufacturer = Manufacturer::where('manufacturer_name', $request->manufacturer_name)->count();

                if ($check_manufacturer > 0) {
                    return redirect()->back()->with('error', 'Manufacturer Already Added')->withInput();
                }

                $ins['manufacturer_name']       = $request->manufacturer_name;
                $ins['manufacturer_added_on']   = date('Y-m-d H:i:s');
                $ins['manufacturer_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['manufacturer_updated_on'] = date('Y-m-d H:i:s');
                $ins['manufacturer_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['manufacturer_status']     = 1;

                $add = Manufacturer::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Manufacturer Added Successfully');
                }
            }
        }

        $data['set'] = 'manufacturers';
        return view('admin.manufacturer.add_manufacturer', $data);
    }

    public function edit_manufacturer(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['manufacturer_name' => 'required'];

            $messages = ['manufacturer_name.required' => 'Please Enter Manufacturer'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_manufacturer = Manufacturer::where('manufacturer_name', $request->manufacturer_name)->where('manufacturer_id', '!=', $request->segment(3))->count();

                if ($check_manufacturer > 0) {
                    return redirect()->back()->with('error', 'Manufacturer Already Added')->withInput();
                }

                $upd['manufacturer_name']       = $request->manufacturer_name;
                $upd['manufacturer_updated_on'] = date('Y-m-d H:i:s');
                $upd['manufacturer_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Manufacturer::where('manufacturer_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Manufacturer Updated Successfully');
            }
        }

        $data['manufacturer'] = Manufacturer::where('manufacturer_id', $request->segment(3))->first();

        if (!isset($data['manufacturer'])) {
            return redirect('admin/manufacturers');
        }

        $data['set'] = 'manufacturers';
        return view('admin.manufacturer.edit_manufacturer', $data);
    }

    public function manufacturer_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['manufacturer_status'] = 0;
        } else {
            $upd['manufacturer_status'] = 1;
        }

        $where['manufacturer_id'] = $id;

        $update = Manufacturer::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
