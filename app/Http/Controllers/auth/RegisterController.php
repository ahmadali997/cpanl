<?php

namespace App\Http\Controllers\auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function index()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
       $request->validate([
        'name'=>'required|min:3',
       'email'=>'required|unique:users',
       'password'=>'required|confirmed|min:6'
       ]);
       try {
       // dd($request->all());
       $user=User::Create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
       ]);

        if(Auth::attempt($request->only(['email','password']))){
            event(new Registered($user));
           return redirect()->route('verification.notice');
        }
        else
         {
            return redirect()->back()->with('msg','User not register');
         }

       } catch (\Throwable $th) {
        //  dd($th);
      return redirect()->back()->with('msg','User not register');
          }
    }
}
