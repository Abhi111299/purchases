<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vehicle;
use App\Models\Accident;

class StaffAccidentController extends Controller
{
    public function index(Request $request)
    {
        $data['vehicle'] = Vehicle::where('vehicle_id', $request->segment(3))->first();

        if (!isset($data['vehicle'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.accident.accidents', $data);
    }

    public function get_accidents(Request $request)
    {
        if ($request->ajax()) {
            $where['accident_vehicle'] = $request->vehicle_id;
            $data = Accident::where($where)->orderby('accident_id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('accident_date', function ($row) {

                    $accident_date = date('d M Y', strtotime($row->accident_date));

                    return $accident_date;
                })
                ->addColumn('accident_time', function ($row) {

                    $accident_time = date('H:i A', strtotime($row->accident_time));

                    return $accident_time;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/staff/edit_accident/' . $row->accident_id . '" class="btn btn-primary rounded-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add_accident(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'accident_date' => 'required',
                'accident_time' => 'required',
                'accident_driver' => 'required',
                'accident_location' => 'required',
                'accident_parties' => 'required',
                'accident_desc' => 'required',
                'accident_damage' => 'required'
            ];

            $messages = [
                'accident_date.required' => 'Please Select Date',
                'accident_time.required' => 'Please Select Time',
                'accident_driver.required' => 'Please Enter Driver',
                'accident_location.required' => 'Please Enter Location',
                'accident_parties.required' => 'Please Enter Involved Parties',
                'accident_desc.required' => 'Please Enter Description',
                'accident_damage.required' => 'Please Enter Damage Details'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['accident_vehicle']    = $request->segment(3);
                $ins['accident_date']       = date('Y-m-d', strtotime($request->accident_date));
                $ins['accident_time']       = date('h:i', strtotime($request->accident_time));
                $ins['accident_driver']     = $request->accident_driver;
                $ins['accident_location']   = $request->accident_location;
                $ins['accident_parties']    = $request->accident_parties;
                $ins['accident_desc']       = $request->accident_desc;
                $ins['accident_damage']     = $request->accident_damage;
                $ins['accident_notes']      = $request->accident_notes;
                $ins['accident_added_on']   = date('Y-m-d H:i:s');
                $ins['accident_added_by']   = Auth::guard('staff')->user()->staff_id;
                $ins['accident_updated_on'] = date('Y-m-d H:i:s');
                $ins['accident_updated_by'] = Auth::guard('staff')->user()->staff_id;
                $ins['accident_status']     = 1;

                $file_names = array();

                if ($request->hasFile('accident_photographs')) {
                    foreach ($request->accident_photographs as $accident_photograph) {
                        $file_path = $accident_photograph->getClientOriginalName();
                        $file_name = time() . '-' . $file_path;

                        $final_file_path = 'assets/admin/uploads/vehicle';

                        $accident_photograph->storeAs($final_file_path, $file_name);

                        $file_names[] = $file_name;
                    }

                    $ins['accident_photographs'] = json_encode($file_names);
                }

                $add = Accident::create($ins);

                if ($add) {
                    return redirect('staff/accidents/' . $request->segment(3))->with('success', 'Details Added Successfully');
                }
            }
        }

        $data['set'] = 'vehicles';
        return view('staff.accident.add_accident', $data);
    }

    public function edit_accident(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'accident_date' => 'required',
                'accident_time' => 'required',
                'accident_driver' => 'required',
                'accident_location' => 'required',
                'accident_parties' => 'required',
                'accident_desc' => 'required',
                'accident_damage' => 'required'
            ];

            $messages = [
                'accident_date.required' => 'Please Select Date',
                'accident_time.required' => 'Please Select Time',
                'accident_driver.required' => 'Please Enter Driver',
                'accident_location.required' => 'Please Enter Location',
                'accident_parties.required' => 'Please Enter Involved Parties',
                'accident_desc.required' => 'Please Enter Description',
                'accident_damage.required' => 'Please Enter Damage Details'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $accident_detail = Accident::where('accident_id', $request->segment(3))->first();

                $upd['accident_date']       = date('Y-m-d', strtotime($request->accident_date));
                $upd['accident_time']       = date('h:i', strtotime($request->accident_time));
                $upd['accident_driver']     = $request->accident_driver;
                $upd['accident_location']   = $request->accident_location;
                $upd['accident_parties']    = $request->accident_parties;
                $upd['accident_desc']       = $request->accident_desc;
                $upd['accident_damage']     = $request->accident_damage;
                $upd['accident_notes']      = $request->accident_notes;
                $upd['accident_updated_on'] = date('Y-m-d H:i:s');
                $upd['accident_updated_by'] = Auth::guard('staff')->user()->staff_id;

                if ($request->hasFile('accident_photographs')) {
                    $old_file = array();

                    if (!empty($accident_detail->accident_photographs)) {
                        $old_file = json_decode($accident_detail->accident_photographs, true);
                    }

                    foreach ($request->accident_photographs as $accident_photograph) {
                        $file_path = $accident_photograph->getClientOriginalName();
                        $file_name = time() . '-' . $file_path;

                        $final_file_path = 'assets/admin/uploads/vehicle';

                        $accident_photograph->storeAs($final_file_path, $file_name);

                        $file_names[] = $file_name;
                    }

                    $new_files = array_merge($old_file, $file_names);

                    $upd['accident_photographs'] = json_encode($new_files);
                }

                $add = Accident::where('accident_id', $request->segment(3))->update($upd);

                return redirect('staff/accidents/' . $request->vehicle_id)->with('success', 'Details Updated Successfully');
            }
        }

        $data['accident'] = Accident::where('accident_id', $request->segment(3))->first();

        if (!isset($data['accident'])) {
            return redirect('staff/vehicles');
        }

        $data['set'] = 'vehicles';
        return view('staff.accident.edit_accident', $data);
    }

    public function accident_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if ($status == 1) {
            $upd['accident_status'] = 0;
        } else {
            $upd['accident_status'] = 1;
        }

        $where['accident_id'] = $id;

        $update = Accident::where($where)->update($upd);

        if ($update) {
            return redirect()->back()->with('success', 'Status Changed Successfully');
        }
    }
}
