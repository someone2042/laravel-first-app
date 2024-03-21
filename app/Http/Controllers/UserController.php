<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    //
    public function create(){
        return view('users.register');
    }
    public function store(Request $request){
        $formFields=$request->validate([
        'name'=>['required','min:3'],
        'email'=>['required','email',Rule::unique('users','email')],
        'password'=> 'required|confirmed|min:6'
        ]);
        //hash password
        $formFields['password']=bcrypt(($formFields['password']));
        
        $user= User::create($formFields);

        auth()->login($user);
        return redirect('/')->with('message',"Your account has been created");
    }
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', "You have successfully logged out!");
    }
}
