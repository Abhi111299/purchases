<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Consumable;

class AdminConsumableController extends Controller
{
    public function index()
    {
        $data['set'] = 'consumables';
        return view('admin.consumable.consumables', $data);
    }

    public function get_consumables(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $data = Consumable::where('consumable_added_by', Auth::guard('admin')->user()->admin_id)->orderby('consumable_id', 'desc')->get();
            } else {
                $data = Consumable::orderby('consumable_id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_consumable/' . $row->consumable_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->consumable_status == 1) {
                        $btn .= '<a href="/admin/consumable_status/' . $row->consumable_id . '/' . $row->consumable_status . '" class="btn rounded-circle btn-danger btn-sm" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/consumable_status/' . $row->consumable_id . '/' . $row->consumable_status . '" class="btn rounded-circle btn-success btn-sm" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_consumable(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['consumable_name' => 'required'];

            $messages = ['consumable_name.required' => 'Please Enter Consumable'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_consumable = Consumable::where('consumable_name', $request->consumable_name)->count();

                if ($check_consumable > 0) {
                    return redirect()->back()->with('error', 'Consumable Already Added')->withInput();
                }

                $ins['consumable_name']       = $request->consumable_name;
                $ins['consumable_added_on']   = date('Y-m-d H:i:s');
                $ins['consumable_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['consumable_updated_on'] = date('Y-m-d H:i:s');
                $ins['consumable_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['consumable_status']     = 1;

                $add = Consumable::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Consumable Added Successfully');
                }
            }
        }

        $data['set'] = 'consumables';
        return view('admin.consumable.add_consumable', $data);
    }

    public function edit_consumable(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['consumable_name' => 'required'];

            $messages = ['consumable_name.required' => 'Please Enter Consumable'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_consumable = Consumable::where('consumable_name', $request->consumable_name)->where('consumable_id', '!=', $request->segment(3))->count();

                if ($check_consumable > 0) {
                    return redirect()->back()->with('error', 'Consumable Already Added')->withInput();
                }

                $upd['consumable_name']       = $request->consumable_name;
                $upd['consumable_updated_on'] = date('Y-m-d H:i:s');
                $upd['consumable_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Consumable::where('consumable_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Consumable Updated Successfully');
            }
        }

        $data['consumable'] = Consumable::where('consumable_id', $request->segment(3))->first();

        if (!isset($data['consumable'])) {
            return redirect('admin/consumables');
        }

        $data['set'] = 'consumables';
        return view('admin.consumable.edit_consumable', $data);
    }

    public function consumable_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['consumable_status'] = 0;
        } else {
            $upd['consumable_status'] = 1;
        }

        $where['consumable_id'] = $id;

        $update = Consumable::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }

    public function consumable_list()
    {
        if (!in_array('8', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['consumable'] = Consumable::orderby('consumable_id', 'asc')->get();
        $data['set'] = 'consumable';
        return $data;
    }
}
