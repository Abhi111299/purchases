<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Location;
   
class StaffLocationController extends BaseController
{
    public function index(Request $request)
    {
        $locations = Location::where('location_status',1)->orderby('location_name','asc')->get();

        if($locations->count() > 0)
        {
            foreach($locations as $location)
            {                
                $result[] = array('id'=>$location->location_id,'name'=>$location->location_name);
            }

            return $this->sendResponse($result, 'Location List');
        } 
        else
        {
            return $this->sendError('Locations Not Available.', ['error'=>'Data Not Available']);
        }
    }
}