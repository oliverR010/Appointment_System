<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        if(Auth::User()->account_type=='admin'){
       
            return view ('scanner');
        }else if(Auth::User()->account_type=='user'){
            alert()->success('Login Successful!','')->showConfirmButton(false)->buttonsStyling(false)->autoClose(2000);
              return redirect()->route('calendar');
        }else if(Auth::User()->account_type=='staff'){
            alert()->success('Login Successful!','')->showConfirmButton(false)->buttonsStyling(false)->autoClose(2000);
            return redirect()->route('staff_scanner');
        }
    }

    public function afterlogin(){

        if(Auth::User()->account_type=='admin'){
           
            return view ('scanner');
        }else if(Auth::User()->account_type=='user'){
              return redirect()->route('calendar');
        }else if(Auth::User()->account_type=='staff'){
            return redirect()->route('staff_scanner');
        }else{
            return view ('auth.login');
        }
    }


}
