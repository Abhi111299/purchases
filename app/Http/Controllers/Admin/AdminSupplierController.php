<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Location;
use App\Models\Staff;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use Validator;
use Auth;
use Mail;
use DataTables;

class AdminSupplierController extends Controller
{

    public function index()
    {
        if (!in_array('8', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['Supplier'] = Supplier::orderby('id', 'asc')->get();
        // dd($data['Supplier']);
        $data['set'] = 'supplier';
        return view('admin.supplier.supplier', $data);
    }

    public function supplier_list()
    {
        if (!in_array('8', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['suppliers'] = Supplier::orderby('id', 'asc')->get();
        $data['set'] = 'supplier';
        return $data;
    }



    public function add_supplier(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'supplier_name' => 'required',
                'phone' => 'required',
                'post_code' => 'required',
                'email' => 'required',
            ];

            $messages = [
                'supplier_name.required' => 'Please enter supplier name',
                'phone.required' => 'Please enter phone number',
                'post_code.required' => 'Please enter postal code',
                'email.required' => 'Please enter email.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['supplier_name']      = $request->supplier_name;
                $ins['phone']           = $request->phone;
                $ins['address']           = $request->address;
                $ins['post_code']          = $request->post_code;
                $ins['email']           =       $request->email;
                $ins['county']     =   $request->county;
                $ins['state']   =     $request->state;
                $ins['created_at'] = Carbon::now();
                $ins['updated_at'] = Carbon::now();
                $add = Supplier::create($ins);
                if ($add) {
                    return redirect()->back()->with('success', 'Supplier Added Successfully');
                }
            }
        }

        $data['set'] = 'add_supplier';
        return view('admin.supplier.add_supplier');
    }

    public function supplier_details(Request $request, $id){
        $supplier = Supplier::find($id);// dd($supplier);

        if ($supplier) {
            return response()->json([
                'success' => true,
                'supplier' => $supplier
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found'
            ]);
        }
    }

    public function get_supplier_list(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Supplier::query()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('supplier_name', function ($row) {
                    $supplier_name = ucfirst($row->supplier_name);
                    
                    return $supplier_name;
                })
                 ->addIndexColumn()
                ->addColumn('email', function ($row) {
                    $email = ucfirst($row->email);
                    return $email;
                })
                
                
                ->addColumn('action', function ($row) {

                    $btn = '<div style="white-space:nowrap">';

                    if (in_array('9', Request()->modules)) {
                        $btn .= '<a href="/admin/edit_supplier/' . $row->id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';
                    }

                    if(in_array('11',Request()->modules))
                    {
                        $btn .= '<a href="/admin/delete_supplier/'.$row->id .'" class="btn btn-danger btn-sm rounded-circle" title="Delete" onclick="confirm_msg(event)"><i class="fa fa-trash"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['supplier_name', 'action'])
                ->make(true);
        }
    }

    public function edit_supplier(Request $request, $id)
    {
        if ($request->has('submit')) {
            $rules = [
                'supplier_name' => 'required',
                'phone' => 'required',
                'post_code' => 'required',
                'email' => 'required',
            ];

            $messages = [
                'supplier_name.required' => 'Please enter supplier name',
                'phone.required' => 'Please enter phone number',
                'post_code.required' => 'Please enter postal code',
                'email.required' => 'Please enter email.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $supplier = Supplier::find($id);

                if (!$supplier) {
                    return redirect()->back()->withErrors(['error' => 'Record not found.'])->withInput();
                }
               
                $supplier->supplier_name      = $request->supplier_name;
                $supplier->phone       = $request->phone;
                $supplier->state   = $request->state;
                $supplier->county           = $request->county;
                $supplier->post_code         =  $request->post_code;
                $supplier->email          = $request->email;
                $supplier->address   =     $request->address;
                $supplier->updated_at = Carbon::now();
                $updateSupplier = $supplier->save();
                if ($updateSupplier) {                

                    return redirect()->back()->with('success', 'Supplier Updated Successfully');
                }

                return redirect()->back()->with('success', 'Supplier Updated Successfully');
            }
        }

        $data['supplier'] = Supplier::where('id', $id)->first();
        
        


        $data['set'] = 'supplier';

        return view('admin.supplier.edit_supplier', $data);

    }

    public function destroy($id)
    {
        // Find the resource by its ID
        $resource = Supplier::find($id);

        // Check if the resource exists
        if ($resource) {
            // Delete the resource
            $resource->delete();

            // Redirect or return a response
            return redirect()->back()->with('success', 'Supplier Deleted Successfully');
        }

        // If resource not found, handle it
        return Redirect::route('resource.index')->with('error', 'Resource not found.');
    }
}
