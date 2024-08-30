<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use Image;
use App\Models\Activity;
use App\Models\Location;
use App\Models\Department;
use App\Models\Asset;

class StaffAssetController extends Controller
{
    public function index()
    {
        $data['locations'] = Location::where('location_status',1)->orderby('location_name','asc')->get();

        $data['set'] = 'assets';
        return view('staff.asset.assets',$data);
    }

    public function get_assets(Request $request)
    {
        if($request->ajax())
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
            $data = Asset::getDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('asset_name', function($row){
                        $asset_name = '<a href="view_asset/'.$row->asset_id.'">'.$row->asset_name.'</a>';
                        return $asset_name;
                    })
                    ->addColumn('asset_image', function($row){
                        
                        if(!empty($row->asset_image))
                        {
                            $image_url = asset(config('constants.admin_path').'uploads/asset/'.$row->asset_image);
                        }
                        else
                        {
                            $image_url = asset(config('constants.admin_path').'dist/img/no_image.png');
                        }

                        $asset_image = '<img src="'.$image_url.'" class="img-thumbnail" style="width: 100px;height: 100px;">';

                        return $asset_image;
                    })
                    ->addColumn('condition', function($row){
                        
                        $condition = '';

                        if($row->asset_condition == 1)
                        {
                            $condition = 'Inservice';
                        }
                        elseif($row->asset_condition == 2)
                        {
                            $condition = 'Out of service';
                        }
                        elseif($row->asset_condition == 3)
                        {
                            $condition = 'Maintenance';
                        }
                        elseif($row->asset_condition == 4)
                        {
                            $condition = 'Calibration out';
                        }
                        elseif($row->asset_condition == 5)
                        {
                            $condition = 'Repair';
                        }
                        elseif($row->asset_condition == 6)
                        {
                            $condition = 'Send for repair';
                        }

                        return $condition;
                    })
                    ->addColumn('action', function($row){
                        
                        $btn = '';

                        $btn .= '<a href="view_asset/'.$row->asset_id.'" class="btn btn-info btn-sm" title="View"><i class="fa fa-eye"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action','asset_name','asset_image'])
                    ->make(true);
        }
    }

    public function view_asset(Request $request)
    {
        $where['asset_id'] = $request->segment(3);
        $data['asset'] = Asset::getDetail($where);

        if(!isset($data['asset']))
        {
            return redirect('staff/assets');
        }
        
        $data['set'] = 'assets';
        return view('staff.asset.view_asset',$data);
    }
}