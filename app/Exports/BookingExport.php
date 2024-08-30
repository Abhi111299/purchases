<?php

namespace App\Exports;

use Auth;
use App\Models\Activity;
use App\Models\Staff;
use App\Models\Booking;
use App\Models\BookingStaff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    use Exportable;

    function __construct($start_date,$end_date,$branch) {
        
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->branch = $branch;
    }

    public function collection()
    {   
        $all = array();
        
        $where = 'booking_trash = 1';

        if(!empty($this->start_date))
        {
            $where .= ' AND booking_start >= "'.date('Y-m-d 00:00:00',strtotime($this->start_date)).'"';
        }

        if(!empty($this->end_date))
        {
            $where .= ' AND booking_end <= "'.date('Y-m-d 23:59:59',strtotime($this->end_date)).'"';
        }

        if(!empty($this->branch))
        {
            $where .= ' AND booking_branch = "'.$this->branch.'"';
        }

        $bookings = Booking::getWhereDetails($where);

        $i = 1;

        foreach($bookings as $booking)
        {
            $booking_start = date('d M Y h:i A',strtotime($booking->booking_start));
            $booking_end   = date('d M Y h:i A',strtotime($booking->booking_end));

            $activity_arr = json_decode($booking->booking_activities,true);

            $get_activities = Activity::whereIn('activity_id',$activity_arr)->get();

            $activities = array_column($get_activities->toArray(),'activity_name');
            $activities = implode(',',$activities);

            $booking_staffs = BookingStaff::where('bstaff_booking',$booking->booking_id)->join('staffs','staffs.staff_id','booking_staffs.bstaff_staff')->get();

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

            if($booking->booking_status == 1){ $status = 'Pending'; }elseif($booking->booking_status == 2){ $status = 'Cancelled'; }elseif($booking->booking_status == 3){ $status = 'Incomplete'; }elseif($booking->booking_status == 4){ $status = 'Report Pending'; }elseif($booking->booking_status == 5){ $status = 'Completed'; }else{ $status = 'Rescheduled'; }

            $all[] = array('id'=>$i,'service'=>$booking->service_name,'customer'=>$booking->customer_name,'start_date'=>$booking_start,'end_date'=>$booking_end,'activities'=>$activities,'staffs'=>$staffs,'location'=>$booking->booking_lname,'instructions'=>$booking->booking_instruction,'status'=>$status);

            $i++;

        }

        return collect($all);
    }

    public function headings(): array
    {

        return [
            'S.No',
            'Service',
            'Client',
            'Start Date',
            'End Date',
            'Activities',
            'Technicians',
            'Location',
            'Instructions',
            'Status'
        ];

    }

}