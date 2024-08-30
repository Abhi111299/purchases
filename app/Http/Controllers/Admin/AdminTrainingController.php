<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Training;

class AdminTrainingController extends Controller
{
    public function index()
    {
        $data['set'] = 'trainings';
        return view('admin.training.trainings', $data);
    }

    public function get_trainings(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->admin_role == 2) {
                $data = Training::where('training_added_by', Auth::guard('admin')->user()->admin_id)->orderby('training_id', 'desc')->get();
            } else {
                $data = Training::orderby('training_id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_training/' . $row->training_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->training_status == 1) {
                        $btn .= '<a href="/admin/training_status/' . $row->training_id . '/' . $row->training_status . '" class="btn rounded-circle btn-danger btn-sm" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="/admin/training_status/' . $row->training_id . '/' . $row->training_status . '" class="btn  rounded-circle btn-success btn-sm" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_training(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['training_name' => 'required'];

            $messages = ['training_name.required' => 'Please Enter Training'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_training = Training::where('training_name', $request->training_name)->count();

                if ($check_training > 0) {
                    return redirect()->back()->with('error', 'Training Already Added')->withInput();
                }

                $ins['training_name']       = $request->training_name;
                $ins['training_added_on']   = date('Y-m-d H:i:s');
                $ins['training_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['training_updated_on'] = date('Y-m-d H:i:s');
                $ins['training_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['training_status']     = 1;

                $add = Training::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Training Added Successfully');
                }
            }
        }

        $data['set'] = 'trainings';
        return view('admin.training.add_training', $data);
    }

    public function edit_training(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['training_name' => 'required'];

            $messages = ['training_name.required' => 'Please Enter Training'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $check_training = Training::where('training_name', $request->training_name)->where('training_id', '!=', $request->segment(3))->count();

                if ($check_training > 0) {
                    return redirect()->back()->with('error', 'Training Already Added')->withInput();
                }

                $upd['training_name']       = $request->training_name;
                $upd['training_updated_on'] = date('Y-m-d H:i:s');
                $upd['training_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Training::where('training_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Training Updated Successfully');
            }
        }

        $data['training'] = Training::where('training_id', $request->segment(3))->first();

        if (!isset($data['training'])) {
            return redirect('admin/trainings');
        }

        $data['set'] = 'trainings';
        return view('admin.training.edit_training', $data);
    }

    public function training_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['training_status'] = 0;
        } else {
            $upd['training_status'] = 1;
        }

        $where['training_id'] = $id;

        $update = Training::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
