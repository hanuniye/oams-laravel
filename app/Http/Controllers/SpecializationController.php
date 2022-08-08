<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialization;

class SpecializationController extends Controller
{
    public function index()
    {
        return view("specialization.index");
    }

    public function store(Request $req)
    {

        $formField = $req->validate([
            "name" => "required",
        ]);

        if($req->hasFile("image")){
            Specialization::create([
                "name" => $req->input("name"),
                "image" => $req->file("image")->store("images","public")
            ]);
        }else{
            Specialization::create([
                "name" => $req->input("name"),
            ]);
        }

        return [
            "status" => true,
            "massege" => "seccessfuly added"
        ];
    }

    public function getAll()
    {
        $data = Specialization::all();

        foreach ($data as $item) {
            $item["image"] = "<img src='storage/$item->image' class='img'>";
            $item["action"] =
                "<td><i onclick='edits($item->id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
            <td><i onclick='deletes($item->id)'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
        }
        return $data;
    }

    public function getOneUser($id)
    {
        $data = Specialization::find($id);
        return $data;
    }

    public function update($id, Request $req)
    {
        $formField = $req->validate([
            "name" => "required",
        ]);

        if($req->hasFile("image")){
            $data = Specialization::find($id);
            $data->update([
                "name" => $req->input("name"),
                "image" => $req->file("image")->store("images","public")
            ]);
        }
        else{
            $data = Specialization::find($id);
            $data->update([
                "name" => $req->input("name"),
            ]);
        }

        return [
            "status" => true,
            "massege" => "seccessfuly updated"
        ];
    }
    public function delete($id){
        $data = Specialization::find($id);
        $data->delete();
    }
}
