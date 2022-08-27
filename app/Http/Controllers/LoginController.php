<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    public function postlogin (Request $request){
    // dd($request->all());    
        if (Auth::attempt($request->only('username','password'))){
            if (auth()->user()->level=="admin_mhs"){
                return redirect()->route('dashboard_admin');
            }else{

            }
            if (auth()->user()->level=="bem"){
                return redirect()->route('dashboard_bem');
            }else{

            }
            if (auth()->user()->level=="ormawa"){
                return redirect()->route('dashboard_ormawa');
            }else{

            }
            

            
        }
        return redirect ('login');
    }
    public function logout (Request $request){
        Auth::logout();
            return redirect ('/');
        }
     
}