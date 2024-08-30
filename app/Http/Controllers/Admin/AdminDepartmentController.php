<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Department;

class AdminDepartmentController extends Controller
{
    public function index()
    {
        $data['set'] = 'departments';
        return view('admin.department.departments', $data);
    }

    public function get_departments(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $data = Department::where('department_added_by', Auth::guard('admin')->user()->admin_id)->orderby('department_id', 'desc')->get();
            } else {
                $data = Department::orderby('department_id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="edit_department/' . $row->department_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->department_status == 1) {
                        $btn .= '<a href="department_status/' . $row->department_id . '/' . $row->department_status . '" class="btn rounded-circle btn-danger btn-sm" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="department_status/' . $row->department_id . '/' . $row->department_status . '" class="btn rounded-circle btn-success btn-sm" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn."</div>;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_department(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['department_name' => 'required'];

            $messages = ['department_name.required' => 'Please Enter Department'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_department = Department::where('department_name', $request->department_name)->count();

                if ($check_department > 0) {
                    return redirect()->back()->with('error', 'Department Already Added')->withInput();
                }

                $ins['department_name']       = $request->department_name;
                $ins['department_added_on']   = date('Y-m-d H:i:s');
                $ins['department_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['department_updated_on'] = date('Y-m-d H:i:s');
                $ins['department_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['department_status']     = 1;

                $add = Department::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Department Added Successfully');
                }
            }
        }

        $data['set'] = 'departments';
        return view('admin.department.add_department', $data);
    }

    public function edit_department(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['department_name' => 'required'];

            $messages = ['department_name.required' => 'Please Enter Department'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_department = Department::where('department_name', $request->department_name)->where('department_id', '!=', $request->segment(3))->count();

                if ($check_department > 0) {
                    return redirect()->back()->with('error', 'Department Already Added')->withInput();
                }

                $upd['department_name']       = $request->department_name;
                $upd['department_updated_on'] = date('Y-m-d H:i:s');
                $upd['department_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Department::where('department_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Department Updated Successfully');
            }
        }

        $data['department'] = Department::where('department_id', $request->segment(3))->first();

        if (!isset($data['department'])) {
            return redirect('admin/departments');
        }

        $data['set'] = 'departments';
        return view('admin.department.edit_department', $data);
    }

    public function department_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['department_status'] = 0;
        } else {
            $upd['department_status'] = 1;
        }

        $where['department_id'] = $id;

        $update = Department::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
