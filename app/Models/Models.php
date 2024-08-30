<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $table = 'models';

    protected $primaryKey = 'model_id';

    public $timestamps = false;

    protected $fillable = ['model_manufacturer','model_name','model_added_on','model_added_by','model_updated_on','model_updated_by','model_status'];

    public static function getDetails()
    {
        $models = new Models;

        return $models->select('*')
                    ->join('manufacturers','manufacturers.manufacturer_id','models.model_manufacturer')
                    ->orderby('model_id','desc')
                    ->get();
    }

    public static function getWhereDetails($where)
    {
        $models = new Models;

        return $models->select('*')
                    ->join('manufacturers','manufacturers.manufacturer_id','models.model_manufacturer')
                    ->where($where)
                    ->orderby('model_id','desc')
                    ->get();
    }
}