<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Equipment;
   
class StaffEquipmentController extends BaseController
{
    public function index(Request $request)
    {
        $equipments = Equipment::where('equipment_status',1)->orderby('equipment_name','asc')->get();

        if($equipments->count() > 0)
        {
            foreach($equipments as $equipment)
            {                
                $result[] = array('id'=>$equipment->equipment_id,'name'=>$equipment->equipment_name);
            }

            return $this->sendResponse($result, 'Equipment List');
        } 
        else
        {
            return $this->sendError('Equipments Not Available.', ['error'=>'Data Not Available']);
        }
    }
}