<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserEmailRegister;

class AdminLoginController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function loadAdminRegister(){
        if(Auth::check()){
            if(Auth::user()->user_type == 'admin') {
                $userEmailRegisters = UserEmailRegister::all();
                return view('admin-auth/admin-register', ['userEmailRegisters' => $userEmailRegisters]);
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
    

    public function adminRegister(Request $request){
        try {
            $request->validate([
                'name' => 'string|required|min:2',
                'email' => 'string|email|required|max:100|unique:user_email_registers,user_email',
                'user_type' => 'required',
            ]);

            $user = new UserEmailRegister();
            $user->user_name = $request->name;
            $user->user_email = $request->email;
            $user->user_type = $request->user_type;
            $user->save();
            return response()->json(['success' => true, 'msg' => 'User added Successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getUserDetail($id){
        $userEmailRegisters = UserEmailRegister::where('id', $id)->get();
    
        return response()->json(['success' => true, 'data' => $userEmailRegisters]);
    }

    public function editAdminRegister(Request $request){
        try {
            $request->validate([
                'editName' => 'string|required|min:2',
                'editEmail' => 'string|email|required|max:100',
                'edit_user_type' => 'required',
            ]);

            $useremail = UserEmailRegister::find($request->user_id);
            $useremail->user_name = $request->editName;
            $useremail->user_email = $request->editEmail;
            $useremail->user_type = $request->edit_user_type;
            $useremail->save();

            return response()->json(['success' => true, 'msg' => 'User updated Successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    //delete Exam
    public function deleteUser(Request $request){
        try{
            UserEmailRegister::where('id',$request->user_id)->delete();

            return response()->json(['success'=>true,'msg'=>'User deleted Successfully!']);
            } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    public function reviewUser(){
        if(Auth::check()){
            if(Auth::user()->user_type == 'admin'){
                $users = User::all();
                return view('admin-auth/user-review', ['users' => $users]);
            }
            else if(Auth::user()->user_type == 'lecturer'){
                return redirect()->route('home');
            }
            else if(Auth::user()->user_type == 'student'){
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function reviewUserGet($id){
        $users = User::where('id', $id)->get();
        return response()->json(['success' => true, 'data' => $users]);
    }

    public function reviewUserEdit(Request $request){
        try {
            $request->validate([
                'name' => 'string|required|min:2',
                'email' => 'string|email|required|max:100',
                'password' => 'string|required|min:8',
            ]);

            $user = User::find($request->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = $request->user_type;
            $user->save();
    
            return response()->json(['success' => true, 'msg' => 'User updated Successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function reviewUserDelete(Request $request){
        try{
            User::where('id',$request->user_id)->delete();
            
            return response()->json(['success'=>true,'msg'=>'User deleted Successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }
}
