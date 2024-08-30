<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Location;
use App\Models\Staff;
use App\Models\PurchaseRequest;
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

        $data['PurchaseRequest'] = PurchaseRequest::orderby('id', 'asc')->get();
        // dd($data['PurchaseRequest']);
        $data['set'] = 'purchase_request';
        return view('admin.supplier.supplier', $data);
    }

    public function add_supplier(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'item_name' => 'required',
                'request_date' => 'required',
                'unit' => 'required',
                'price' => 'required',
                'request_to_approval' => 'required'
            ];

            $messages = [
                'item_name.required' => 'Please select Item name',
                'request_date.required' => 'Please select purchase request date',
                'unit.required' => 'Please enter unit',
                'price.required' => 'Please enter price',
                'request_to_approval.required' => 'Please select manager.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $currentDate = Carbon::now()->format('dmY');
                $lastRecord = PurchaseRequest::latest('id')->first();
                $lastId = $lastRecord ? $lastRecord->id : 0;
                $newId = $lastId + 1;
                $requestNumber = $currentDate . '-' . $newId;
                $ins['item_name']      = $request->item_name;
                $ins['staff_id']       = Auth::guard('admin')->user()->admin_id;
                $ins['request_date']   = date('Y-m-d', strtotime($request->request_date));
                $ins['unit']           = $request->unit;
                $ins['price']          = $request->price;
                $ins['request_number'] = $requestNumber;
                $ins['request_to_approval']     = $requestToApproval = is_array($request->request_to_approval) ? implode(',', $request->request_to_approval) : $request->request_to_approval;
                
                $ins['item_description']   =     $request->description;
                $ins['created_at'] = Carbon::now();
                $ins['updated_at'] = Carbon::now();
                $add = PurchaseRequest::create($ins);
                if ($add) {
                    if (is_string($requestToApproval)) {
                        $requestToApproval = explode(',', $requestToApproval);
                    } elseif (!is_array($requestToApproval)) {
                        $requestToApproval = [];
                    }
                    
                    $get_staffs = Staff::whereIn('staff_id', $requestToApproval)->get(); // dd($get_staffs, $requestToApproval);  
                        foreach ($get_staffs as $get_staff) {
                            $emailData = [
                                'staff_id'       => $newId,
                                'manager_username' => $get_staff->staff_fname . ' ' . $get_staff->staff_lname,
                                'username' => Auth::guard('admin')->user()->admin_name, // Pass any other dynamic data you need
                                'item_name'      => $request->item_name,
                                'request_date'   => date('Y-m-d', strtotime($request->request_date)),
                                'unit'           => $request->unit,
                                'price'          => $request->price,
                                'request_number' => $requestNumber
                            ];

                            $mail  = $get_staff->staff_email;
                            $uname = $get_staff->staff_fname . ' ' . $get_staff->staff_lname;

                            $subject = 'New Purchase Request';

                            $send = Mail::send('admin.mail.apply_purchase_request', $emailData, function ($message) use ($mail, $uname, $subject) {
                                $message->to($mail, $uname)->subject($subject);
                                $message->from(config('constants.mail_from'), config('constants.site_title'));
                            });
                            // dd($send, $mail, $uname, $data['staff_id']);
                        }
                    

                    return redirect()->back()->with('success', 'Purchase Request Added Successfully');
                }
            }
        }

        $where_staff['staff_role'] = 1;
        $where_staff['staff_status'] = 1;
        $data['staffs'] = Staff::where($where_staff)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'add_supplier';
        return view('admin.supplier.add_supplier', $data);
    }

    public function get_purchase_request(Request $request)
    {
        if ($request->ajax()) {
            
            $data = PurchaseRequest::getDetails();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('item_name', function ($row) {
                    $item_name = ucfirst($row->item_name);
                    
                    return $item_name;
                })
                 ->addIndexColumn()
                ->addColumn('item_description', function ($row) {
                    $item_description = ucfirst($row->item_description);
                    return $item_description;
                })
                
                
                ->addColumn('action', function ($row) {

                    $btn = '<div style="white-space:nowrap">';

                    // if (in_array('10', Request()->modules)) {
                    //     $btn .= '<a href="view_asset/' . $row->asset_id . '" class="btn btn-info btn-sm rounded-circle" title="View"><i class="fa fa-eye"></i></a> ';
                    // }

                    if (in_array('9', Request()->modules)) {
                        $btn .= '<a href="/admin/edit_purchase_request/' . $row->id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';
                    }

                    if(in_array('11',Request()->modules))
                    {
                        $btn .= '<a href="/admin/delete_purchase_request/'.$row->id .'" class="btn btn-danger btn-sm rounded-circle" title="Delete" onclick="confirm_msg(event)"><i class="fa fa-trash"></i></a>';
                    }

                    return $btn . "</div>";
                })
                ->rawColumns(['item_name', 'action'])
                ->make(true);
        }
    }

    // public function updatePurchaseRequestStatus($id, $status)
    // {
    //     // Validate status
    //     $validStatuses = ['Approved', 'Rejected'];
    //     if (!in_array($status, $validStatuses)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid status'
    //         ], 400);
    //     }

    //     // Find the purchase request by ID
    //     $purchaseRequest = PurchaseRequest::find($id);

    //     if (!$purchaseRequest) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Purchase request not found'
    //         ], 404);
    //     }

    //     // Update the status
    //     $purchaseRequest->status = $status;
    //     $purchaseRequest->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Status updated successfully',
    //         'data' => $purchaseRequest
    //     ]);
    // }

    public function edit_purchase_request(Request $request, $id)
    {
        if ($request->has('submit')) {
            $rules = [
                'item_name' => 'required',
                'request_date' => 'required',
                'unit' => 'required',
                'price' => 'required',
                'request_to_approval' => 'required'
            ];

            $messages = [
                'item_name.required' => 'Please select Item name',
                'request_date.required' => 'Please select purchase request date',
                'unit.required' => 'Please enter unit',
                'price.required' => 'Please enter price',
                'request_to_approval.required' => 'Please select manager.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $purchaseRequest = PurchaseRequest::find($id);

                if (!$purchaseRequest) {
                    return redirect()->back()->withErrors(['error' => 'Record not found.'])->withInput();
                }
               
                $purchaseRequest->item_name      = $request->item_name;
                $purchaseRequest->staff_id       = Auth::guard('admin')->user()->admin_id;
                $purchaseRequest->request_date   = date('Y-m-d', strtotime($request->request_date));
                $purchaseRequest->unit           = $request->unit;
                $purchaseRequest->status         = "Requested";
                $purchaseRequest->price          = $request->price;
                $purchaseRequest->request_to_approval     = $requestToApproval = is_array($request->request_to_approval) ? implode(',', $request->request_to_approval) : $request->request_to_approval;
                $purchaseRequest->item_description   =     $request->description;
                $purchaseRequest->updated_at = Carbon::now();
                $updatePurchaseRequest = $purchaseRequest->save();
                if ($updatePurchaseRequest) {
                    if (is_string($requestToApproval)) {
                        $requestToApproval = explode(',', $requestToApproval);
                    } elseif (!is_array($requestToApproval)) {
                        $requestToApproval = [];
                    }
                    
                    $get_staffs = Staff::whereIn('staff_id', $requestToApproval)->get(); // dd($get_staffs, $requestToApproval);  
                        foreach ($get_staffs as $get_staff) {
                            $emailData = [
                                'staff_id'       => $id,
                                'manager_username' => $get_staff->staff_fname . ' ' . $get_staff->staff_lname,
                                'username' => Auth::guard('admin')->user()->admin_name, // Pass any other dynamic data you need
                                'item_name'      => $request->item_name,
                                'request_date'   => date('Y-m-d', strtotime($request->request_date)),
                                'unit'           => $request->unit,
                                'price'          => $request->price,
                                'request_number' => $request->request_number,
                            ];

                            $mail  = $get_staff->staff_email;
                            $uname = $get_staff->staff_fname . ' ' . $get_staff->staff_lname;

                            $subject = 'New Purchase Request';

                            $send = Mail::send('admin.mail.apply_purchase_request', $emailData, function ($message) use ($mail, $uname, $subject) {
                                $message->to($mail, $uname)->subject($subject);
                                $message->from(config('constants.mail_from'), config('constants.site_title'));
                            });
                            // dd($send, $mail, $uname, $data['staff_id']);
                        }
                    

                    return redirect()->back()->with('success', 'Purchase Request Added Successfully');
                }

                return redirect()->back()->with('success', 'Purchase Request Updated Successfully');
            }
        }

        $data['purchase_request'] = PurchaseRequest::where('id', $id)->first();
        
        if ($data['purchase_request']) {
            $data['requested_staffs'] = array_column($data['purchase_request']->toArray(), 'request_to_approval');
        } else {
            $data['requested_staffs'] = [];
        }
        $where_staff['staff_role'] = 1;
        $where_staff['staff_status'] = 1;

        $data['staffs'] = Staff::where($where_staff)->orderby('staff_fname', 'asc')->get();

        $data['set'] = 'purchase_request';

        return view('admin.purchase.edit_purchase_request', $data);

    }

    public function destroy($id)
    {
        // Find the resource by its ID
        $resource = PurchaseRequest::find($id);

        // Check if the resource exists
        if ($resource) {
            // Delete the resource
            $resource->delete();

            // Redirect or return a response
            return redirect()->back()->with('success', 'Purchase Request Deleted Successfully');
        }

        // If resource not found, handle it
        return Redirect::route('resource.index')->with('error', 'Resource not found.');
    }
}
