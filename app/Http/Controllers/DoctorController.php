<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index()
    {
        return view("doctors.index");
    }

    public function store(Request $req)
    {
        $req->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "contact" => "required",
            "password" => "required",
            "expreince" => "required",
            "specialist" => "required",
            "age" => "required"
        ]);

        DB::beginTransaction();
        
        $users = User::create([
            "name" => $req->input("name"),
            "email" => $req->input("email"),
            "password" => bcrypt($req->input("password")),
            "role" => "doctor"
        ]);

        if ($req->hasFile("image")) {
            Doctor::create([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
                "age" => $req->input("age"),
                "user_id" => $users->id,
                "specialist_id" => $req->input("specialist"),
                "exprience" => $req->input("expreince"),
                "image" => $req->file("image")->store("images", "public")
            ]);
        } else {
            Doctor::create([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
                "user_id" => $users->id,
                "specialist_id" => $req->input("specialist"),
                "exprience" => $req->input("expreince"),
                "image" => "images/noimage.jpg"
            ]);
        }

        DB::commit();

        return [
            "status" => true,
            "massege" => "seccessfuly added"
        ];
    }

    public function getAll()
    {
        if (auth()->user()->role == "admin") {
            $data = Doctor::all();

            foreach ($data as $item) {
                $item["email"] = $item->userDoctor->email;
                $item["specialist_id"] = $item->specDoctor->name;
                $item["action"] =
                    "<td><i onclick='getUser($item->user_id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
                <td><i onclick='deleteUser($item[id])'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
                $item["image"] = "<img src='storage/$item->image' class='img'>";
            }

            return $data;
        }

        else {
            $doctor = Doctor::where("user_id", auth()->user()->id)->get();

            foreach($doctor as $item){
                $item["email"] = $item->userDoctor->email;
                $item["specialist_id"] = $item->specDoctor->name;
                $item["action"] =
                    "<td><i onclick='getUser($item->user_id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
            <td><i onclick='deleteUser($item->id)'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
                $item["image"] = "<img src='storage/$item->image' class='img'>";
            }


            return $doctor;
        }
    }

    public function getOneUser($id)
    {
        $data = Doctor::where("user_id", $id)->first();
        $user = User::find($id);
        $data["email"] = $user->email;
        $data["password"] = $user->password;
        return $data;
    }

    public function update($id, Request $req)
    {
        $pswd = "";
        if(isset($_POST["doctorPswd"])){
            $pswd = $_POST["doctorPswd"];
        }

        if (auth()->user()->role == "admin") {
            $formField = $req->validate([
                "name" => "required",
                "email" => "required",
                "contact" => "required",
                "password" => "",
                "expreince" => "required",
                "specialist" => "required",
                "age" => "required"
            ]);
        } else {
            $formField = $req->validate([
                "name" => "required",
                "contact" => "required",
                "expreince" => "required",
                "specialist" => "required",
                "age" => "required"
            ]);
        }

        if (auth()->user()->role == "admin") {
            DB::beginTransaction();
            if ($req->hasFile("image")) {
                $data = Doctor::where("user_id", $id)->first();
                $data->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                    "age" => $req->input("age"),
                    "specialist_id" => $req->input("specialist"),
                    "exprience" => $req->input("expreince"),
                    "image" => $req->file("image")->store("images", "public")
                ]);
            } else {
                $data = Doctor::where("user_id", $id)->first();
                $data->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                    "age" => $req->input("age"),
                    "specialist_id" => $req->input("specialist"),
                    "exprience" => $req->input("expreince"),
                ]);
            }


            $user = User::find($id);
            if($formField['password']){
                $user->update([
                    "name" => $req->input("name"),
                    "email" => $req->input("email"),
                    "password" => bcrypt($req->input("password")),
                ]);
            }else{
                $user->update([
                    "name" => $req->input("name"),
                    "email" => $req->input("email"),
                    "password" => $pswd,
                ]);
            }

            DB::commit();
        } else {
            DB::beginTransaction();
            if ($req->hasFile("image")) {
                $data = Doctor::where("user_id", $id)->first();
                $data->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                    "age" => $req->input("age"),
                    "specialist_id" => $req->input("specialist"),
                    "exprience" => $req->input("expreince"),
                    "image" => $req->file("image")->store("images", "public")
                ]);
            } else {
                $data = Doctor::where("user_id", $id)->first();
                $data->update([
                    "name" => $req->input("name"),
                    "contact" => $req->input("contact"),
                    "age" => $req->input("age"),
                    "specialist_id" => $req->input("specialist"),
                    "exprience" => $req->input("expreince"),
                ]);
            }

            $data = User::find($id);
            $data->update([
                "name" => $req->input("name"),
            ]);
            DB::commit();
        }

        return [
            "status" => true,
            "massege" => "seccessfuly updated"
        ];
    }
    public function delete($id)
    {
        $data = Doctor::find($id);
        $data->delete();
    }

}
