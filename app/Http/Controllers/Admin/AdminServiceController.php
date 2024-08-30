<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Service;

class AdminServiceController extends Controller
{
    public function index()
    {
        if (!in_array('3', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'services';
        return view('admin.service.services', $data);
    }

    public function get_services(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::orderby('service_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_service/' . $row->service_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->service_status == 1) {
                        $btn .= '<a href="/admin/service_status/' . $row->service_id . '/' . $row->service_status . '" class="btn btn-danger btn-sm rounded-circle" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/service_status/' . $row->service_id . '/' . $row->service_status . '" class="btn btn-success btn-sm rounded-circle" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_service(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'service_name' => 'required',
                'service_desc' => 'required'
            ];

            $messages = [
                'service_name.required' => 'Please Enter Service',
                'service_desc.required' => 'Please Enter Description'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_service = Service::where('service_name', $request->service_name)->count();

                if ($check_service > 0) {
                    return redirect()->back()->with('error', 'Service Already Added')->withInput();
                }

                $ins['service_name']       = $request->service_name;
                $ins['service_desc']       = $request->service_desc;
                $ins['service_added_on']   = date('Y-m-d H:i:s');
                $ins['service_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['service_updated_on'] = date('Y-m-d H:i:s');
                $ins['service_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['service_status']     = 1;

                $add = Service::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Service Added Successfully');
                }
            }
        }

        if (!in_array('3', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'add_service';
        return view('admin.service.add_service', $data);
    }

    public function edit_service(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'service_name' => 'required',
                'service_desc' => 'required'
            ];

            $messages = [
                'service_name.required' => 'Please Enter Service',
                'service_desc.required' => 'Please Enter Description'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_service = Service::where('service_name', $request->service_name)->where('service_id', '!=', $request->segment(3))->count();

                if ($check_service > 0) {
                    return redirect()->back()->with('error', 'Service Already Added')->withInput();
                }

                $upd['service_name']       = $request->service_name;
                $upd['service_desc']       = $request->service_desc;
                $upd['service_updated_on'] = date('Y-m-d H:i:s');
                $upd['service_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Service::where('service_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Service Updated Successfully');
            }
        }

        $data['service'] = Service::where('service_id', $request->segment(3))->first();

        if (!isset($data['service'])) {
            return redirect('admin/services');
        }

        if (!in_array('3', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'edit_service';
        return view('admin.service.edit_service', $data);
    }

    public function service_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['service_status'] = 0;
        } else {
            $upd['service_status'] = 1;
        }

        $where['service_id'] = $id;

        $update = Service::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
