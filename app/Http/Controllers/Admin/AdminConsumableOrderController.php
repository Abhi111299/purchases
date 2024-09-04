<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DB;
use DataTables;
use App\Models\Consumabl;
use App\Models\Consumable;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;
use PDF;
use Mail;
use Illuminate\Support\Carbon;

class AdminConsumableOrderController extends Controller
{
    public function index()
    {
        $data['set'] = 'consumables';
        return view('admin.consumables_order.consumables_order', $data);
    }

    public function get_consumables(Request $request)
    {
        if ($request->ajax()) {
           
            $data = Consumabl::with('supplier')->orderby('id', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('supplier_name', function($row) {
                    return $row->supplier ? $row->supplier->supplier_name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div style="white-space:nowrap">';

                    if (in_array('9', Request()->modules)) {
                        $btn .= '<a href="/admin/edit_consumable_order/' . $row->id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';
                    }

                    if(in_array('10',Request()->modules))
                    {
                        $btn .= '<a href="/admin/delete_consumable/'.$row->id .'" class="btn btn-danger btn-sm rounded-circle" title="Delete" onclick="confirm_msg(event)"><i class="fa fa-trash"></i></a>';
                    }

                    if(in_array('11',Request()->modules))
                    {
                        $btn .= '<a href="/admin/download_consumable_pdf/' . $row->id . '" class="ml-2 btn btn-secondary rounded-circle btn-sm" title="Edit"><i class="fa fa-download"></i></a> ';
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
            $rules = [
                'supplier_name' => 'required|string|max:255',
            'supplier_address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'purchase_order_date' => 'required|date',
            'quotation_number' => 'required|string|max:50',
            'email' => 'required|string|max:255',
            'delivery_date' => 'required|date',
            'delivery_address' => 'nullable|string',
            // 'uploaded_file' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            // 'supplier.*.item' => 'required|string|max:255',
            // 'supplier.*.description' => 'nullable|string',
            // 'supplier.*.quantity' => 'required|integer|min:1',
            // 'supplier.*.cost' => 'required|numeric'
        ];

            $messages = [
                'supplier_name.required' => 'Supplier name is required.',
                'supplier_name.string' => 'Supplier name must be a string.',
                'supplier_name.max' => 'Supplier name may not be greater than 255 characters.',
                'supplier_address.required' => 'Supplier address is required.',
                'supplier_address.string' => 'Supplier address must be a string.',
                'supplier_address.max' => 'Supplier address may not be greater than 255 characters.',
                'phone.required' => 'Phone number is required.',
                'phone.string' => 'Phone number must be a string.',
                'phone.max' => 'Phone number may not be greater than 15 characters.',
                'purchase_order_date.required' => 'Purchase order date is required.',
                'purchase_order_date.date' => 'Purchase order date must be a valid date.',
                'quotation_number.required' => 'Quotation number is required.',
                'quotation_number.string' => 'Quotation number must be a string.',
                'quotation_number.max' => 'Quotation number may not be greater than 50 characters.',
                'email.required' => 'Email is required.',
                'delivery_date.required' => 'Delivery date is required.',
                'delivery_date.date' => 'Delivery date must be a valid date.',
                'delivery_address.string' => 'Delivery address must be a string.',
                // 'uploaded_file.file' => 'Uploaded file must be a file.',
                // 'uploaded_file.mimes' => 'Uploaded file must be a file of type: jpg, png, pdf.',
                // 'uploaded_file.max' => 'Uploaded file may not be greater than 2048 kilobytes.',
                
                // Messages for each item in the supplier array
                // 'supplier.*.item.required' => 'Item is required.',
                // 'supplier.*.item.string' => 'Item must be a string.',
                // 'supplier.*.item.max' => 'Item may not be greater than 255 characters.',
                // 'supplier.*.description.string' => 'Item description must be a string.',
                // 'supplier.*.quantity.required' => 'Quantity is required.',
                // 'supplier.*.quantity.integer' => 'Quantity must be an integer.',
                // 'supplier.*.quantity.min' => 'Quantity must be at least 1.',
                // 'supplier.*.cost.required' => 'Cost is required.',
                // 'supplier.*.cost.numeric' => 'Cost must be a number.',
            ];
            

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                // $check_consumable = Consumabl::where('supplier_name', $request->supplier_name)->count();

                // if ($check_consumable > 0) {
                //     return redirect()->back()->with('error', 'Consumable Already Added')->withInput();
                // }

                $filePath = null;
                    if ($request->hasFile('uploaded_file')) {
                    $file = $request->file('uploaded_file');
                    $filePath = $file->store('uploads/documents'); // Store file in 'uploads' directory
                }

                $currentDate = Carbon::now()->format('dmY');
                $lastRecord = Consumabl::latest('id')->first();
                $lastId = $lastRecord ? $lastRecord->id : 0;
                $newId = $lastId + 1;
                $purchaseOrderNumber = "PO ".$currentDate . '-' . $newId;

                $ins['supplier_name']       = $request->supplier_name;
                $ins['supplier_address']       = $request->supplier_address;
                $ins['phone']       = $request->phone;
                $ins['purchase_order_date']       = date('Y-m-d', strtotime($request->purchase_order_date));
                $ins['quotation_number']       = $request->quotation_number;
                $ins['email']       = $request->email;
                $ins['delivery_address']       = $request->delivery_address;
                $ins['subtotal']       = $request->subtotal;
                $ins['shipping']       = $request->shipping;
                $ins['total_without_gst']       = $request->total_without_gst;
                $ins['gst']       = $request->gst;
                $ins['total']       = $request->total;
                $ins['purchase_order_number']       = $purchaseOrderNumber;
                $ins['delivery_date']       = date('Y-m-d', strtotime($request->delivery_date));
                $ins['uploaded_file']   =   $filePath;
                $ins['consumable_added_by']   = Auth::guard('admin')->user()->admin_name;
                $ins['created_at'] = Carbon::now();
                $ins['updated_at'] = Carbon::now();//dd($ins);
                $add = Consumabl::create($ins);
                // dd($add);
                $consumableId = $add->id;
                $items = $request->input('consumable', []);
                foreach ($items as $item) {
                    DB::table('consumable_items')->insert([
                        'consumable_id' => $consumableId,
                        'item' => $item['item'],
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'cost' => $item['cost'],
                        'total_per_item' => $item['total_per_item']
                    ]);
                }

                $itemsWithNames = [];
                foreach ($items as $item) {
                    $itemDetails = Consumable::find($item['item']);
                    $itemsWithNames[] = [
                        'item' => $itemDetails ? $itemDetails->consumable_name : 'N/A', // Replace 'name' with the actual column for item names
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'cost' => $item['cost'],
                    ];
                }

                $supplier = Supplier::find($request->supplier_name);

                $pdf = PDF::loadView('pdf_templates.purchase_order', [
                    'supplier_name' => $supplier ? $supplier->supplier_name : 'N/A',
                    'supplier_address' => $request->supplier_address,
                    'phone' => $request->phone,
                    'purchase_order_date' => date('Y-m-d', strtotime($request->purchase_order_date)),
                    'quotation_number' => $request->quotation_number,
                    'email' => $request->email,
                    'delivery_address' => $request->delivery_address,
                    'subtotal' => $request->subtotal,
                    'shipping' => $request->shipping,
                    'total_without_gst' => $request->total_without_gst,
                    'gst' => $request->gst,
                    'total' => $request->total,
                    'purchase_order_number' => $purchaseOrderNumber,
                    'delivery_date' => date('Y-m-d', strtotime($request->delivery_date)),
                    'items' => $itemsWithNames, // Passing items array to the view
                    'consumables' =>  $request->input('consumable', [])
                ]);
    
                // Save the PDF to the desired path
                $pdfFilePath = storage_path('app/public/purchase_orders/' . $purchaseOrderNumber . '.pdf');
                $pdf->save($pdfFilePath);

                $emailData = [
                    'username' => $request->supplier_name, // Pass any other dynamic data you need
                    'purchase_order' => $request->purchase_order_number,
                    'purchase_order_date' => $request->purchase_order_date
                ];

                $mail  = $request->email;
                $uname = $request->supplier_name;

                $subject = 'New Consumable Request';

                $send = Mail::send('admin.mail.purchase_order', $emailData, function ($message) use ($mail, $uname, $subject, $pdfFilePath) {
                    $message->to($mail, $uname)->subject($subject);
                    $message->from(config('constants.mail_from'), config('constants.site_title'));
                    $message->attach($pdfFilePath, [
                        'as' => 'PurchaseOrder.pdf',
                        'mime' => 'application/pdf',
                    ]);
                });

                if ($add) {
                    return redirect()->back()->with('success', 'Consumable Added Successfully');
                }
            }
        }

        $data['set'] = 'consumables';
        return view('admin.consumables_order.add_consumables', $data);
    }

    public function edit_consumable(Request $request, $id)
    {
        if ($request->has('submit')) {
            $rules = [
                'supplier_name' => 'required|string|max:255',
                'supplier_address' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'purchase_order_date' => 'required|date',
                'quotation_number' => 'required|string|max:50',
                'email' => 'required|string|max:255',
                'delivery_date' => 'required|date',
                'delivery_address' => 'nullable|string',
                'supplier.*.item' => 'required|string|max:255',
                'supplier.*.description' => 'nullable|string',
                'supplier.*.quantity' => 'required|integer|min:1',
                'supplier.*.cost' => 'required|numeric',
            ];
    
            $messages = [
                'supplier_name.required' => 'Supplier name is required.',
                'supplier_name.string' => 'Supplier name must be a string.',
                'supplier_name.max' => 'Supplier name may not be greater than 255 characters.',
                'supplier_address.required' => 'Supplier address is required.',
                'supplier_address.string' => 'Supplier address must be a string.',
                'supplier_address.max' => 'Supplier address may not be greater than 255 characters.',
                'phone.required' => 'Phone number is required.',
                'phone.string' => 'Phone number must be a string.',
                'phone.max' => 'Phone number may not be greater than 15 characters.',
                'purchase_order_date.required' => 'Purchase order date is required.',
                'purchase_order_date.date' => 'Purchase order date must be a valid date.',
                'quotation_number.required' => 'Quotation number is required.',
                'quotation_number.string' => 'Quotation number must be a string.',
                'quotation_number.max' => 'Quotation number may not be greater than 50 characters.',
                'email.required' => 'Email is required.',
                'delivery_date.required' => 'Delivery date is required.',
                'delivery_date.date' => 'Delivery date must be a valid date.',
                'delivery_address.string' => 'Delivery address must be a string.',
                'supplier.*.item.required' => 'Item is required.',
                'supplier.*.item.string' => 'Item must be a string.',
                'supplier.*.item.max' => 'Item may not be greater than 255 characters.',
                'supplier.*.description.string' => 'Item description must be a string.',
                'supplier.*.quantity.required' => 'Quantity is required.',
                'supplier.*.quantity.integer' => 'Quantity must be an integer.',
                'supplier.*.quantity.min' => 'Quantity must be at least 1.',
                'supplier.*.cost.required' => 'Cost is required.',
                'supplier.*.cost.numeric' => 'Cost must be a number.',
            ];
    
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $consumable = Consumabl::find($id);
    
                if (!$consumable) {
                    return redirect()->back()->withErrors(['error' => 'Record not found.'])->withInput();
                }
    
                $consumable->supplier_name = $request->supplier_name;
                $consumable->supplier_address = $request->supplier_address;
                $consumable->phone = $request->phone;
                $consumable->purchase_order_date = date('Y-m-d', strtotime($request->purchase_order_date));
                $consumable->quotation_number = $request->quotation_number;
                $consumable->email = $request->email;
                $consumable->delivery_address = $request->delivery_address;
                $consumable->subtotal = $request->subtotal;
                $consumable->shipping = $request->shipping;
                $consumable->total_without_gst = $request->total_without_gst;
                $consumable->gst = $request->gst;
                $consumable->total = $request->total;
                $consumable->delivery_date = date('Y-m-d', strtotime($request->delivery_date));
    
                if ($request->hasFile('uploaded_file')) {
                    $file = $request->file('uploaded_file');
                    $filePath = $file->store('uploads', 'public');
                    $consumable->uploaded_file = $filePath;
                }
    
                $consumable->updated_at = Carbon::now();
                $consumable->save();

                $purchaseOrderNumber = $consumable->purchase_order_number;
                $pdfFilePath = storage_path('app/public/purchase_orders/' . $purchaseOrderNumber . '.pdf');
                
                if (Storage::exists($pdfFilePath)) {
                    Storage::delete($pdfFilePath);
                }
                DB::table('consumable_items')->where('consumable_id', $id)->delete();
    
                $items = $request->input('supplier', []);
                foreach ($items as $item) {
                    DB::table('consumable_items')->insert([
                        'consumable_id' => $id,
                        'item' => $item['item'],
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'cost' => $item['cost'],
                    ]);
                }

                $pdf = PDF::loadView('pdf_templates.purchase_order', [
                    'supplier_name' => $request->supplier_name,
                    'supplier_address' => $request->supplier_address,
                    'phone' => $request->phone,
                    'purchase_order_date' => date('Y-m-d', strtotime($request->purchase_order_date)),
                    'quotation_number' => $request->quotation_number,
                    'email' => $request->email,
                    'delivery_address' => $request->delivery_address,
                    'subtotal' => $request->subtotal,
                    'shipping' => $request->shipping,
                    'total_without_gst' => $request->total_without_gst,
                    'gst' => $request->gst,
                    'total' => $request->total,
                    'purchase_order_number' => $purchaseOrderNumber,
                    'delivery_date' => date('Y-m-d', strtotime($request->delivery_date)),
                    'items' => $items, // Passing items array to the view
                    'consumables' =>  $request->input('supplier', [])
                ]);
    
                // Save the PDF to the desired path
                $pdfFilePath = storage_path('app/public/purchase_orders/' . $purchaseOrderNumber . '.pdf');
                $pdf->save($pdfFilePath);

                $emailData = [
                    'username' => $request->supplier_name, // Pass any other dynamic data you need
                    'purchase_order' => $request->purchase_order_number,
                    'purchase_order_date' => $request->purchase_order_date
                ];

                $mail  = $request->email;
                $uname = $request->supplier_name;

                $subject = 'Consumable Update Request';

                $send = Mail::send('admin.mail.purchase_order', $emailData, function ($message) use ($mail, $uname, $subject, $pdfFilePath) {
                    $message->to($mail, $uname)->subject($subject);
                    $message->from(config('constants.mail_from'), config('constants.site_title'));
                    $message->attach($pdfFilePath, [
                        'as' => 'PurchaseOrder.pdf',
                        'mime' => 'application/pdf',
                    ]);
                });
    
                return redirect()->back()->with('success', 'Consumable Updated Successfully');
            }
        }
    
        // Fetch consumable and available items for view
        $data['consumable'] = Consumabl::with('items')->where('id', $id)->first();
        if (!isset($data['consumable'])) {
            return redirect('admin/consumables');
        }
    
        $data['items'] = $data['consumable']->items; // Assuming you want all items for the dropdown
        $data['set'] = 'consumables';
        return view('admin.consumables.edit_consumable', $data);
    }

    public function destroy($id)
    {
        $resource = Consumabl::find($id);
        $purchaseOrderNumber = $resource->purchase_order_number;
                $pdfFilePath = storage_path('app/public/purchase_orders/' . $purchaseOrderNumber . '.pdf');
                
                if (Storage::exists($pdfFilePath)) {
                    Storage::delete($pdfFilePath);
                }
        if ($resource) {
            $resource->delete();

            return redirect()->back()->with('success', 'Consumable Deleted Successfully');
        }

        return Redirect::route('resource.index')->with('error', 'Resource not found.');
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

        $update = Consumabl::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }

    public function downloadPDF($id)
    {
        $consumable = Consumabl::find($id);

        if (!$consumable) {
            return response()->json(['message' => 'Consumable not found'], 404);
        }
        $purchaseOrderNumber = $consumable->purchase_order_number;
        $pdfFilePath = storage_path('app/public/purchase_orders/' . $purchaseOrderNumber . '.pdf');

        if (!file_exists($pdfFilePath)) {
            return response()->json(['message' => 'PDF not found'], 404);
        }

        return response()->download($pdfFilePath, $purchaseOrderNumber . '.pdf');
    }
}
