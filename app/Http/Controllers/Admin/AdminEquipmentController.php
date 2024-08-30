<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Equipment;

class AdminEquipmentController extends Controller
{
    public function index()
    {
        $data['set'] = 'equipments';
        return view('admin.equipment.equipments', $data);
    }

    public function get_equipments(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $data = Equipment::where('equipment_added_by', Auth::guard('admin')->user()->admin_id)->orderby('equipment_id', 'desc')->get();
            } else {
                $data = Equipment::orderby('equipment_id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="edit_equipment/' . $row->equipment_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->equipment_status == 1) {
                        $btn .= '<a href="equipment_status/' . $row->equipment_id . '/' . $row->equipment_status . '" class="btn rounded-circle btn-danger btn-sm" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="equipment_status/' . $row->equipment_id . '/' . $row->equipment_status . '" class="btn rounded-circle btn-success btn-sm" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_equipment(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['equipment_name' => 'required'];

            $messages = ['equipment_name.required' => 'Please Enter Equipment'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_equipment = Equipment::where('equipment_name', $request->equipment_name)->count();

                if ($check_equipment > 0) {
                    return redirect()->back()->with('error', 'Equipment Already Added')->withInput();
                }

                $ins['equipment_name']       = $request->equipment_name;
                $ins['equipment_added_on']   = date('Y-m-d H:i:s');
                $ins['equipment_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['equipment_updated_on'] = date('Y-m-d H:i:s');
                $ins['equipment_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['equipment_status']     = 1;

                $add = Equipment::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Equipment Added Successfully');
                }
            }
        }

        $data['set'] = 'equipments';
        return view('admin.equipment.add_equipment', $data);
    }

    public function edit_equipment(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['equipment_name' => 'required'];

            $messages = ['equipment_name.required' => 'Please Enter Equipment'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_equipment = Equipment::where('equipment_name', $request->equipment_name)->where('equipment_id', '!=', $request->segment(3))->count();

                if ($check_equipment > 0) {
                    return redirect()->back()->with('error', 'Equipment Already Added')->withInput();
                }

                $upd['equipment_name']       = $request->equipment_name;
                $upd['equipment_updated_on'] = date('Y-m-d H:i:s');
                $upd['equipment_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Equipment::where('equipment_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Equipment Updated Successfully');
            }
        }

        $data['equipment'] = Equipment::where('equipment_id', $request->segment(3))->first();

        if (!isset($data['equipment'])) {
            return redirect('admin/equipments');
        }

        $data['set'] = 'equipments';
        return view('admin.equipment.edit_equipment', $data);
    }

    public function equipment_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['equipment_status'] = 0;
        } else {
            $upd['equipment_status'] = 1;
        }

        $where['equipment_id'] = $id;

        $update = Equipment::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
