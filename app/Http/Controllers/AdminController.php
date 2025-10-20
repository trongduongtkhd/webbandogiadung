<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request; 
use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller as BaseController;
session_start();
class AdminController extends BaseController 
{
  public function index(Request $request){
    if ($request->has('clear_message')) {
        Session::forget('message');
    }
    return view('admin_login');
}
    public function show_dashboard(){
      
        return view('admin.admin_dashboard');
    }
    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $password =$request->admin_password;
        $result = DB::table('tbl_admin')
        ->where('admin_email', $admin_email)
        ->where('password', $password)
        ->first();
        if($result){
            Session::put('admin_name', $result->admin_name);
            Session::put('admin_id', $result->admin_id);
            Session::forget('message');
            return Redirect::to('/admin/dashboard');
        }else{
             Session::put('message','Mật khẩu hoặc tài khoản không đúng. Vui lòng thử lại!');
            return Redirect::to('/admin');
        }
    }
     public function logout(){       
            Session::flush();
            return Redirect::to('/admin');
    }


}