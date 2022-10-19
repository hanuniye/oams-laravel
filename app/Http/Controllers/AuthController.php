<?php

namespace App\Http\Controllers;

use App\Models\Pateint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            if(Auth()->user()->role == "pateint"){
                return [
                    "status" => true,
                    "data" => "pateint"
                ];
            }
            else{
                return [
                    "status" => true,
                    "data" => "others"
                ];
            }

        }
        else{
            return [
                "status" => false,
                "data" => "email or password are not match"
            ];
        }
    }

    public function logout(){
        if(Auth()->user()->role == "pateint"){
            Auth()->logout();
            return redirect("/");
        }else{
            Auth()->logout();
            return redirect("/login");
        }

    }

    //into pateint login
    public function toPateintLogin(){
        return view("appointment.pateintlogin");
    }

    // into pateint register
    public function register(){
        return view("appointment.pateintRegist");
    }

    // register pateints
    public function store(Request $req){
        $req->validate([
            "fullname" => "required",
            "username" => "required",
            "email" => "required|email|unique:users,email",
            "age" => "required",
            "password" => "required|confirmed",
            "contact" => "required",
            "birthDate" => "required",
            "gender" => "required",
        ]);

        DB::beginTransaction();
        $user = User::create([
            "name" => $req->input("username"),
            "email" => $req->input("email"),
            "password" => bcrypt($req->input("password")),
            "role" => "pateint",
        ]);

        Pateint::create([
            "fullname" => $req->input("fullname"),
            "name" => $req->input("username"),
            "gender" => $req->input("gender"),
            "birth_date" => $req->input("birthDate"),
            "contact" => $req->input("contact"),
            "age" => $req->input("age"),
            "user_id" => $user->id
        ]);
        DB::commit();

        return [
            "status" => true,
            "data" => "seccessfuly added"
        ];
    }
}
