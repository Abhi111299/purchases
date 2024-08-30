<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Consumable;
   
class StaffConsumableController extends BaseController
{
    public function index(Request $request)
    {
        $consumables = Consumable::where('consumable_status',1)->orderby('consumable_name','asc')->get();

        if($consumables->count() > 0)
        {
            foreach($consumables as $consumable)
            {                
                $result[] = array('id'=>$consumable->consumable_id,'name'=>$consumable->consumable_name);
            }

            return $this->sendResponse($result, 'Consumable List');
        } 
        else
        {
            return $this->sendError('Consumables Not Available.', ['error'=>'Data Not Available']);
        }
    }
}