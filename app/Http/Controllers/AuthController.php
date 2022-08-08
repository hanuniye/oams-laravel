<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view("login.login");
    }

    public function authanticate(Request $req){
        $formField = $req->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if(Auth()->attempt($formField)){
            $req->session()->regenerate();
            return redirect("layout");
        }
        else{
            return redirect("login");
        }
    }

    public function logout(){
        Auth()->logout();
        return redirect("login");
    }
}
