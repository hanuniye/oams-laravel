<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Pateint;
use Illuminate\Http\Request;

class PateintController extends Controller
{
    public function index()
    {
        return view("pateints.index");
    }

    public function store(Request $req)
    {
        $formField = $req->validate([
            "name" => "required",
            "fullname" => "required",
            "contact" => "required",
            "gender" => "required",
            "birth_date" => "required",
            "age" => "required",
            "doctor_id" => "required"
        ]);

        Pateint::create($formField);

        return [
            "status" => true,
            "massege" => "seccessfuly added"
        ];
    }

    public function getAll()
    {
        if(auth()->user()->role == "admin"){
            $data = Pateint::all();
            
            foreach ($data as $item) {
                $item["doctor_id"] = $item->docPateint->name;
                $item["action"] =
                    "<td><i onclick='getUser($item->id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
                <td><i onclick='deleteUser($item[id])'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
                if($item["status"] == "booked"){
                    $item["status"] = "<span class='badge bg-success'>$item->status</span>";
                }
                elseif ($item["status"] == "confirmed") {
                    $item["status"] = "<span class='badge bg-primary'>$item->status</span>";
                } else {
                    $item["status"] = "<span class='badge bg-danger'>$item->status</span>";
                }

            }
            return $data;
        }
        else{
            $doctor = Doctor::where("user_id",auth()->user()->id)->first();

            foreach ($doctor->patient as $item) {
                $item["doctor_id"] = $doctor->name;
                $item["action"] =
                    "<td><i onclick='getUser($item->id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
                <td><i onclick='deleteUser($item[id])'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
                if($item["status"] == "booked"){
                    $item["status"] = "<span class='badge bg-success'>$item->status</span>";
                }
                elseif ($item["status"] == "confirmed") {
                    $item["status"] = "<span class='badge bg-primary'>$item->status</span>";
                } else {
                    $item["status"] = "<span class='badge bg-danger'>$item->status</span>";
                }

            }
            return $doctor->patient;
        }

    }

    public function getOneUser($id)
    {
        $data = Pateint::find($id);

        $data["doctor_name"] = $data->docPateint->name;
        return $data;
    }

    public function update($id, Request $req)
    {
        if(auth()->user()->role != "admin"){
            $formField = $req->validate([
                "status" => "required"
            ]);

            $data = Pateint::find($id);
            $data->update($formField);

        }
        else{
            $formField = $req->validate([
                "name" => "required",
                "fullname" => "required",
                "contact" => "required",
                "gender" => "required",
                "birth_date" => "required",
                "age" => "required",
                "doctor_id" => "required",
                "status" => "required"
            ]);


            $data = Pateint::find($id);
            $data->update($formField);
        }


        return [
            "status" => true,
            "massege" => "seccessfuly updated"
        ];
    }
    public function delete($id){
        $data = Pateint::find($id);
        $data->delete();
    }

    public function doctor($id){
        $data = Doctor::where("specialist_id",$id)->get();
        return $data;
    }
}
