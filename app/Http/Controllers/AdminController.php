<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view("admin.index");
    }

    public function store(Request $req)
    {

        $req->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "contact" => "required",
            "password" => "required",
        ]);

        DB::beginTransaction();

        if($req->hasFile("image")){
            $users = User::create([
                "name" => $req->input("name"),
                "email" => $req->input("email"),
                "password" => bcrypt($req->input("password")),
                "role" => "admin",
                "image" => $req->file("image")->store("images", "public")
            ]);
        }
        else{
            $users = User::create([
                "name" => $req->input("name"),
                "email" => $req->input("email"),
                "password" => bcrypt($req->input("password")),
                "role" => "admin",
            ]);
        }

        if ($req->hasFile("image")) {
            Admin::create([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
                "user_id" => $users->id,
                "image" => $req->file("image")->store("images", "public")
            ]);
        } else {
            Admin::create([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
                "user_id" => $users->id,
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
        $data = Admin::all();

        foreach ($data as $item) {
            $item["email"] = $item->userAdmin->email;
            $item["action"] =
                "<td><i onclick='getUser($item->user_id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
            <td><i onclick='deleteUser($item[id])'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
            $item["image"] = "<img src='storage/$item->image' class='img'>";
        }
        return $data;
    }

    public function getOneUser($id)
    {
        $data = Admin::where("user_id", $id)->first();
        $user = User::find($id);
        $data["email"] = $user->email;
        $data["password"] = $user->password;
        return $data;
    }

    public function update($id, Request $req)
    {
        $req->validate([
            "name" => "required",
            "email" => "required",
            "contact" => "required",
            "password" => "required",
        ]);

        DB::beginTransaction();
        if ($req->hasFile("image")) {
            $admin = Admin::where("user_id", $id)->first();
            $admin->update([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
                "image" => $req->file("image")->store("images", "public")
            ]);
        } else {
            $admin = Admin::where("user_id", $id)->first();
            $admin->update([
                "name" => $req->input("name"),
                "contact" => $req->input("contact"),
            ]);
        }


        $user = User::find($id);
        if($req->hasFile("image")){
            $user->update([
                "name" => $req->input("name"),
                "email" => $req->input("email"),
                "password" => bcrypt($req->input("password")),
                "image" => $req->file("image")->store("images", "public")
            ]);
        }
        else{
            $user->update([
                "name" => $req->input("name"),
                "email" => $req->input("email"),
                "password" => bcrypt($req->input("password")),
            ]);
        }
      
        DB::commit();

        return [
            "status" => true,
            "massege" => "seccessfuly updated"
        ];
    }
    public function delete($id){
        $data = Admin::find($id);
        $data->delete();
    }
}