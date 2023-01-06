<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pateint;
use App\Models\Reception;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class ReceptionController extends Controller
{
    public function index(){
        return view("reception.index");
    }

    public function store(Request $req){
        $req->validate([
            'name' => "required",
            "email" => 'required|email|unique:users,email',
            "password" => "required",
            "contact" => "required"
        ]);

        DB::beginTransaction();

        $user = User::create([
            "name" => $req->input("name"),
            "email" => $req->input("email"),
            "contact" => $req->input("contact"),
            "password" =>bcrypt($req->input("password")) ,
            "role" => "receptionist",
        ]);

        $role = Role::findByName("receptionist");

        $user->assignRole($role);

        if($req->hasFile("image")){
            Reception::create([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
                "image" => $req->file("image")->store("images","public"),
                "user_id" => $user->id
            ]);
        }else{
            Reception::create([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
                "user_id" => $user->id
            ]);
        }

        DB::commit();

        return [
            "status" => true,
            "data" => "seccessfuly added"
        ];
    }

    public function getAll(){
        $data = Reception::all();
        $id = 0;

        foreach($data as $item){
            $id++;
            $item['email'] = $item->user->email;
            $item["receptionId"] = $id;

            if(Auth()->user()->role === "admin"){
                $item["action"] =
                "<td><i onclick='getUser($item->user_id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
                <td><i onclick='deleteUser($item->user_id)'  class='fa-solid fa-trash text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
                $item["image"] = "<img src='storage/$item->image' class='img'>";
            }
            if(Auth()->user()->role === "receptionist"){
                $item["action"] =
                "<td><i onclick='getUser($item->user_id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
                <td><i onclick='deleteUser($item->id)'  class='fa-solid fa-trash text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
                $item["image"] = "<img src='storage/$item->image' class='img'>";
            }
        }

        return $data;
    }

    public function getOneUser($id){
        $data = Reception::where("user_id", $id)->first();

        $data['email'] = $data->user->email;
        $data['password'] = $data->user->password;
        return $data;
    }

    public function update(Request $req, $id){
        $pswd = "";

        if(isset($_POST["receptionPswd"])){
            $pswd = $_POST["receptionPswd"];
        }

        if(Auth()->user()->role == "admin"){
            $formField = $req->validate([
                "name" => "required",
                "email" => "required|email",
                "contact" => "required",
                "password" => ""
            ]);
        }else{
            $formField = $req->validate([
                "name" => "required",
                "contact" => "required",
            ]);
        }

        if(Auth()->user()->role == "admin"){
            DB::beginTransaction();
            $reception = Reception::where("user_id",$id)->first();
            if($req->hasFile("image")){
                $reception->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                    "image" => $req->file("image")->store("images","public"),
                ]);
            }else
            {
                $reception->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                ]);
            }

            $user = User::find($id);
            if($formField["password"]){
                $user->update([
                    "name" => $req->input("name"),
                    "email" => $req->input("email"),
                    "password" => bcrypt($req->input("password")),
                ]);
            }
            else{
                $user->update([
                    "name" => $req->input("name"),
                    "email" => $req->input("email"),
                    "password" => $pswd,
                ]);
            }

            DB::commit();
        }
        else{
            DB::beginTransaction();
            $reception = Reception::where("user_id",$id)->first();

            if($req->hasFile("image")){
                $reception->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                    "image" => $req->file("image")->store("images","public"),
                ]);
            }
            else{
                $reception->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                ]);
            }

            $user = User::find($id);
            $user->update([
                "name" => $req->input("name"),
            ]);
            DB::commit();

        }



        return [
            "status" => true,
            "data" => "seccessfuly updated"
        ];

    }

    public function delete($id){
        DB::beginTransaction();
        $reception = Reception::where("user_id",$id)->first();
        $reception->delete();

        $user = User::find($id);
        $user->delete();
        DB::commit();
    }

    public function updateStatus($id){
        $status = "";
        $type = "";
        if(isset($_POST['status'])){
            $status = $_POST['status'];
            $type = $_POST['type'];
        }

        DB::beginTransaction();
        $appoint = Appointment::where("pateint_id",$id)->first();

        $appoint->status = $status;
        $appoint->type = $type;
        $appoint->save();

        $pateint = Pateint::find($id);

        $pateint->status = $status;
        $pateint->save();

        DB::commit();

        return [
            "status" => true,
            "data" => "seccesfuly updated"
        ];
    }

}
