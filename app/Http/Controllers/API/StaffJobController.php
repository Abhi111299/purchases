<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Mail;
use Validator;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\Activity;
use App\Models\Equipment;
use App\Models\Consumable;
use App\Models\WorkingHour;
use App\Models\BookingStaff;
use App\Models\Booking;
   
class StaffJobController extends BaseController
{
    public function index(Request $request)
    {
        $where = 'booking_trash = 1';
        
        $where .= ' AND bstaff_status = 2';

        $where .= ' AND bstaff_staff = '.$request->user()->staff_id;

        if(!empty($request->start_date))
        {
            $where .= ' AND booking_start >= "'.date('Y-m-d 00:00:00',strtotime($request->start_date)).'"';
        }

        if(!empty($request->end_date))
        {
            $where .= ' AND booking_end <= "'.date('Y-m-d 23:59:59',strtotime($request->end_date)).'"';
        }

        if(!empty($request->location))
        {
            $where .= ' AND booking_branch = "'.$request->location.'"';
        }

        $jobs = Booking::getStaffWhereDetails($where);

        if($jobs->count() > 0)
        {
            foreach($jobs as $job)
            {
                $booking_start = date('d M Y h:i A',strtotime($job->booking_start));
                $booking_end = date('d M Y h:i A',strtotime($job->booking_end));

                $activity_arr = json_decode($job->booking_activities,true);

                $get_activities = Activity::whereIn('activity_id',$activity_arr)->get();

                $activities = array_column($get_activities->toArray(),'activity_name');
                $activities = implode(',',$activities);

                $booking_staffs = BookingStaff::where('bstaff_booking',$job->booking_id)->join('staffs','staffs.staff_id','booking_staffs.bstaff_staff')->get();

                $staffs = array();

                if($booking_staffs->count() > 0)
                {
                    foreach($booking_staffs as $booking_staff)
                    {
                        if($booking_staff->bstaff_status == 1)
                        {
                            $status = 'Pending';
                        }
                        elseif($booking_staff->bstaff_status == 2)
                        {
                            $status = 'Confirm';
                        }
                        elseif($booking_staff->bstaff_status == 3)
                        {
                            $status = 'Not Confirm';
                        }
                        elseif($booking_staff->bstaff_status == 4)
                        {
                            $status = 'Sick Leave';
                        }
                        elseif($booking_staff->bstaff_status == 5)
                        {
                            $status = 'Annual Leave';
                        }

                        $staffs[] = $booking_staff->staff_fname.' '.$booking_staff->staff_lname.' - '.$status;
                    }
                }
                
                $staffs = implode(', ',$staffs);

                if($job->booking_status == 1)
                {
                    $status = 'Pending';
                }
                elseif($job->booking_status == 2)
                {
                    $status = 'Cancelled';
                }
                elseif($job->booking_status == 3)
                {
                    $status = 'Incomplete';
                }
                elseif($job->booking_status == 4)
                {
                    $status = 'Report Pending';
                }
                elseif($job->booking_status == 5)
                {
                    $status = 'Completed';
                }
                else
                {
                    $status = 'Rescheduled';
                }

                $download_link = url('staff/download_booking/'.$job->booking_id);

                $result[] = array('id'=>$job->booking_id,'job_card_no'=>$job->booking_job_id,'service'=>$job->service_name,'client'=>$job->customer_name,'start_date'=>$booking_start,'end_date'=>$booking_end,'activities'=>$activities,'technicians'=>$staffs,'status'=>$status,'download_link'=>$download_link);
            }

            return $this->sendResponse($result, 'Jobs List');
        } 
        else
        {
            return $this->sendError('Jobs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function job_status(Request $request)
    {
        $statuses = array(1=>'Pending',2=>'Cancelled',3=>'Incomplete',4=>'Report Pending',5=>'Completed',6=>'Rescheduled',7=>'Client Postponded',8=>'Invoiced');

        if(count($statuses) > 0)
        {
            foreach($statuses as $id => $status)
            {                
                $result[] = array('id'=>$id,'name'=>$status);
            }

            return $this->sendResponse($result, 'Status List');
        } 
        else
        {
            return $this->sendError('Status Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function job_general(Request $request)
    {
        $where['booking_id'] = $request->segment(3);
        $job = Booking::getAllDetail($where);

        if(isset($job))
        {
            $activity_arr = json_decode($job->booking_activities,true);

            $get_activities = Activity::whereIn('activity_id',$activity_arr)->get();

            $activities = array_column($get_activities->toArray(),'activity_name');
            $activities = implode(', ',$activities);

            if($job->booking_status == 1)
            {
                $status = 'Pending';
            }
            elseif($job->booking_status == 2)
            {
                $status = 'Cancelled';
            }
            elseif($job->booking_status == 3)
            {
                $status = 'Incomplete';
            }
            elseif($job->booking_status == 4)
            {
                $status = 'Report Pending';
            }
            elseif($job->booking_status == 5)
            {
                $status = 'Completed';
            }
            elseif($job->booking_status == 6)
            {
                $status = 'Rescheduled';
            }
            elseif($job->booking_status == 7)
            {
                $status = 'Client Postponded';
            }
            elseif($job->booking_status == 8)
            {
                $status = 'Invoiced';
            }

            $download_link = url('staff/download_booking/'.$job->booking_id);

            $result = array('id'=>$job->booking_id,'client'=>$job->customer_name,'activities'=>$activities,'location'=>$job->booking_lname,'instruction'=>$job->booking_instruction,'status_id'=>$job->booking_status,'status'=>$status,'download_link'=>$download_link);

            return $this->sendResponse($result, 'Job General Details');
        }
        else
        {
            return $this->sendError('Job Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function job_update_status(Request $request)
    {
        $rules = ['status' => 'required'];
            
        $messages = ['status' => 'Please Select Status'];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $upd['booking_status'] = $request->status;
            Booking::where('booking_id',$request->segment(3))->update($upd);

            if($request->status == 1)
            {
                $data['status'] = $status = 'Pending';
            }
            elseif($request->status == 2)
            {
                $data['status'] = $status = 'Cancelled';
            }
            elseif($request->status == 3)
            {
                $data['status'] = $status = 'Incomplete';
            }
            elseif($request->status == 4)
            {
                $data['status'] = $status = 'Report Pending';
            }
            elseif($request->status == 5)
            {
                $data['status'] = $status = 'Completed';
            }
            elseif($request->status == 6)
            {
                $data['status'] = $status = 'Rescheduled';
            }
            elseif($request->status == 7)
            {
                $data['status'] = $status = 'Client Postponded';
            }
            elseif($request->status == 8)
            {
                $data['status'] = $status = 'Invoiced';
            }

            $data['booking'] = $booking = Booking::where('booking_id',$request->segment(3))->first();
            $customer = Customer::where('customer_id',$booking->booking_customer)->first();

            $mail  = $customer->customer_email;

            $uname = $data['name'] = $customer->customer_name;

            $send = Mail::send('admin.mail.booking_status', $data, function($message) use ($mail, $uname){
                    $message->to($mail, $uname)->subject(config('constants.site_title').' - Job Status Changed');
                    $message->from(config('constants.mail_from'),config('constants.site_title'));
                });
            
            $result = array('id'=>$booking->booking_id,'status'=> $status);

            return $this->sendResponse($result, 'Status Updated Successfully');
        }
    }

    public function job_working_hours(Request $request)
    {
        $working_hours = WorkingHour::join('staffs','staffs.staff_id','working_hours.wh_technician')->where('wh_booking_id',$request->segment(3))->orderby('wh_id','desc')->get();

        if($working_hours->count() > 0)
        {
            foreach($working_hours as $working_hour)
            {
                $staff_name = $working_hour->staff_fname.' '.$working_hour->staff_lname;

                $result[] = array('id'=>$working_hour->wh_id,'date'=>date('d M Y',strtotime($working_hour->wh_date)),'technician'=>$staff_name,'left_base'=>date('h:i A',strtotime($working_hour->wh_left_base)),'start_time'=>date('h:i A',strtotime($working_hour->wh_start_time)),'finish_time'=>date('h:i A',strtotime($working_hour->wh_finish_time)),'return_base'=>date('h:i A',strtotime($working_hour->wh_return_base)));
            }

            return $this->sendResponse($result, 'Location List');
        } 
        else
        {
            return $this->sendError('Working Hours Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function technicians(Request $request)
    {
        $where['staff_role'] = 3;
        $where['staff_status'] = 1;
        $technicians = Staff::where($where)->orderby('staff_fname','asc')->get();

        if($technicians->count() > 0)
        {
            foreach($technicians as $technician)
            {                
                $result[] = array('id'=>$technician->staff_id,'name'=>$technician->staff_fname.' '.$technician->staff_lname);
            }

            return $this->sendResponse($result, 'Technician List');
        } 
        else
        {
            return $this->sendError('Technicians Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function add_working_hour(Request $request)
    {
        $rules = ['date' => 'required',
                    'technician' => 'required',
                    'left_base' => 'required',
                    'return_base' => 'required',
                    'start_time' => 'required',
                    'finish_time' => 'required'
                    ];
        
        $messages = ['date.required' => 'Please Select Date',
                        'technician.required' => 'Please Select Technician',
                        'left_base.required' => 'Please Select Left Base',
                        'return_base.required' => 'Please Select Return Base',
                        'start_time.required' => 'Please Select Start Time',
                        'finish_time.required' => 'Please Select Finish Time'
                    ];
                    
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['wh_booking_id']  = $request->segment(3);
            $ins['wh_date']        = date('Y-m-d',strtotime($request->date));
            $ins['wh_technician']  = $request->technician;
            $ins['wh_left_base']   = date('H:i',strtotime($request->left_base));
            $ins['wh_start_time']  = date('H:i',strtotime($request->start_time));
            $ins['wh_finish_time'] = date('H:i',strtotime($request->finish_time));
            $ins['wh_return_base'] = date('H:i',strtotime($request->return_base));
            $ins['wh_added_on']    = date('Y-m-d H:i:s');
            $ins['wh_added_by']    = $request->user()->staff_id;
            $ins['wh_updated_on']  = date('Y-m-d H:i:s');
            $ins['wh_updated_by']  = $request->user()->staff_id;
            $ins['wh_status']      = 1;

            $add = WorkingHour::create($ins);

            if($add)
            {
                $result = array('working_hour_id' => $add->wh_id);

                return $this->sendResponse($result, 'Working Hour Added Successfully');
            }
            else
            {
                return $this->sendError('Working Hour Not Added', ['error'=>'Some errors occured']);
            }
        }
    }

    public function job_voucher(Request $request)
    {
        $where['booking_id'] = $request->segment(3);
        $job = Booking::getAllDetail($where);

        if(isset($job))
        {
            $all_equipments = Equipment::get();

            foreach($all_equipments as $all_equipment)
            {
                $equipment_name[$all_equipment->equipment_id] = $all_equipment->equipment_name;
            }

            $equipments = array();

            if(!empty($job->booking_equipments))
            {
                $json_equipments = json_decode($job->booking_equipments,true);

                foreach($json_equipments['EQUIPMENT'] as $ekey => $equipment)
                {
                    $equipments[] = array('id'=>$json_equipments['EQUIPMENT'][$ekey],'name'=>$equipment_name[$json_equipments['EQUIPMENT'][$ekey]],'qty'=>$json_equipments['QTY'][$ekey]);
                }
            }
            
            $all_consumables = Consumable::get();

            foreach($all_consumables as $all_consumable)
            {
                $consumable_name[$all_consumable->consumable_id] = $all_consumable->consumable_name;
            }

            $consumables = array();

            if(!empty($job->booking_consumables))
            {
                $json_consumables = json_decode($job->booking_consumables,true);

                foreach($json_consumables['CONSUMABLE'] as $ckey => $consumable)
                {
                    $consumables[] = array('id'=>$json_consumables['CONSUMABLE'][$ckey],'name'=>$consumable_name[$json_consumables['CONSUMABLE'][$ckey]],'qty'=>$json_consumables['QTY'][$ckey]);
                }
            }

            $signature = '';

            if(!empty($job->booking_vsignature))
            {
                $signature = asset(config('constants.admin_path')).'/uploads/signature/'.$job->booking_vsignature;
            }

            $representative_signature = '';

            if(!empty($job->booking_csignature))
            {
                $representative_signature = asset(config('constants.admin_path')).'/uploads/signature/'.$job->booking_csignature;
            }

            $result = array('description'=>$job->booking_description,'equipments'=>$equipments,'consumables'=>$consumables,'nata_report'=>$job->booking_nata,'no_vehicles'=>$job->booking_nvehicles,'reporting_hours'=>$job->booking_rhours,'additional_expenses'=>$job->booking_aexpenses,'prepared_by'=>$job->booking_vname,'email'=>$job->booking_vemail,'phone'=>$job->booking_vphone,'signature'=>$signature,'representative_name'=>$job->booking_cname,'representative_email'=>$job->booking_cemail,'representative_phone'=>$job->booking_cphone,'representative_signature'=>$representative_signature);

            return $this->sendResponse($result, 'Job Voucher Details');
        }
        else
        {
            return $this->sendError('Job Voucher Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function update_voucher(Request $request)
    {
        if(!empty($request->equipments))
        {
            $equipments = json_encode($request->equipments);
        }
        else
        {
            $equipments = NULL;
        }

        if(!empty($request->consumables))
        {
            $consumables = json_encode($request->consumables);
        }
        else
        {
            $consumables = NULL;
        }

        $upd['booking_description'] = $request->description;
        $upd['booking_equipments']  = $equipments;
        $upd['booking_consumables'] = $consumables;
        $upd['booking_nata']        = $request->no_nata;
        $upd['booking_nvehicles']   = $request->no_vehicles;
        $upd['booking_rhours']      = $request->report_hours;
        $upd['booking_aexpenses']   = $request->additional_expenses;
        $upd['booking_cname']       = $request->representative_name;
        $upd['booking_cemail']      = $request->representative_email;
        $upd['booking_cphone']      = $request->representative_phone;

        if($request->hasFile('signature'))
        {
            $signature = $request->signature->store('assets/admin/uploads/signature');
            
            $signature = explode('/',$signature);
            $signature = end($signature);
            $upd['booking_vsignature'] = $signature;
        }

        if($request->hasFile('representative_signature'))
        {
            $representative_signature = $request->representative_signature->store('assets/admin/uploads/signature');
            
            $representative_signature = explode('/',$representative_signature);
            $representative_signature = end($representative_signature);
            $upd['booking_csignature'] = $representative_signature;
        }

        Booking::where('booking_id',$request->segment(3))->update($upd);
        
        $result = array('id'=>$request->segment(3));

        return $this->sendResponse($result, 'Voucher Updated Successfully');
    }

    public function photographs(Request $request)
    {
        $job = Booking::where('booking_id',$request->segment(3))->first();

        if(isset($job))
        {
            $photographs = array();

            if(!empty($job->booking_photographs))
            {
                $json_photographs = json_decode($job->booking_photographs,true);

                foreach($json_photographs as $json_photograph)
                {
                    $photographs[] = asset(config('constants.admin_path').'uploads/booking/'.$json_photograph);
                }
            }

            $result = array('photographs'=>$photographs);

            return $this->sendResponse($result, 'Photographs Details');
        }
        else
        {
            return $this->sendError('Photographs Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function update_photographs(Request $request)
    {
        $booking_detail = Booking::where('booking_id',$request->segment(3))->first();
            
        $old_file = array();

        if(!empty($booking_detail->booking_photographs))
        {
            $old_file = json_decode($booking_detail->booking_photographs,true);
        }
            
        $file_names = array();

        if($request->hasFile('photographs'))
        {
            foreach($request->photographs as $booking_file) 
            {
                $file_path = $booking_file->getClientOriginalName();
                $file_name = time() . '-' . $file_path;

                $final_file_path = 'assets/admin/uploads/booking';

                $booking_file->storeAs($final_file_path, $file_name);

                $file_names[] = $file_name;
            }

            $new_files = array_merge($old_file,$file_names);

            $upd['booking_photographs'] = json_encode($new_files);
        }

        $upd['booking_trash'] = 1;
        Booking::where('booking_id',$request->segment(3))->update($upd);
        
        $result = array('id'=>$request->segment(3));

        return $this->sendResponse($result, 'Photographs Updated Successfully');
    }

    public function upload_files(Request $request)
    {
        $job = Booking::where('booking_id',$request->segment(3))->first();

        if(isset($job))
        {
            $booking_worksheet = NULL;
            $booking_drawing   = NULL;
            $booking_frequest  = NULL;

            if(!empty($job->booking_worksheet))
            {
                $booking_worksheet = asset(config('constants.admin_path').'uploads/booking/'.$job->booking_worksheet);
            }

            if(!empty($job->booking_drawing))
            {
                $booking_drawing = asset(config('constants.admin_path').'uploads/booking/'.$job->booking_drawing);
            }

            if(!empty($job->booking_frequest))
            {
                $booking_frequest = asset(config('constants.admin_path').'uploads/booking/'.$job->booking_frequest);
            }

            $result = array('worksheet'=>$booking_worksheet,'drawing'=>$booking_drawing,'final_request'=>$booking_frequest);

            return $this->sendResponse($result, 'Upload Files Details');
        }
        else
        {
            return $this->sendError('Upload Files Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function update_upload_files(Request $request)
    {
        if($request->hasFile('worksheet'))
        {
            $worksheet = $request->worksheet->store('assets/admin/uploads/booking');
            
            $worksheet = explode('/',$worksheet);
            $worksheet = end($worksheet);
            $upd['booking_worksheet'] = $worksheet;
        }

        if($request->hasFile('drawing'))
        {
            $drawing = $request->drawing->store('assets/admin/uploads/booking');
            
            $drawing = explode('/',$drawing);
            $drawing = end($drawing);
            $upd['booking_drawing'] = $drawing;
        }

        if($request->hasFile('final_request'))
        {
            $final_request = $request->final_request->store('assets/admin/uploads/booking');
            
            $final_request = explode('/',$final_request);
            $final_request = end($final_request);
            $upd['booking_frequest'] = $final_request;
        }

        $upd['booking_trash'] = 1;
        Booking::where('booking_id',$request->segment(3))->update($upd);
        
        $result = array('id'=>$request->segment(3));

        return $this->sendResponse($result, 'Files Updated Successfully');
    }
}