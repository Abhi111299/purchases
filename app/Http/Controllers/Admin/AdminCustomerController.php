<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Customer;

class AdminCustomerController extends Controller
{
    public function index()
    {
        if (!in_array('1', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'customers';
        return view('admin.customer.customers', $data);
    }

    public function get_customers(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::orderby('customer_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';
                    $btn .= '<a href="/admin/edit_customer/' . $row->customer_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';

                    if ($row->customer_status == 1) {
                        $btn .= '<a href="customer_status/' . $row->customer_id . '/' . $row->customer_status . '" class="btn btn-danger btn-sm rounded-circle" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban" style="color:white"></i></a> ';
                    } else {
                        $btn .= '<a href="customer_status/' . $row->customer_id . '/' . $row->customer_status . '" class="btn btn-success btn-sm rounded-circle" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                    }


                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_customer(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['customer_name' => 'required'];

            $messages = ['customer_name.required' => 'Please Enter Client'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                // $check_customer = Customer::where('customer_email',$request->customer_email)->count();

                // if($check_customer > 0)
                // {
                //     return redirect()->back()->with('error','Client Already Added')->withInput();
                // }

                $ins['customer_name']       = $request->customer_name;
                $ins['customer_address']    = $request->customer_address;
                $ins['customer_person']     = $request->customer_person;
                $ins['customer_email']      = $request->customer_email;
                $ins['customer_phone']      = $request->customer_phone;
                $ins['customer_comments']   = $request->customer_comments;
                $ins['customer_added_on']   = date('Y-m-d H:i:s');
                $ins['customer_added_by']   = Auth::guard('admin')->user()->admin_id;
                $ins['customer_updated_on'] = date('Y-m-d H:i:s');
                $ins['customer_updated_by'] = Auth::guard('admin')->user()->admin_id;
                $ins['customer_status']     = 1;

                $add = Customer::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Client Added Successfully');
                }
            }
        }

        if (!in_array('1', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'add_customer';
        return view('admin.customer.add_customer', $data);
    }

    public function edit_customer(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['customer_name' => 'required'];

            $messages = ['customer_name.required' => 'Please Enter Client'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                // $check_customer = Customer::where('customer_email',$request->customer_email)->where('customer_id','!=',$request->segment(3))->count();

                // if($check_customer > 0)
                // {
                //     return redirect()->back()->with('error','Client Already Added')->withInput();
                // }

                $upd['customer_name']       = $request->customer_name;
                $upd['customer_address']    = $request->customer_address;
                $upd['customer_person']     = $request->customer_person;
                $upd['customer_email']      = $request->customer_email;
                $upd['customer_phone']      = $request->customer_phone;
                $upd['customer_comments']   = $request->customer_comments;
                $upd['customer_updated_on'] = date('Y-m-d H:i:s');
                $upd['customer_updated_by'] = Auth::guard('admin')->user()->admin_id;

                $add = Customer::where('customer_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Client Updated Successfully');
            }
        }

        $data['customer'] = Customer::where('customer_id', $request->segment(3))->first();

        if (!isset($data['customer'])) {
            return redirect('admin/customers');
        }

        if (!in_array('1', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'edit_customer';
        return view('admin.customer.edit_customer', $data);
    }

    public function customer_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['customer_status'] = 0;
        } else {
            $upd['customer_status'] = 1;
        }

        $where['customer_id'] = $id;

        $update = Customer::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
