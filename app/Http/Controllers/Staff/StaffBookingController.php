<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;
use Mail;
use Excel;
use Auth;
use Validator;
use DataTables;
use App\Exports\BookingExport;
use App\Models\WorkingHour;
use App\Models\BookingStaff;
use App\Models\Equipment;
use App\Models\Consumable;
use App\Models\Service;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Location;
use App\Models\Booking;

class StaffBookingController extends Controller
{
    public function index()
    {
        $where_location['location_status'] = 1;
        $data['locations'] = Location::where($where_location)->orderby('location_name')->get();

        $data['set'] = 'bookings';
        return view('staff.booking.bookings', $data);
    }

    public function get_bookings(Request $request)
    {
        if ($request->ajax()) {
            $where = 'booking_trash = 1';

            $where .= ' AND bstaff_status = 2';

            $where .= ' AND bstaff_staff = ' . Auth::guard('staff')->user()->staff_id;

            if (!empty($request->start_date)) {
                $where .= ' AND booking_start >= "' . date('Y-m-d 00:00:00', strtotime($request->start_date)) . '"';
            }

            if (!empty($request->end_date)) {
                $where .= ' AND booking_end <= "' . date('Y-m-d 23:59:59', strtotime($request->end_date)) . '"';
            }

            if (!empty($request->branch)) {
                $where .= ' AND booking_branch = "' . $request->branch . '"';
            }

            $data = Booking::getStaffWhereDetails($where);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('booking_job_id', function ($row) {

                    $booking_job = "<a href='view_booking/$row->booking_id'>$row->booking_job_id</a>";

                    return $booking_job;
                })
                ->addColumn('booking_start', function ($row) {

                    $booking_start = date('d M Y h:i A', strtotime($row->booking_start));

                    return $booking_start;
                })
                ->addColumn('booking_end', function ($row) {

                    $booking_end = date('d M Y h:i A', strtotime($row->booking_end));

                    return $booking_end;
                })
                ->addColumn('activities', function ($row) {

                    $activity_arr = json_decode($row->booking_activities, true);

                    $get_activities = Activity::whereIn('activity_id', $activity_arr)->get();

                    $activities = array_column($get_activities->toArray(), 'activity_name');
                    $activities = implode(',', $activities);

                    return $activities;
                })
                ->addColumn('technicians', function ($row) {

                    $booking_staffs = BookingStaff::where('bstaff_booking', $row->booking_id)->join('staffs', 'staffs.staff_id', 'booking_staffs.bstaff_staff')->get();

                    $staffs = array();

                    if ($booking_staffs->count() > 0) {
                        foreach ($booking_staffs as $booking_staff) {
                            if ($booking_staff->bstaff_status == 1) {
                                $status = 'Pending';
                            } elseif ($booking_staff->bstaff_status == 2) {
                                $status = 'Confirm';
                            } elseif ($booking_staff->bstaff_status == 3) {
                                $status = 'Not Confirm';
                            } elseif ($booking_staff->bstaff_status == 4) {
                                $status = 'Sick Leave';
                            } elseif ($booking_staff->bstaff_status == 5) {
                                $status = 'Annual Leave';
                            }

                            $new_staff = '<div class="d-flex align-items-center">';
                            $new_staff .= '<div><img src="' . ($booking_staff->staff_image ? asset(config("constants.admin_path") . 'uploads/profile/' . $booking_staff->staff_image) : asset(config("constants.admin_path") . "dist/img/no_image.png")) . '" style="min-width:40px;min-height:40px; width:40px; height:40px" class="img-thumbnail object-fit-cover rounded-circle">&nbsp;&nbsp;</div>';
                            $new_staff .= '<div><div  style="white-space:nowrap">' . $booking_staff->staff_fname . '&nbsp;' . $booking_staff->staff_lname . '</div> <div class="badge rounded-pill text-bg-secondary">' . $status . '</div></div></div>';
                            $staffs[] = $new_staff;
                        }
                    }

                    $staffs = implode(',<br> ', $staffs);

                    return $staffs;
                })
                ->addColumn('status', function ($row) {

                    if ($row->booking_status == 1) {
                        $status = 'Pending';
                        $status_bg = "text-bg-info";
                    } elseif ($row->booking_status == 2) {
                        $status = 'Cancelled';
                        $status_bg = "text-bg-danger";
                    } elseif ($row->booking_status == 3) {
                        $status = 'Incomplete';
                        $status_bg = "text-bg-dark";
                    } elseif ($row->booking_status == 4) {
                        $status = 'Report Pending';
                        $status_bg = "text-bg-secondary";
                    } elseif ($row->booking_status == 5) {
                        $status = 'Completed';
                        $status_bg = "text-bg-success";
                    } else {
                        $status = 'Rescheduled';
                        $status_bg = "text-bg-primary";
                    }

                    return '<span class="badge rounded-pill ' . $status_bg . '">' . $status . '</span>';
                })
                // ->addColumn('action', function($row){

                //     $btn = '<a href="view_booking/'.$row->booking_id.'" class="btn btn-primary rounded-circle btn-sm" title="View"><i class="fa fa-eye"></i></a> ';

                //     return $btn;
                // })
                ->rawColumns(['booking_job_id', 'status', 'technicians'])
                ->make(true);
        }
    }

    public function view_booking(Request $request)
    {
        $where['booking_id'] = $request->segment(3);
        $data['booking'] = Booking::getAllDetail($where);

        if (!isset($data['booking'])) {
            return redirect('staff/bookings');
        }

        $activity_arr = json_decode($data['booking']->booking_activities, true);

        $get_activities = Activity::whereIn('activity_id', $activity_arr)->get();

        $activities = array_column($get_activities->toArray(), 'activity_name');
        $data['activities'] = implode(', ', $activities);

        $booking_staffs = BookingStaff::where('bstaff_booking', $data['booking']->booking_id)->get();

        $staff_arr = array();

        if ($booking_staffs->count() > 0) {
            $staff_arr = array_column($booking_staffs->toArray(), 'bstaff_staff');
        }

        $get_staffs = Staff::whereIn('staff_id', $staff_arr)->get();

        $staffs = array_column($get_staffs->toArray(), 'staff_fname');
        $data['staffs'] = implode(', ', $staffs);

        $data['equipments'] = Equipment::where('equipment_status', 1)->orderby('equipment_name', 'asc')->get();

        $data['consumables'] = Consumable::where('consumable_status', 1)->orderby('consumable_name', 'asc')->get();

        $where_all_staff['staff_role'] = 3;
        $where_all_staff['staff_status'] = 1;
        $data['all_staffs'] = Staff::where($where_all_staff)->orderby('staff_fname', 'asc')->get();

        $data['working_hours'] = WorkingHour::join('staffs', 'staffs.staff_id', 'working_hours.wh_technician')->where('wh_booking_id', $request->segment(3))->orderby('wh_id', 'desc')->get();

        $data['set'] = 'bookings';
        return view('staff.booking.view_booking', $data);
    }

    public function update_booking_status(Request $request)
    {
        if ($request->has('submit')) {
            $upd['booking_status'] = $request->status;
            Booking::where('booking_id', $request->segment(3))->update($upd);

            if ($request->status == 1) {
                $data['status'] = 'Pending';
            } elseif ($request->status == 2) {
                $data['status'] = 'Cancelled';
            } elseif ($request->status == 3) {
                $data['status'] = 'Incomplete';
            } elseif ($request->status == 4) {
                $data['status'] = 'Report Pending';
            } elseif ($request->status == 5) {
                $data['status'] = 'Completed';
            } elseif ($request->status == 6) {
                $data['status'] = 'Rescheduled';
            } elseif ($request->status == 7) {
                $data['status'] = 'Client Postponded';
            } elseif ($request->status == 8) {
                $data['status'] = 'Invoiced';
            }

            $data['booking'] = $booking = Booking::where('booking_id', $request->segment(3))->first();
            $customer = Customer::where('customer_id', $booking->booking_customer)->first();

            $mail  = $customer->customer_email;

            $uname = $data['name'] = $customer->customer_name;

            $send = Mail::send('admin.mail.booking_status', $data, function ($message) use ($mail, $uname) {
                $message->to($mail, $uname)->subject(config('constants.site_title') . ' - Job Status Changed');
                $message->from(config('constants.mail_from'), config('constants.site_title'));
            });

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function upload_booking_files(Request $request)
    {
        if ($request->has('submit')) {
            if ($request->hasFile('booking_worksheet')) {
                $booking_worksheet = $request->booking_worksheet->store('assets/admin/uploads/booking');

                $booking_worksheet = explode('/', $booking_worksheet);
                $booking_worksheet = end($booking_worksheet);
                $upd['booking_worksheet'] = $booking_worksheet;
            }

            if ($request->hasFile('booking_drawing')) {
                $booking_drawing = $request->booking_drawing->store('assets/admin/uploads/booking');

                $booking_drawing = explode('/', $booking_drawing);
                $booking_drawing = end($booking_drawing);
                $upd['booking_drawing'] = $booking_drawing;
            }

            if ($request->hasFile('booking_frequest')) {
                $booking_frequest = $request->booking_frequest->store('assets/admin/uploads/booking');

                $booking_frequest = explode('/', $booking_frequest);
                $booking_frequest = end($booking_frequest);
                $upd['booking_frequest'] = $booking_frequest;
            }

            $upd['booking_trash'] = 1;
            Booking::where('booking_id', $request->segment(3))->update($upd);

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function update_voucher(Request $request)
    {
        if ($request->has('submit')) {
            $upd['booking_description'] = $request->booking_description;
            $upd['booking_equipments']  = json_encode($request->equiments);
            $upd['booking_consumables'] = json_encode($request->consumables);
            $upd['booking_nata']        = $request->booking_nata;
            $upd['booking_nvehicles']   = $request->booking_nvehicles;
            $upd['booking_rhours']      = $request->booking_rhours;
            $upd['booking_aexpenses']   = $request->booking_aexpenses;
            $upd['booking_vname']       = $request->booking_vname;
            $upd['booking_vemail']      = $request->booking_vemail;
            $upd['booking_vphone']      = $request->booking_vphone;
            $upd['booking_cname']       = $request->booking_cname;
            $upd['booking_cemail']      = $request->booking_cemail;
            $upd['booking_cphone']      = $request->booking_cphone;

            if (!empty($request->vsigned)) {
                $folderPath = public_path(config('constants.admin_path') . '/uploads/signature/');
                $image_parts = explode(";base64,", $request->vsigned);

                $image_type_aux = explode("image/", $image_parts[0]);

                $image_type = $image_type_aux[1];

                $image_base64 = base64_decode($image_parts[1]);

                $file_name = uniqid() . '.' . $image_type;

                $file = $folderPath . $file_name;
                file_put_contents($file, $image_base64);

                $upd['booking_vsignature'] = $file_name;
            }

            if (!empty($request->csigned)) {
                $cfolderPath = public_path(config('constants.admin_path') . '/uploads/signature/');
                $cimage_parts = explode(";base64,", $request->csigned);

                $cimage_type_aux = explode("image/", $cimage_parts[0]);

                $cimage_type = $cimage_type_aux[1];

                $cimage_base64 = base64_decode($cimage_parts[1]);

                $cfile_name = uniqid() . '.' . $cimage_type;

                $cfile = $cfolderPath . $cfile_name;
                file_put_contents($cfile, $cimage_base64);

                $upd['booking_csignature']  = $cfile_name;
            }

            Booking::where('booking_id', $request->segment(3))->update($upd);

            return redirect()->back()->with('success', 'Details Updated Successfully');
        }
    }

    public function add_working_hour(Request $request)
    {
        if ($request->has('submit')) {
            $rules = [
                'wh_date' => 'required',
                'wh_technician' => 'required',
                'wh_left_base' => 'required',
                'wh_return_base' => 'required',
                'wh_start_time' => 'required',
                'wh_finish_time' => 'required'
            ];

            $messages = [
                'wh_date.required' => 'Please Select Date',
                'wh_technician.required' => 'Please Select Technician',
                'wh_left_base.required' => 'Please Select Left Base',
                'wh_return_base.required' => 'Please Select Return Base',
                'wh_start_time.required' => 'Please Select Start Time',
                'wh_finish_time.required' => 'Please Select Finish Time'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $ins['wh_booking_id']  = $request->segment(3);
                $ins['wh_date']        = date('Y-m-d', strtotime($request->wh_date));
                $ins['wh_technician']  = $request->wh_technician;
                $ins['wh_left_base']   = date('H:i', strtotime($request->wh_left_base));
                $ins['wh_start_time']  = date('H:i', strtotime($request->wh_start_time));
                $ins['wh_finish_time'] = date('H:i', strtotime($request->wh_finish_time));
                $ins['wh_return_base'] = date('H:i', strtotime($request->wh_return_base));
                $ins['wh_added_on']    = date('Y-m-d H:i:s');
                $ins['wh_added_by']    = Auth::guard('staff')->user()->staff_id;
                $ins['wh_updated_on']  = date('Y-m-d H:i:s');
                $ins['wh_updated_by']  = Auth::guard('staff')->user()->staff_id;
                $ins['wh_status']      = 1;

                $add = WorkingHour::create($ins);

                if ($add) {
                    return redirect()->back()->with('success', 'Details Added Successfully');
                }
            }
        }
    }

    public function upload_photographs(Request $request)
    {
        if ($request->has('submit')) {
            $booking_detail = Booking::where('booking_id', $request->segment(3))->first();

            $old_file = array();

            if (!empty($booking_detail->booking_photographs)) {
                $old_file = json_decode($booking_detail->booking_photographs, true);
            }

            $file_names = array();

            if ($request->hasFile('booking_photographs')) {
                foreach ($request->booking_photographs as $booking_file) {
                    $file_path = $booking_file->getClientOriginalName();
                    $file_name = time() . '-' . $file_path;

                    $final_file_path = 'assets/admin/uploads/booking';

                    $booking_file->storeAs($final_file_path, $file_name);

                    $file_names[] = $file_name;
                }

                $new_files = array_merge($old_file, $file_names);

                $upd['booking_photographs'] = json_encode($new_files);
            }

            $upd['booking_trash'] = 1;
            Booking::where('booking_id', $request->segment(3))->update($upd);

            return redirect()->back()->with('success', 'Details Added Successfully');
        }
    }

    public function download_booking(Request $request)
    {
        $where['booking_id'] = $request->segment(3);
        $data['booking'] = Booking::getAllDetail($where);

        if (!isset($data['booking'])) {
            return redirect('staff/bookings');
        }

        $activity_arr = json_decode($data['booking']->booking_activities, true);

        $get_activities = Activity::whereIn('activity_id', $activity_arr)->get();

        $activities = array_column($get_activities->toArray(), 'activity_name');
        $data['activities'] = implode(', ', $activities);

        $booking_staffs = BookingStaff::where('bstaff_booking', $data['booking']->booking_id)->get();

        $staff_arr = array();

        if ($booking_staffs->count() > 0) {
            $staff_arr = array_column($booking_staffs->toArray(), 'bstaff_staff');
        }

        $get_staffs = Staff::whereIn('staff_id', $staff_arr)->get();

        $staffs = array_column($get_staffs->toArray(), 'staff_fname');
        $data['staffs'] = implode(', ', $staffs);

        $get_equipments = Equipment::where('equipment_status', 1)->orderby('equipment_name', 'asc')->get();

        if ($get_equipments->count() > 0) {
            foreach ($get_equipments as $get_equipment) {
                $equipments[$get_equipment->equipment_id] = $get_equipment->equipment_name;
            }

            $data['equipments'] = $equipments;
        }

        $get_consumables = Consumable::where('consumable_status', 1)->orderby('consumable_name', 'asc')->get();

        if ($get_consumables->count() > 0) {
            foreach ($get_consumables as $get_consumable) {
                $consumables[$get_consumable->consumable_id] = $get_consumable->consumable_name;
            }

            $data['consumables'] = $consumables;
        }

        $data['all_staffs'] = Staff::where('staff_status', 1)->orderby('staff_fname', 'asc')->get();

        $data['working_hours'] = WorkingHour::join('staffs', 'staffs.staff_id', 'working_hours.wh_technician')->where('wh_booking_id', $request->segment(3))->orderby('wh_id', 'desc')->get();

        $data['set'] = 'bookings';

        //return view('staff.booking.download_booking',$data);exit;
        $pdf = PDF::loadView('staff.booking.download_booking', $data);

        $filename = 'job_' . $data['booking']->booking_job_id . '.pdf';
        return $pdf->download($filename);
    }
}
