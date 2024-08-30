<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Mail;
use App\Models\Staff;

class StaffLoginController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['staff_email' => 'required|email',
                      'staff_password' => 'required'];
            
            $messages = ['staff_email.required' => 'Please Enter Email Address',
                         'staff_email.email' => 'Please Enter Valid Email Address',
                         'staff_password.required' => 'Please Enter Password'];
            
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['staff_email'] = $request->staff_email;
                $where['password'] = $request->staff_password;
                
                if(Auth::guard('staff')->attempt($where))
                {
                    if(Auth::guard('staff')->user()->staff_status == 1)
                    {
                        return redirect('staff/dashboard');
                    }
                    else
                    {
                        Auth::guard('staff')->logout();

                        return redirect('staff')->with('error','Invalid Email or Password!')->withInput();
                    }
                }
                else
                {
                    return redirect('staff')->with('error','Invalid Email or Password!')->withInput();
                }
            }
        }

        $data['set'] = 'login';
        return view('staff.login.login',$data);
    }

    public function forgot_password(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['staff_email' => 'required|email'];
            
            $messages = ['staff_email.required' => 'Please Enter Email Address',
                         'staff_email.email' => 'Please Enter Valid Email Address',
                        ];
                        
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $staff = Staff::where('staff_email',$request->staff_email)->first();
                
                if(isset($staff))
                {
                    $mail  = $request->staff_email;

                    $uname = $data['name'] = $staff->staff_fname;
                    $data['password'] = base64_decode($staff->staff_vpassword);
                    
                    $send = Mail::send('staff.mail.forgot_password', $data, function($message) use ($mail, $uname){
                         $message->to($mail, $uname)->subject(config('constants.site_title').' - Forgot Password');
                         $message->from(config('constants.mail_from'),config('constants.site_title'));
                      });
                      
                    return redirect('staff')->with('success','Please Check Your Email');
                }
                else
                {
                    return redirect('staff_forgot_password')->with('error','Invalid Email Address')->withInput();
                }
            }
        }

        return view('staff.login.forgot_password');
    }
}