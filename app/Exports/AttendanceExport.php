<?php

namespace App\Exports;

use Auth;
use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
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
        
        $where = 'attendance_status = 1';

        if(!empty($this->staff_id))
        {
            $where .= ' AND staff_id = '.$this->staff_id;
        }

        if(!empty($this->from_date))
        {
            $from_date = '"'.date('Y-m-d',strtotime($this->from_date)).'"';

            $where .= ' AND attendance_date >= '.$from_date;
        }
        
        if(!empty($this->to_date))
        {
            $to_date = '"'.date('Y-m-d',strtotime($this->to_date)).'"';

            $where .= ' AND attendance_date <= '.$to_date;
        }

        $attendances = Attendance::getWhereDetails($where);

        $i = 1;

        foreach($attendances as $attendance)
        {
            $staff_name = $attendance->staff_fname.' '.$attendance->staff_lname;

            if($attendance->attendance_type == 1){ $type = 'Present'; }elseif($attendance->attendance_type == 2){ $type = 'Absent'; }elseif($attendance->attendance_type == 3){ $type = 'Half Day'; }

            $attendance_date = date('d M Y',strtotime($attendance->attendance_date));
            
            $all[] = array('id'=>$i,'staff'=>$staff_name,'date'=>$attendance_date,'attendance'=>$type,'notes'=>$attendance->attendance_notes);

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
            'Attendance',
            'Notes'
        ];

    }

}