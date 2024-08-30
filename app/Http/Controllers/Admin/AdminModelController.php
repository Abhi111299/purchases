<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Manufacturer;
use App\Models\Models;

class AdminModelController extends Controller
{
    public function index()
    {
        $data['set'] = 'models';
        return view('admin.model.models', $data);
    }

    public function get_models(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $where['model_added_by'] = Auth::guard('admin')->user()->admin_id;
                $data = Models::getWhereDetails($where);
            } else {
                $data = Models::getDetails();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_model/' . $row->model_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->model_status == 1) {
                        $btn .= '<a href="/admin/model_status/' . $row->model_id . '/' . $row->model_status . '" class="btn rounded-circle btn-danger btn-sm" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/model_status/' . $row->model_id . '/' . $row->model_status . '" class="btn rounded-circle btn-success btn-sm" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_model(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'model_manufacturer' => 'required',
                'model_name' => 'required'
            ];

            $messages = [
                'model_manufacturer.required' => 'Please Select Manufacturer',
                'model_name.required' => 'Please Enter Model'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $where_check['model_manufacturer'] = $request->model_manufacturer;
                $where_check['model_name'] = $request->model_name;
                $check_model = Models::where($where_check)->count();

                if ($check_model > 0) {
                    return redirect()->back()->with('error', 'Model Already Added')->withInput();
                }

                $ins['model_manufacturer'] = $request->model_manufacturer;
                $ins['model_name']         = $request->model_name;
                $ins['model_added_on']     = date('Y-m-d H:i:s');
                $ins['model_added_by']     = Auth::guard('admin')->user()->admin_id;
                $ins['model_updated_on']   = date('Y-m-d H:i:s');
                $ins['model_updated_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['model_status']       = 1;

                $add = Models::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Model Added Successfully');
                }
            }
        }

        $data['manufacturers'] = Manufacturer::where('manufacturer_status', 1)->orderby('manufacturer_name', 'asc')->get();

        $data['set'] = 'models';
        return view('admin.model.add_model', $data);
    }

    public function edit_model(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'model_manufacturer' => 'required',
                'model_name' => 'required'
            ];

            $messages = [
                'model_manufacturer.required' => 'Please Select Manufacturer',
                'model_name.required' => 'Please Enter Model'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $where_check['model_manufacturer'] = $request->model_manufacturer;
                $where_check['model_name'] = $request->model_name;
                $check_model = Models::where($where_check)->where('model_id', '!=', $request->segment(3))->count();

                if ($check_model > 0) {
                    return redirect()->back()->with('error', 'Model Already Added')->withInput();
                }

                $upd['model_manufacturer'] = $request->model_manufacturer;
                $upd['model_name']         = $request->model_name;
                $upd['model_updated_on']   = date('Y-m-d H:i:s');
                $upd['model_updated_by']   = Auth::guard('admin')->user()->admin_id;

                $add = Models::where('model_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Model Updated Successfully');
            }
        }

        $data['model'] = Models::where('model_id', $request->segment(3))->first();

        if (!isset($data['model'])) {
            return redirect('admin/models');
        }

        $data['manufacturers'] = Manufacturer::where('manufacturer_status', 1)->orderby('manufacturer_name', 'asc')->get();

        $data['set'] = 'models';
        return view('admin.model.edit_model', $data);
    }

    public function model_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['model_status'] = 0;
        } else {
            $upd['model_status'] = 1;
        }

        $where['model_id'] = $id;

        $update = Models::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
