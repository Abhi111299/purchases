<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Asset;
   
class StaffAssetController extends BaseController
{
    public function index(Request $request)
    {
        if(!empty($request->condition))
        {
            $where['asset_condition'] = $request->condition;
        }

        if(!empty($request->location))
        {
            $where['asset_location'] = $request->location;
        }

        if(!empty($request->calibration))
        {
            $where['asset_crequired'] = $request->calibration;
        }

        $where['asset_trash'] = 1;
        $assets = Asset::getDetails($where);

        if($assets->count() > 0)
        {
            foreach($assets as $asset)
            {
                if(!empty($asset->asset_image))
                {
                    $image_url = asset(config('constants.admin_path').'uploads/asset/'.$asset->asset_image);
                }
                else
                {
                    $image_url = asset(config('constants.admin_path').'dist/img/no_image.png');
                }

                $condition = '';

                if($asset->asset_condition == 1)
                {
                    $condition = 'Inservice';
                }
                elseif($asset->asset_condition == 2)
                {
                    $condition = 'Out of service';
                }
                elseif($asset->asset_condition == 3)
                {
                    $condition = 'Maintenance';
                }
                elseif($asset->asset_condition == 4)
                {
                    $condition = 'Calibration out';
                }
                elseif($asset->asset_condition == 5)
                {
                    $condition = 'Repair';
                }
                elseif($asset->asset_condition == 6)
                {
                    $condition = 'Send for repair';
                }

                $result[] = array('id'=>$asset->asset_id,'image'=>$image_url,'name'=>$asset->asset_name,'method'=>$asset->activity_name,'location'=>$asset->location_name,'department'=>$asset->department_name,'condition'=>$condition);
            }

            return $this->sendResponse($result, 'Asset List');
        }
        else
        {
            return $this->sendError('Assets Not Available.', ['error'=>'Data Not Available']);
        }
    }

    public function asset_details(Request $request)
    {
        $where['asset_id'] = $request->segment(3);
        $asset = Asset::getDetail($where);

        if(isset($asset))
        {
            if(!empty($asset->asset_image))
            {
                $image_url = asset(config('constants.admin_path').'uploads/asset/'.$asset->asset_image);
            }
            else
            {
                $image_url = asset(config('constants.admin_path').'dist/img/no_image.png');
            }

            $condition = '';

            if($asset->asset_condition == 1)
            {
                $condition = 'Inservice';
            }
            elseif($asset->asset_condition == 2)
            {
                $condition = 'Out of service';
            }
            elseif($asset->asset_condition == 3)
            {
                $condition = 'Maintenance';
            }
            elseif($asset->asset_condition == 4)
            {
                $condition = 'Calibration out';
            }
            elseif($asset->asset_condition == 5)
            {
                $condition = 'Repair';
            }
            elseif($asset->asset_condition == 6)
            {
                $condition = 'Send for repair';
            }

            if($asset->asset_crequired == 1)
            {
                $crequired = 'Yes';

                $calibration_date = date('d M Y',strtotime($asset->asset_cdate));
                $calibration_frequency = $asset->asset_cfrequency;
                $calibration_due_date = date('d M Y',strtotime($asset->asset_cdue_date));
            }
            else
            {
                $crequired = 'No';

                $calibration_date = NULL;
                $calibration_frequency = NULL;
                $calibration_due_date = NULL;
            }

            if($asset->asset_accessory_include == 1)
            {
                $ainclude = 'Yes';

                $json_accessory_details = json_decode($asset->asset_accessory_details,true);

                foreach($json_accessory_details['NAME'] as $key => $accessory_detail)  
                {
                    $accessory_details[] = array('name' => $json_accessory_details['NAME'][$key],'model' => $json_accessory_details['MODEL'][$key],'serial' => $json_accessory_details['SERIAL'][$key]);
                }
            }
            else
            {
                $ainclude = 'No';

                $accessory_details = array();
            }

            if(!empty($asset->asset_packing_file))
            {
                $packing_file = asset(config('constants.admin_path').'uploads/asset/'.$asset->asset_packing_file);
            }
            else
            {
                $packing_file = NULL;
            }

            if(!empty($asset->asset_manufacture_file))
            {
                $manufacture_file = asset(config('constants.admin_path').'uploads/asset/'.$asset->asset_manufacture_file);
            }
            else
            {
                $manufacture_file = NULL;
            }

            if(!empty($asset->asset_manual_file))
            {
                $manual_file = asset(config('constants.admin_path').'uploads/asset/'.$asset->asset_manual_file);
            }
            else
            {
                $manual_file = NULL;
            }

            if(!empty($asset->asset_supporting_file))
            {
                $supporting_file = asset(config('constants.admin_path').'uploads/asset/'.$asset->asset_supporting_file);
            }
            else
            {
                $supporting_file = NULL;
            }

            if(!empty($asset->asset_photographs_file))
            {
                $json_photographs_files = json_decode($asset->asset_photographs_file,true);

                foreach($json_photographs_files as $jphotographs_file)
                {
                    $photographs_file[] = asset(config('constants.admin_path').'uploads/asset/'.$jphotographs_file);
                }
            }
            else
            {
                $photographs_file = array();
            }

            $result = array('id'=>$asset->asset_id,'name'=>$asset->asset_name,'image'=>$image_url,'method'=>$asset->activity_name,'location'=>$asset->location_name,'department'=>$asset->department_name,'condition'=>$condition,'manufacture'=>$asset->asset_manufacture,'model'=>$asset->asset_model,'serial_no'=>$asset->asset_serial_no,'calibration_required'=>$crequired,'calibration_date'=>$calibration_date,'calibration_frequency'=>$calibration_frequency,'calibration_due_date'=>$calibration_due_date,'accessory_included'=>$ainclude,'accessory_details'=>$accessory_details,'packing_list'=>$packing_file,'manufacture_calibration'=>$manufacture_file,'user_manual'=>$manual_file,'supporting_file'=>$supporting_file,'photographs'=>$photographs_file);

            return $this->sendResponse($result, 'Asset Details');
        } 
        else
        {
            return $this->sendError('Asset Not Available.', ['error'=>'Data Not Available']);
        }
    }
}