<?php

namespace App\Exports;

use Auth;
use App\Models\StaffInduction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InductionExport implements FromCollection, WithHeadings
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
            $where['staff_id'] = $this->staff_id;
        }

        $where['sinduction_status'] = 1;
        $inductions = StaffInduction::getDetails($where);

        $i = 1;

        foreach($inductions as $induction)
        {
            $staff_name = $induction->staff_fname.' '.$induction->staff_lname;

            if($induction->sinduction_type == 1){ $type_name = 'Online'; }elseif($induction->sinduction_type == 2){ $type_name = 'Face to Face'; }elseif($induction->sinduction_type == 3){ $type_name = 'Other'; }

            $induction_date = date('d M Y',strtotime($induction->sinduction_date));

            $expiry_date = date('d M Y',strtotime($induction->sinduction_edate));

            if($induction->sinduction_pstatus == 1){ $pay_status = 'Self'; }elseif($induction->sinduction_pstatus == 2){ $pay_status = 'Company'; }elseif($induction->sinduction_pstatus == 3){ $pay_status = 'Others'; }

            $copy_url = '';

            if(!empty($induction->sinduction_copy))
            {
                $copy_url = asset(config('constants.admin_path').'uploads/staff').'/'.$induction->sinduction_copy;
            }

            $all[] = array('id'=>$i,'staff'=>$staff_name,'client'=>$induction->customer_name,'site'=>$induction->sinduction_site,'name'=>$induction->sinduction_name,'type'=>$type_name,'induction_date'=>$induction_date,'expiry_date'=>$expiry_date,'payment_status'=>$pay_status,'evidence_copy'=>$copy_url);

            $i++;

        }

        return collect($all);
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Staff',
            'Client',
            'Inducted Site',
            'Name of Induction',
            'Type of Induction',
            'Induction Date',
            'Expiry Date',
            'Payment Status',
            'Evidence of Induction'
        ];

    }

}