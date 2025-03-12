<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function userLogin(){
        return view('userLogin');
    }

    public function sriNet(){
        return view('sriNet');
    }

    public function login(){
        return view('login');
    }

    public function authenticate(Request $request){
        $credentials = $request->only('email', 'password');
    
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
    
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        if ($request->role == 1) { 
            if (Auth::guard('web')->attempt($credentials)) {
                $user = Auth::guard('web')->user();
                Auth::login($user); // Ensure session persistence
                Session::put('role', 1);
                Session::put('email', $request->email);
                return redirect()->route('index');
            }
        } elseif ($request->role == 2) {
            if (Auth::guard('admin')->attempt($credentials)) { // Use admin guard
                $admin = Auth::guard('admin')->user();
                Auth::guard('admin')->login($admin);
                Session::put('role', 2);
                return redirect()->route('sriNet');
            }
        }
    
        return back()->withErrors(['password' => 'Invalid credentials'])->withInput();
    }
    
    
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
