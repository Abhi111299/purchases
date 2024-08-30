<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Activity;

class AdminActivityController extends Controller
{
    public function index()
    {
        if (!in_array('4', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'activities';
        return view('admin.activity.activities', $data);
    }

    public function get_activities(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::orderby('activity_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_activity/' . $row->activity_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->activity_status == 1) {
                        $btn .= '<a href="activity_status/' . $row->activity_id . '/' . $row->activity_status . '" class="btn btn-danger btn-sm rounded-circle" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="activity_status/' . $row->activity_id . '/' . $row->activity_status . '" class="btn btn-success btn-sm rounded-circle" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_activity(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'activity_name' => 'required',
                'activity_code' => 'required'
            ];

            $messages = [
                'activity_name.required' => 'Please Enter Activity',
                'activity_code.required' => 'Please Enter Code'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_activity = Activity::where('activity_name', $request->activity_name)->count();

                if ($check_activity > 0) {
                    return redirect()->back()->with('error', 'Activity Already Added')->withInput();
                }

                $ins['activity_name']       = $request->activity_name;
                $ins['activity_code']       = $request->activity_code;
                $ins['activity_added_on']   = date('Y-m-d H:i:s');
                $ins['activity_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['activity_updated_on'] = date('Y-m-d H:i:s');
                $ins['activity_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['activity_status']     = 1;

                $add = Activity::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Activity Added Successfully');
                }
            }
        }

        if (!in_array('4', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'add_activity';
        return view('admin.activity.add_activity', $data);
    }

    public function edit_activity(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'activity_name' => 'required',
                'activity_code' => 'required'
            ];

            $messages = [
                'activity_name.required' => 'Please Enter Activity',
                'activity_code.required' => 'Please Enter Code'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_activity = Activity::where('activity_name', $request->activity_name)->where('activity_id', '!=', $request->segment(3))->count();

                if ($check_activity > 0) {
                    return redirect()->back()->with('error', 'Activity Already Added')->withInput();
                }

                $upd['activity_name']       = $request->activity_name;
                $upd['activity_code']       = $request->activity_code;
                $upd['activity_updated_on'] = date('Y-m-d H:i:s');
                $upd['activity_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Activity::where('activity_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Activity Updated Successfully');
            }
        }

        $data['activity'] = Activity::where('activity_id', $request->segment(3))->first();

        if (!isset($data['activity'])) {
            return redirect('admin/activities');
        }

        if (!in_array('4', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'edit_activity';
        return view('admin.activity.edit_activity', $data);
    }

    public function activity_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['activity_status'] = 0;
        } else {
            $upd['activity_status'] = 1;
        }

        $where['activity_id'] = $id;

        $update = Activity::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
