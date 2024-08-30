<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';

    protected $primaryKey = 'asset_id';

    public $timestamps = false;

    protected $fillable = ['asset_name','asset_method','asset_location','asset_department','asset_condition','asset_manufacture','asset_model','asset_serial_no','asset_crequired','asset_cdate','asset_cfrequency','asset_cdue_date','asset_accessory_include','asset_accessory_details','asset_packing_file','asset_manufacture_file','asset_manual_file','asset_supporting_file','asset_photographs_file','asset_image','asset_added_on','asset_added_by','asset_updated_on','asset_updated_by','asset_status','asset_trash'];

    public static function getDetails($where)
    {
        $asset = new Asset;

        return $asset->select('*')
                    ->leftjoin('activities','activities.activity_id','assets.asset_method')
                    ->leftjoin('locations','locations.location_id','assets.asset_location')
                    ->leftjoin('departments','departments.department_id','assets.asset_department')
                    ->where($where)
                    ->orderby('asset_id','desc')
                    ->get();
    }

    public static function getDetail($where)
    {
        $asset = new Asset;

        return $asset->select('*')
                    ->leftjoin('activities','activities.activity_id','assets.asset_method')
                    ->leftjoin('locations','locations.location_id','assets.asset_location')
                    ->leftjoin('departments','departments.department_id','assets.asset_department')
                    ->where($where)
                    ->first();
    }
}