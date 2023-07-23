<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class RestPasswordController extends Controller
{
    public function index(){
        return view('auth.forget_password');
    }
    public function sendEmail(Request $request)
    {
        $request->validate(['email'=>'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

                return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

            public function resetForm($token)
            {
                return view('auth.reset_password',compact('token'));
            }
            public function resetPassword(Request $request)
            {
                $request->validate([
                    'token' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:8|confirmed',
                ]);
                $status = Password::reset(
                    $request->only('email', 'password', 'password_confirmation', 'token'),
                    function (User $user, string $password) {
                        $user->forceFill([
                            'password' => Hash::make($password)
                        ])->setRememberToken(Str::random(60));

                        $user->save();

                        event(new PasswordReset($user));
                    }

                );
                return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->back()->with('mgs','you couldn`t reset !!');

            }
}
