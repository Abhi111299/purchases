<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use Image;
use App\Models\Activity;
use App\Models\Location;
use App\Models\Department;
use App\Models\Asset;

class AdminAssetController extends Controller
{
    public function index()
    {
        if (!in_array('8', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['locations'] = Location::where('location_status', 1)->orderby('location_name', 'asc')->get();

        $data['set'] = 'assets';
        return view('admin.asset.assets', $data);
    }

    public function get_assets(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->condition)) {
                $where['asset_condition'] = $request->condition;
            }

            if (!empty($request->location)) {
                $where['asset_location'] = $request->location;
            }

            if (!empty($request->calibration)) {
                $where['asset_crequired'] = $request->calibration;
            }

            $where['asset_trash'] = 1;
            $data = Asset::getDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('asset_name', function ($row) {
                    $asset_name = ucfirst($row->asset_name);
                    if (in_array('10', Request()->modules)) {
                        $asset_name = '<a href="view_asset/' . $row->asset_id . '" title="View">' . $asset_name . '</a> ';
                    }
                    return $asset_name;
                })
                ->addColumn('asset_image', function ($row) {

                    if (!empty($row->asset_image)) {
                        $image_url = asset(config('constants.admin_path') . 'uploads/asset/' . $row->asset_image);
                    } else {
                        $image_url = asset(config('constants.admin_path') . 'dist/img/no_image.jpeg');
                    }

                    $asset_image = '<img src="' . $image_url . '" class="img-thumbnail" style="width: 100px;height: 100px;">';

                    return $asset_image;
                })
                ->addColumn('condition', function ($row) {

                    $condition = '';

                    if ($row->asset_condition == 1) {
                        $condition = 'Inservice';
                    } elseif ($row->asset_condition == 2) {
                        $condition = 'Out of service';
                    } elseif ($row->asset_condition == 3) {
                        $condition = 'Maintenance';
                    } elseif ($row->asset_condition == 4) {
                        $condition = 'Calibration out';
                    } elseif ($row->asset_condition == 5) {
                        $condition = 'Repair';
                    } elseif ($row->asset_condition == 6) {
                        $condition = 'Send for repair';
                    }

                    return $condition;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<div style="white-space:nowrap">';

                    // if (in_array('10', Request()->modules)) {
                    //     $btn .= '<a href="view_asset/' . $row->asset_id . '" class="btn btn-info btn-sm rounded-circle" title="View"><i class="fa fa-eye"></i></a> ';
                    // }

                    if (in_array('9', Request()->modules)) {
                        $btn .= '<a href="/admin/edit_asset/' . $row->asset_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';
                    }

                    // if(in_array('11',Request()->modules))
                    // {
                    //     $btn .= '<a href="delete_asset/'.$row->asset_id.'" class="btn btn-danger btn-sm rounded-circle" title="Delete" onclick="confirm_msg(event)"><i class="fa fa-trash"></i></a>';
                    // }

                    return $btn . "</div>";
                })
                ->rawColumns(['asset_name', 'action', 'asset_image'])
                ->make(true);
        }
    }

    public function add_asset(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['asset_name' => 'required'];

            $messages = ['asset_name.required' => 'Please Enter Asset'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['asset_name']              = $request->asset_name;
                $ins['asset_method']            = $request->asset_method;
                $ins['asset_location']          = $request->asset_location;
                $ins['asset_department']        = $request->asset_department;
                $ins['asset_condition']         = $request->asset_condition;
                $ins['asset_manufacture']       = $request->asset_manufacture;
                $ins['asset_model']             = $request->asset_model;
                $ins['asset_serial_no']         = $request->asset_serial_no;
                $ins['asset_crequired']         = $request->asset_crequired;
                $ins['asset_accessory_include'] = $request->asset_accessory_include;
                $ins['asset_added_on']          = date('Y-m-d H:i:s');
                $ins['asset_added_by']          = Auth::guard('admin')->user()->admin_id;
                $ins['asset_updated_on']        = date('Y-m-d H:i:s');
                $ins['asset_updated_by']        = Auth::guard('admin')->user()->admin_id;
                $ins['asset_status']            = 1;
                $ins['asset_trash']             = 1;

                if ($request->asset_crequired == 1) {
                    $ins['asset_cdate']      = date('Y-m-d', strtotime($request->asset_cdate));
                    $ins['asset_cfrequency'] = $request->asset_cfrequency;
                    $ins['asset_cdue_date']  = date('Y-m-d', strtotime($request->asset_cdue_date));

                    if ($request->hasFile('asset_manufacture_file')) {
                        $asset_manufacture_file = $request->asset_manufacture_file->store('assets/admin/uploads/asset');

                        $asset_manufacture_file = explode('/', $asset_manufacture_file);
                        $asset_manufacture_file = end($asset_manufacture_file);
                        $ins['asset_manufacture_file'] = $asset_manufacture_file;
                    }
                } else {
                    $ins['asset_cdate']      = NULL;
                    $ins['asset_cfrequency'] = NULL;
                    $ins['asset_cdue_date']  = NULL;
                    $ins['asset_manufacture_file'] = NULL;
                }

                if ($request->asset_accessory_include == 1) {
                    $ins['asset_accessory_details'] = json_encode($request->accessory);
                } else {
                    $ins['asset_accessory_details'] = NULL;
                }

                if ($request->hasFile('asset_packing_file')) {
                    $asset_packing_file = $request->asset_packing_file->store('assets/admin/uploads/asset');

                    $asset_packing_file = explode('/', $asset_packing_file);
                    $asset_packing_file = end($asset_packing_file);
                    $ins['asset_packing_file'] = $asset_packing_file;
                }

                if ($request->hasFile('asset_manual_file')) {
                    $asset_manual_file = $request->asset_manual_file->store('assets/admin/uploads/asset');

                    $asset_manual_file = explode('/', $asset_manual_file);
                    $asset_manual_file = end($asset_manual_file);
                    $ins['asset_manual_file'] = $asset_manual_file;
                }

                if ($request->hasFile('asset_supporting_file')) {
                    $asset_supporting_file = $request->asset_supporting_file->store('assets/admin/uploads/asset');

                    $asset_supporting_file = explode('/', $asset_supporting_file);
                    $asset_supporting_file = end($asset_supporting_file);
                    $ins['asset_supporting_file'] = $asset_supporting_file;
                }

                $photographs_file_names = array();

                if ($request->hasFile('asset_photographs_file')) {
                    foreach ($request->asset_photographs_file as $photographs_file) {
                        $file_path = $photographs_file->getClientOriginalName();
                        $photographs_file_name = time() . '-' . $file_path;

                        $destinationPath = public_path(config('constants.admin_path') . 'uploads/asset');
                        $img = Image::make($photographs_file->getRealPath());
                        $img->resize(300, 300, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($destinationPath . '/' . $photographs_file_name);

                        $photographs_file_names[] = $photographs_file_name;
                    }

                    $ins['asset_photographs_file'] = json_encode($photographs_file_names);
                }

                if ($request->hasFile('asset_image')) {
                    $asset_image = $request->asset_image;

                    $afile_path = $asset_image->getClientOriginalName();
                    $asset_file_name = time() . '-' . $afile_path;

                    $adestinationPath = public_path(config('constants.admin_path') . 'uploads/asset');
                    $aimg = Image::make($asset_image->getRealPath());
                    $aimg->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($adestinationPath . '/' . $asset_file_name);

                    $ins['asset_image'] = $asset_file_name;
                }

                $add = Asset::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Asset Added Successfully');
                }
            }
        }

        if (!in_array('7', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['activities']  = Activity::where('activity_status', 1)->orderby('activity_name', 'asc')->get();
        $data['locations']   = Location::where('location_status', 1)->orderby('location_name', 'asc')->get();
        $data['departments'] = Department::where('department_status', 1)->orderby('department_name', 'asc')->get();

        $data['set'] = 'add_asset';
        return view('admin.asset.add_asset', $data);
    }

    public function select_due_date(Request $request)
    {
        $due_date = date('d-m-Y', strtotime("+" . $request->calibration_frequency . " months", strtotime($request->calibration_date)));

        echo $due_date;
    }

    public function edit_asset(Request $request)
    {
        if ($request->has('submit')) {
            $rules = ['asset_name' => 'required'];

            $messages = ['asset_name.required' => 'Please Enter Asset'];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $asset = Asset::where('asset_id', $request->segment(3))->first();

                $upd['asset_name']              = $request->asset_name;
                $upd['asset_method']            = $request->asset_method;
                $upd['asset_location']          = $request->asset_location;
                $upd['asset_department']        = $request->asset_department;
                $upd['asset_condition']         = $request->asset_condition;
                $upd['asset_manufacture']       = $request->asset_manufacture;
                $upd['asset_model']             = $request->asset_model;
                $upd['asset_serial_no']         = $request->asset_serial_no;
                $upd['asset_crequired']         = $request->asset_crequired;
                $upd['asset_accessory_include'] = $request->asset_accessory_include;
                $upd['asset_updated_on']        = date('Y-m-d H:i:s');
                $upd['asset_updated_by']        = Auth::guard('admin')->user()->admin_id;

                if ($request->asset_crequired == 1) {
                    $upd['asset_cdate']      = date('Y-m-d', strtotime($request->asset_cdate));
                    $upd['asset_cfrequency'] = $request->asset_cfrequency;
                    $upd['asset_cdue_date']  = date('Y-m-d', strtotime($request->asset_cdue_date));

                    if ($request->hasFile('asset_manufacture_file')) {
                        $asset_manufacture_file = $request->asset_manufacture_file->store('assets/admin/uploads/asset');

                        $asset_manufacture_file = explode('/', $asset_manufacture_file);
                        $asset_manufacture_file = end($asset_manufacture_file);
                        $upd['asset_manufacture_file'] = $asset_manufacture_file;
                    }
                } else {
                    $upd['asset_cdate']      = NULL;
                    $upd['asset_cfrequency'] = NULL;
                    $upd['asset_cdue_date']  = NULL;
                    $upd['asset_manufacture_file'] = NULL;
                }

                if ($request->asset_accessory_include == 1) {
                    $upd['asset_accessory_details'] = json_encode($request->accessory);
                } else {
                    $upd['asset_accessory_details'] = NULL;
                }

                if ($request->hasFile('asset_packing_file')) {
                    $asset_packing_file = $request->asset_packing_file->store('assets/admin/uploads/asset');

                    $asset_packing_file = explode('/', $asset_packing_file);
                    $asset_packing_file = end($asset_packing_file);
                    $upd['asset_packing_file'] = $asset_packing_file;
                }

                if ($request->hasFile('asset_manual_file')) {
                    $asset_manual_file = $request->asset_manual_file->store('assets/admin/uploads/asset');

                    $asset_manual_file = explode('/', $asset_manual_file);
                    $asset_manual_file = end($asset_manual_file);
                    $upd['asset_manual_file'] = $asset_manual_file;
                }

                if ($request->hasFile('asset_supporting_file')) {
                    $asset_supporting_file = $request->asset_supporting_file->store('assets/admin/uploads/asset');

                    $asset_supporting_file = explode('/', $asset_supporting_file);
                    $asset_supporting_file = end($asset_supporting_file);
                    $upd['asset_supporting_file'] = $asset_supporting_file;
                }

                if ($request->hasFile('asset_photographs_file')) {
                    $old_file = array();

                    if (!empty($asset->asset_photographs_file)) {
                        $old_file = json_decode($asset->asset_photographs_file, true);
                    }

                    foreach ($request->asset_photographs_file as $photographs_file) {
                        $file_path = $photographs_file->getClientOriginalName();
                        $photographs_file_name = time() . '-' . $file_path;

                        $destinationPath = public_path(config('constants.admin_path') . 'uploads/asset');
                        $img = Image::make($photographs_file->getRealPath());
                        $img->resize(300, 300, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($destinationPath . '/' . $photographs_file_name);

                        $photographs_file_names[] = $photographs_file_name;
                    }

                    $new_files = array_merge($old_file, $photographs_file_names);

                    $upd['asset_photographs_file'] = json_encode($new_files);
                }

                if ($request->hasFile('asset_image')) {
                    $asset_image = $request->asset_image;

                    $afile_path = $asset_image->getClientOriginalName();
                    $asset_file_name = time() . '-' . $afile_path;

                    $adestinationPath = public_path(config('constants.admin_path') . 'uploads/asset');
                    $aimg = Image::make($asset_image->getRealPath());
                    $aimg->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($adestinationPath . '/' . $asset_file_name);

                    $upd['asset_image'] = $asset_file_name;
                }

                $add = Asset::where('asset_id', $request->segment(3))->update($upd);

                return redirect()->back()->with('success', 'Asset Updated Successfully');
            }
        }

        $data['asset'] = Asset::where('asset_id', $request->segment(3))->first();

        if (!isset($data['asset'])) {
            return redirect('admin/assets');
        }

        if (!in_array('9', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['activities']  = Activity::where('activity_status', 1)->orderby('activity_name', 'asc')->get();
        $data['locations']   = Location::where('location_status', 1)->orderby('location_name', 'asc')->get();
        $data['departments'] = Department::where('department_status', 1)->orderby('department_name', 'asc')->get();

        $data['set'] = 'assets';
        return view('admin.asset.edit_asset', $data);
    }

    public function view_asset(Request $request)
    {
        $where['asset_id'] = $request->segment(3);
        $data['asset'] = Asset::getDetail($where);

        if (!isset($data['asset'])) {
            return redirect('admin/assets');
        }

        if (!in_array('10', Request()->modules)) {
            return redirect('admin/dashboard');
        }

        $data['set'] = 'assets';
        return view('admin.asset.view_asset', $data);
    }

    public function delete_asset(Request $request)
    {
        Asset::where('asset_id', $request->segment(3))->delete();

        return redirect()->back()->with('success', 'Asset Deleted Successfully');
    }
}
