<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Customer;
   
class StaffClientController extends BaseController
{
    public function index(Request $request)
    {
        $clients = Customer::where('customer_status',1)->orderby('customer_name','asc')->get();

        if($clients->count() > 0)
        {
            foreach($clients as $client)
            {                
                $result[] = array('id'=>$client->customer_id,'name'=>$client->customer_name);
            }

            return $this->sendResponse($result, 'Client List');
        } 
        else
        {
            return $this->sendError('Clients Not Available.', ['error'=>'Data Not Available']);
        }
    }
}