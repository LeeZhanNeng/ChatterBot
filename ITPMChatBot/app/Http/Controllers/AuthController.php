<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserEmailRegister;


class AuthController extends Controller
{
    public function loadRegister(){
        return view('auth/register');
    }

    public function userRegister(Request $request){
        $request->validate([
            'name' => 'string|required|min:2',
            'email' => 'string|email|required|max:100|unique:users',
            'password' => 'string|required|confirmed|min:8'
        ]);
        $existingUserEmailRegister = UserEmailRegister::where('user_email', $request->email)->first();
        if ($existingUserEmailRegister) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->user_type = $existingUserEmailRegister->user_type;
                $user->save();

            return redirect('/')->with('success','Your Registration has been Successful!');
        }
        else{
            return back()->with('error','Your Email is not Apply by Admin Side!');
        }
    }

    public function requestResetPassword(Request $request){
        return view('auth.passwords.reset');
    }

    public function checkResetPassword(Request $request){
        $request->validate([
            'email' => 'string|email|required|max:100',
            'password' => 'string|required|confirmed|min:8'
        ]);
        $user=User::where('email','=',$request->email)->first();

        if ($user) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
    
            return redirect()->route('login')->with('success', 'Password reset successful. Please log in.');
        } else {
            return redirect()->back()->withInput()->withErrors(['email' => 'User not found.']);
        }
    }

    public function loadLogin(){
        return view('auth/login');
    }

    public function userLogin(Request $request){
        $request->validate([
            'email' => 'string|required',
            'password' => 'string|required'
        ]);

        $userCredential = $request->only('email','password');
        if(Auth::attempt($userCredential)){
            
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('loadAdminRegister');
            }
            else if(Auth::user()->user_type == 'lecturer'){
                return redirect()->route('home');
            }
            else if(Auth::user()->user_type == 'student'){
                return redirect()->route('home');
            }
        }
        else{
            return back()->with('error', 'Your or Password is incorrect!');
        }
    }

    public function logout(Request $request){
        Session::flush();
        Auth::logout();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
