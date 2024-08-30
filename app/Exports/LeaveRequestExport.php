<?php

namespace App\Exports;

use Auth;
use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveRequestExport implements FromCollection, WithHeadings
{
    use Exportable;

    function __construct($staff_id) {
        
        $this->staff_id = $staff_id;
    }

    public function collection()
    {   
        $all = array();
        
        if(!empty($this->staff_id))
        {
            $where['leave_staff'] = $this->staff_id;
        }

        $where['leave_trash'] = 1;
        $leave_requests = Leave::getWhereAdminDetails($where);

        $i = 1;

        foreach($leave_requests as $leave_request)
        {
            $staff_name = $leave_request->staff_fname.' '.$leave_request->staff_lname;

            if($leave_request->leave_type == 1){ $type = 'Sick Leave'; }elseif($leave_request->leave_type == 2){ $type = 'Annual Leave'; }elseif($leave_request->leave_type == 3){ $type = 'Parental Leave'; }elseif($leave_request->leave_type == 4){ $type = 'Long Service Leave'; }elseif($leave_request->leave_type == 5){ $type = 'Other'; }

            $apply_date = date('d M Y',strtotime($leave_request->leave_date));
            
            $start_date = date('d M Y',strtotime($leave_request->leave_sdate));

            $return_date = date('d M Y',strtotime($leave_request->leave_wdate));

            if($leave_request->leave_status == 1){ $status = 'Pending'; }elseif($leave_request->leave_status == 2){ $status = 'Approved'; }elseif($leave_request->leave_status == 3){ $status = 'Rejected'; }

            $all[] = array('id'=>$i,'staff'=>$staff_name,'type'=>$type,'apply_date'=>$apply_date,'reason'=>$leave_request->leave_reason,'start_date'=>$start_date,'return_work'=>$return_date,'status'=>$status);

            $i++;

        }

        return collect($all);
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Staff',
            'Type',
            'Apply Date',
            'Reason',
            'Start Date',
            'Return to Work',
            'Status'
        ];

    }

}