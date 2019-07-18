<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;



class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'admin'=>1])){
                $request->session()->put('adminSession', $data['email']);
                return redirect('admin/dashboard');
            }else {                
                return redirect('/admin')->with('flash_message_error', 'Invalid username or password');                
            }
        }
        return view("admin.admin_login");
    }
    
    public function dashboard(Request $request){
        /* Sesssion approach **/
        // if($request->session()->has('adminSession')){
            // return  view('admin.dashboard');
        // }
        // return redirect('/admin')->with('flash_message_error', 'Please login to access....!');

        return  view('admin.dashboard');
        
    }

    public function logout(Request $request){
    //    $request->session()->flash('flash_message_success', 'Logout successfully!');
       $request->session()->flush();
       return redirect('/admin')->with('flash_message_success', 'Logout successfully!');
    }

    public function settings(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $current_password = $data['current_pwd'];
            $check_password = User::where(['email'=> Auth::user()->email])->first();
            if(Hash::check($current_password, $check_password->password)){
                $password = bcrypt($data['new_pwd']);
                User::where(['email'=> Auth::user()->email])->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success','Password updated successfully');
            }else {
                return redirect('/admin/settings')->with('flash_message_error','Password updated failed');
            }
        }else{
            return view('admin.settings');
        }
        
    }

    public function chkPassword(Request $request){
        $data = $request->all();
        
        $current_password = $data['current_pwd'];
        $check_pwd = User::where(['admin'=>1])->first();
        // echo $check_pwd->password;exit;
        if(Hash::check($current_password, $check_pwd->password)){
            echo "true";die;
        }else {
            echo "false";die;
        }
      

    }
}

?>