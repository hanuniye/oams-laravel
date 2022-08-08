<?php

namespace App\Http\Controllers;

use App\Models\schedule;
use Illuminate\Http\Request;

class scheduleController extends Controller
{
    public function index(){
        return view("schedule.index");
    }

    public function store(Request $req){
        $formField = $req->validate([
            "day" => "required",
            "start_time" => "required",
            "end_time" => "required",
            "doctor_id" => "required"
        ]);

        schedule::create($formField);

        return [
            "status" => true,
            "data" => "seccessfuly added"
        ];
    }

    public function getAll(){
        $data = schedule::all();

        foreach($data as $item){
            $item["doctor_id"] = $item->schedDoctor->name;
            $item["action"] = "<td><i onclick='getUser($item->id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
            <td><i onclick='deleteUser($item[id])'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
        }
        return $data;
    }

    public function getOneUser($id){
        $data = schedule::find($id);
        $data["doctor_name"] = $data->schedDoctor->name;

        return $data;
    }

    public function update(Request $req,$id){
        $formField = $req->validate([
            "day" => "required",
            "start_time" => "required",
            "end_time" => "required",
            "doctor_id" => "required"
        ]);

        $data = schedule::find($id);
        $data->update($formField);

        return [
            "status" => true,
            "data" => "seccessfuly updated"
        ];
    }

    public function delete($id){
        $data = schedule::find($id);
        $data->delete();
    }
}
