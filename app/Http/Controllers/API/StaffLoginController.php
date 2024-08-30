<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\Staff;
   
class StaffLoginController extends BaseController
{
    public function index(Request $request)
    {
        $rules = ['email' => 'required|email',
                  'password' => 'required'];
            
        $messages = ['email.required' => 'Please Enter Email Address',
                     'email.email' => 'Please Enter Valid Email Address',
                     'password.required' => 'Please Enter Password'];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $where['staff_email'] = $request->email;
            $where['password'] = $request->password;

            if(Auth::guard('staff')->attempt($where))
            {
                $staff = Auth::guard('staff')->user();
                $result['token'] = $staff->createToken('Appvane')-> accessToken;
                $result['name'] = $staff->staff_fname.' '.$staff->staff_lname;
    
                return $this->sendResponse($result, 'User login successfully.');
            } 
            else
            {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } 
    }
}