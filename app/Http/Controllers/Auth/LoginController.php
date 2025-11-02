<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

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

    public function showPasswordForm(){
        return view('forgotPassword');
    }

    public function submitForgotPasswordForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:admin'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email'=> $request->input('email'),
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('email.forgotPassword',['token' => $token], function($message) use($request){
            $message->to($request->input('email'))->subject('Reset Password');
        });

        return back()->with('message', 'We have emailed you reset password link');
    }

    public function showResetPasswordForm($token){
        return view('forgotPasswordLink',['token'=> $token]);
    }

    public function submitResetPasswordForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:admin',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $password_reset_request = DB::table('password_resets')->where('email', $request->input('email'))->where('token', $request->token)->first();
        
        if(!$password_reset_request){
            return back()->with('error','Invalid token!');
        }

        AdminModel::where('email', $request->input('email'))->update(['password'=> Hash::make($request->input('password'))]);
        
        DB::table('password_resets')->where('email', $request->input('email'))->delete();

        return redirect('/')->with('message','Your password has been changed!');
    }
}
