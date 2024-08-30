<?php

namespace App\Exports;

use Auth;
use App\Models\StaffQualification;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CertificateExport implements FromCollection, WithHeadings
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

        $where['squalification_status'] = 1;
        $certificates = StaffQualification::getDetails($where);

        $i = 1;

        foreach($certificates as $certificate)
        {
            $staff_name = $certificate->staff_fname.' '.$certificate->staff_lname;

            $certificate_date = date('d M Y',strtotime($certificate->squalification_date));

            $expiry_date = date('d M Y',strtotime($certificate->squalification_edate));

            if($certificate->squalification_pstatus == 1){ $pay_status = 'Self'; }elseif($certificate->squalification_pstatus == 2){ $pay_status = 'Company'; }elseif($certificate->squalification_pstatus == 3){ $pay_status = 'Others'; }

            $copy_url = '';

            if(!empty($certificate->squalification_copy))
            {
                $copy_url = asset(config('constants.admin_path').'uploads/staff').'/'.$certificate->squalification_copy;
            }

            $all[] = array('id'=>$i,'staff'=>$staff_name,'certification_body'=>$certificate->squalification_cbody,'certification_held'=>$certificate->squalification_held,'level_qualification'=>$certificate->squalification_level,'certificate_date'=>$certificate_date,'expiry_date'=>$expiry_date,'payment_status'=>$pay_status,'ceritificate_copy'=>$copy_url);

            $i++;

        }

        return collect($all);
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Staff',
            'Certification Body',
            'Certification Held',
            'Level of Qualification',
            'Certification Date',
            'Expiry Date',
            'Payment Status',
            'Certificate Copy'
        ];

    }

}