<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCustomerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function registerCustomer(RegisterCustomerRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        return response()->json(['message' => 'Registration successfull. Your Profile Under Verifiction!']);
    }
    public function login()
    {
        return view('auth.login');
    }
    public function login_auth(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    if($user->status == 1){
                        return redirect()->route($user->role);
                    }else if($user->status == 0){
                        Auth::logout();
                        return redirect()->route('login')->with('error','Your profile is under verification!');
                    }else if($user->status == 2){
                        Auth::logout();
                        return redirect()->route('login')->with('error','Your profile is blocked by Admin!');
                    }


                }
            } else {
                return back()->withErrors(['password' => 'Invalid Password'])->withInput($request->only('email'));
            }
        } else {
            return back()->withErrors(['email' => 'Invalid Email'])->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
