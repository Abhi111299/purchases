<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Mail;
use App\Models\Admin;

class AdminLoginController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['admin_email' => 'required|email',
                      'admin_password' => 'required'];
            
            $messages = ['admin_email.required' => 'Please Enter Email Address',
                         'admin_email.email' => 'Please Enter Valid Email Address',
                         'admin_password.required' => 'Please Enter Password'];
            
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['admin_email'] = $request->admin_email;
                $where['password'] = $request->admin_password;
                
                if(Auth::guard('admin')->attempt($where))
                {
                    if(Auth::guard('admin')->user()->admin_status == 1)
                    {
                        return redirect('admin/dashboard');
                    }
                    else
                    {
                        Auth::guard('admin')->logout();

                        return redirect('/')->with('error','Invalid Email or Password!')->withInput();
                    }
                }
                else
                {
                    return redirect('/')->with('error','Invalid Email or Password!')->withInput();
                }
            }
        }

        $data['set'] = 'login';
        return view('admin.login.login',$data);
    }

    public function forgot_password(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['admin_email' => 'required|email'];
            
            $messages = ['admin_email.required' => 'Please Enter Email Address',
                         'admin_email.email' => 'Please Enter Valid Email Address',
                        ];
                        
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $admin = Admin::where('admin_email',$request->admin_email)->first();
                
                if(isset($admin))
                {
                    $mail  = $request->admin_email;

                    $uname = $data['name'] = $admin->admin_name;
                    $data['password'] = base64_decode($admin->admin_vpassword);

                    $send = Mail::send('admin.mail.forgot_password', $data, function($message) use ($mail, $uname){
                         $message->to($mail, $uname)->subject(config('constants.site_title').' - Forgot Password');
                         $message->from(config('constants.mail_from'),config('constants.site_title'));
                      });
                      
                    return redirect('/')->with('success','Please Check Your Email');
                }
                else
                {
                    return redirect('forgot_password')->with('error','Invalid Email Address')->withInput();
                }
            }
        }

        return view('admin.login.forgot_password');
    }
}