<?php

namespace App\Exports;

use Auth;
use App\Models\Timesheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimesheetExport implements FromCollection, WithHeadings
{
    use Exportable;

    function __construct($staff_id,$from_date,$to_date) {
        
        $this->staff_id = $staff_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {   
        $all = array();
        
        $where = 'timesheet_status = 1';

        if(!empty($this->staff_id))
        {
            $where .= ' AND staff_id = '.$this->staff_id;
        }

        if(!empty($this->from_date))
        {
            $from_date = '"'.date('Y-m-d',strtotime($this->from_date)).'"';

            $where .= ' AND timesheet_date >= '.$from_date;
        }
        
        if(!empty($this->to_date))
        {
            $to_date = '"'.date('Y-m-d',strtotime($this->to_date)).'"';

            $where .= ' AND timesheet_date <= '.$to_date;
        }

        $timesheets = Timesheet::getWhereStaffDetails($where);

        $i = 1;

        foreach($timesheets as $timesheet)
        {
            $staff_name = $timesheet->staff_fname.' '.$timesheet->staff_lname;

            if($timesheet->timesheet_wtype == 1){ $status = 'Work'; }elseif($timesheet->timesheet_wtype == 2){ $status = 'Sick Leave'; }elseif($timesheet->timesheet_wtype == 3){ $status = 'Annual Leave'; }elseif($timesheet->timesheet_wtype == 4){ $status = 'Training'; }elseif($timesheet->timesheet_wtype == 5){ $status = 'Travelling'; }elseif($timesheet->timesheet_wtype == 6){ $status = 'Saturday Holiday'; }elseif($timesheet->timesheet_wtype == 7){ $status = 'Sunday Holiday'; }elseif($timesheet->timesheet_wtype == 8){ $status = 'Public Holiday'; }elseif($timesheet->timesheet_wtype == 9){ $status = 'Others'; }

            $timesheet_date = date('d M Y',strtotime($timesheet->timesheet_date));
            
            $all[] = array('id'=>$i,'staff'=>$staff_name,'date'=>$timesheet_date,'status'=>$status,'start_time'=>$timesheet->timesheet_start,'end_time'=>$timesheet->timesheet_end,'client'=>$timesheet->customer_name,'location'=>$timesheet->location_name,'description'=>$timesheet->timesheet_desc);

            $i++;

        }

        return collect($all);
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Staff',
            'Date',
            'Status',
            'Start Time',
            'Finish Time',
            'Client',
            'Location',
            'Description'
        ];

    }

}