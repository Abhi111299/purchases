<?php

namespace App\Exports;

use Auth;
use App\Models\StaffLicence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LicenceExport implements FromCollection, WithHeadings
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

        $where['slicence_status'] = 1;
        $licences = StaffLicence::getDetails($where);

        $i = 1;

        foreach($licences as $licence)
        {
            $staff_name = $licence->staff_fname.' '.$licence->staff_lname;

            if($licence->slicence_training_type == 1){ $type_name = 'Online'; }elseif($licence->slicence_training_type == 2){ $type_name = 'Face to Face'; }elseif($licence->slicence_training_type == 3){ $type_name = 'Other'; }

            $validation_date = date('d M Y',strtotime($licence->slicence_date));

            $expiry_date = date('d M Y',strtotime($licence->slicence_edate));

            if($licence->slicence_pstatus == 1){ $pay_status = 'Self'; }elseif($licence->slicence_pstatus == 2){ $pay_status = 'Company'; }elseif($licence->slicence_pstatus == 3){ $pay_status = 'Others'; }

            $copy_url = '';

            if(!empty($licence->slicence_copy))
            {
                $copy_url = asset(config('constants.admin_path').'uploads/staff').'/'.$licence->slicence_copy;
            }

            $all[] = array('id'=>$i,'staff'=>$staff_name,'training'=>$licence->training_name,'location'=>$licence->slicence_tlocation,'organisation'=>$licence->slicence_torganisation,'type'=>$type_name,'validation_date'=>$validation_date,'expiry_date'=>$expiry_date,'payment_status'=>$pay_status,'licence_copy'=>$copy_url);

            $i++;

        }

        return collect($all);
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Staff',
            'Training',
            'Training Location',
            'Training Organisation',
            'Type of Training',
            'Date of Validation',
            'Expiry Date',
            'Payment Status',
            'Licence/ Ticket Copy'
        ];

    }

}