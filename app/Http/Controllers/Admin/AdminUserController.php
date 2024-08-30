<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Module;
use App\Models\Admin;

class AdminUserController extends Controller
{
    public function index()
    {
        $data['set'] = 'users';
        return view('admin.user.users', $data);
    }

    public function get_users(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::where('admin_role', '!=', 1)->orderby('admin_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('admin_name', function ($row) {
                    $user = '<img src="' . ($row->admin_image ? asset(config("constants.admin_path") . 'uploads/profile/' . $row->admin_image) : asset(config("constants.admin_path") . "dist/img/no_image.png")) . '" style="width:40px;height:40px;" class="img-thumbnail object-fit-cover rounded-circle">&nbsp;&nbsp;' . $row->admin_name;
                    return $user;
                })

                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_user/' . $row->admin_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->admin_status == 1) {
                        $btn .= '<a href="/admin/user_status/' . $row->admin_id . '/' . $row->admin_status . '" class="btn btn-danger btn-sm rounded-circle" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/user_status/' . $row->admin_id . '/' . $row->admin_status . '" class="btn btn-success btn-sm rounded-circle" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['admin_name', 'action'])
                ->make(true);
        }
    }

    public function add_user(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'admin_name' => 'required',
                'admin_email' => 'required',
                'admin_phone' => 'required',
                'admin_password' => 'required'
            ];

            $messages = [
                'admin_name.required' => 'Please Enter Name',
                'admin_email.required' => 'Please Enter Email Address',
                'admin_phone.required' => 'Please Enter Phone',
                'admin_password.required' => 'Please Enter Password'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_user = Admin::where('admin_email', $request->admin_email)->count();

                if ($check_user > 0) {
                    return redirect()->back()->with('error', 'User Already Added')->withInput();
                }

                $ins['admin_role']       = 2;
                $ins['admin_name']       = $request->admin_name;
                $ins['admin_email']      = $request->admin_email;
                $ins['admin_phone']      = $request->admin_phone;
                $ins['admin_password']   = bcrypt($request->admin_password);
                $ins['admin_vpassword']  = base64_encode($request->admin_password);
                $ins['admin_modules']    = json_encode($request->admin_modules);
                $ins['admin_added_on']   = date('Y-m-d H:i:s');
                $ins['admin_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['admin_updated_on'] = date('Y-m-d H:i:s');
                $ins['admin_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['admin_status']     = 1;

                if ($request->hasFile('admin_image')) {
                    $admin_image = $request->admin_image->store('assets/admin/uploads/profile');

                    $admin_image = explode('/', $admin_image);
                    $admin_image = end($admin_image);
                    $ins['admin_image'] = $admin_image;
                }

                $add = Admin::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'User Added Successfully');
                }
            }
        }

        $data['modules'] = Module::where('module_status', 1)->orderby('module_name', 'asc')->get();

        $data['set'] = 'add_user';
        return view('admin.user.add_user', $data);
    }

    public function edit_user(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'admin_name' => 'required',
                'admin_email' => 'required',
                'admin_phone' => 'required',
                'admin_password' => 'required'
            ];

            $messages = [
                'admin_name.required' => 'Please Enter Name',
                'admin_email.required' => 'Please Enter Email Address',
                'admin_phone.required' => 'Please Enter Phone',
                'admin_password.required' => 'Please Enter Password'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_user = Admin::where('admin_email', $request->admin_email)->where('admin_id', '!=', $request->segment(3))->count();

                if ($check_user > 0) {
                    return redirect()->back()->with('error', 'User Already Added')->withInput();
                }

                $upd['admin_name']       = $request->admin_name;
                $upd['admin_email']      = $request->admin_email;
                $upd['admin_phone']      = $request->admin_phone;
                $upd['admin_password']   = bcrypt($request->admin_password);
                $upd['admin_vpassword']  = base64_encode($request->admin_password);
                $upd['admin_modules']    = json_encode($request->admin_modules);
                $upd['admin_updated_on'] = date('Y-m-d H:i:s');
                $upd['admin_updated_by'] = Auth::guard('admin')->user()->admin_id;

                if ($request->hasFile('admin_image')) {
                    $admin_image = $request->admin_image->store('assets/admin/uploads/profile');

                    $admin_image = explode('/', $admin_image);
                    $admin_image = end($admin_image);
                    $upd['admin_image'] = $admin_image;
                }

                $add = Admin::where('admin_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'User Updated Successfully');
            }
        }

        $data['user'] = Admin::where('admin_id', $request->segment(3))->first();

        if (!isset($data['user'])) {
            return redirect('admin/users');
        }

        $data['modules'] = Module::where('module_status', 1)->orderby('module_name', 'asc')->get();

        $data['set'] = 'edit_user';
        return view('admin.user.edit_user', $data);
    }

    public function user_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['admin_status'] = 0;
        } else {
            $upd['admin_status'] = 1;
        }

        $where['admin_id'] = $id;

        $update = Admin::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
