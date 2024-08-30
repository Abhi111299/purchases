<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['admin_name' => 'required',
                      'admin_email' => 'required|email',
                      'admin_phone' => 'required'
                      ];
                
            $messages = ['admin_name.required' => 'Please Enter Name',
                         'admin_email.required' => 'Please Enter Email Address',
                         'admin_email.email' => 'Please Enter Valid Email Address',
                         'admin_phone.required' => 'Please Enter Phone'
                        ];
            
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_email['admin_email'] = $request->admin_email;
                
                $check_email = Admin::where($where_email)->where('admin_id','!=',Auth::guard('admin')->user()->admin_id)->count();
                
                if($check_email > 0)
                {
                    return redirect()->back()->with('error','Email Address Already Exists')->withInput();
                }                            
                                
                $upd['admin_name']       = $request->admin_name;
                $upd['admin_email']      = $request->admin_email;
                $upd['admin_phone']      = $request->admin_phone;
                $upd['admin_updated_on'] = date('Y-m-d H:i:s');
                $upd['admin_updated_by'] = Auth::guard('admin')->user()->admin_id;

                if($request->hasFile('admin_image'))
                {
                    $admin_image = $request->admin_image->store('assets/admin/uploads/profile');
                    
                    $admin_image = explode('/',$admin_image);
                    $admin_image = end($admin_image);
                    $upd['admin_image'] = $admin_image;
                }
                
                $admin = Admin::where('admin_id',Auth::guard('admin')->user()->admin_id)->update($upd);

                return redirect()->back()->with('success','Details Updated Successfully');
            }
        }

        $data['set'] = 'profile';
        return view('admin.profile.profile',$data);
    }

    public function change_password(Request $request)
    {        
        if($request->has('submit'))
        {            
            $rules = ['old_password' => 'required',
                      'new_password' => 'required',
                      'confirm_password' => 'required|same:new_password'];
                      
            $messages = ['old_password.required' => 'Please Enter Old Password',
                         'new_password.required' => 'Please Enter New Password',
                         'confirm_password.required' => 'Please Enter Confirm Password'];
          
            $validator = Validator::make($request->all(),$rules,$messages);
            
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['admin_id'] = Auth::guard('admin')->user()->admin_id;
                $where['admin_vpassword'] = base64_encode($request->old_password);
        
                $check = Admin::where($where)->count();
                
                if($check > 0)
                {
                    $upd['admin_password']   = bcrypt($request->confirm_password);
                    $upd['admin_vpassword']  = base64_encode($request->confirm_password);
                    $upd['admin_updated_on'] = date('Y-m-d H:i:s');
                    $upd['admin_updated_by'] = Auth::guard('admin')->user()->admin_id;

                    $update = Admin::where('admin_id',Auth::guard('admin')->user()->admin_id)->update($upd);
                    
                    return redirect()->back()->with('success','Password Changed Successfully');
                }
                else
                {
                    return redirect()->back()->with('error','Old Password Does Not Match');
                }
            }
        }
    }

    public function check_old_password(Request $request)
    {   
        $where['admin_id']  = Auth::guard('admin')->user()->admin_id;
        $where['admin_vpassword'] = base64_encode($request->old_password);
        
        $check = Admin::where($where)->count();

        if($check > 0)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }
}
