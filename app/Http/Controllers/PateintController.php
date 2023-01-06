<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Pateint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PateintController extends Controller
{
    public function index()
    {
        return view("pateints.index");
    }

    public function getAll()
    {
            $data = Pateint::all();

            foreach ($data as $item) {
                $item["doctor_name"] = $item->doctor->name;
                $item["action"] =
                    "<td><i onclick='getUser($item->id)' class='fa-solid fa-pen-to-square text-success' style='font-size:20px; cursor:pointer;'></i></td>
                <td><i onclick='deleteUser($item[id])'  class='fa-solid fa-circle-minus text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
                if($item["status"] == "booked"){
                    $item["status"] = "<span class='badge bg-warning'>$item->status</span>";
                }
                elseif ($item["status"] == "in-process") {
                    $item["status"] = "<span class='badge bg-primary'>$item->status</span>";
                }
                elseif ($item["status"] == "completed") {
                    $item["status"] = "<span class='badge bg-success'>$item->status</span>";
                }
                else {
                    $item["status"] = "<span class='badge bg-danger'>$item->status</span>";
                }

            }
            return $data;
    }

    public function getOneUser($id)
    {
        $data = Pateint::find($id);

        $data["doctor_name"] = $data->doctor->name;
        $data["specialist"] = $data->doctor->specialist_id;
        return $data;
    }

    public function update(Request $req,$id)
    {
            $formField = $req->validate([
                "name" => "required",
                "fullname" => "required",
                "contact" => "required",
                "gender" => "required",
                "birth_date" => "required",
                "age" => "required",
                "doctor_id" => "required",
            ]);

            DB::beginTransaction();

            $pateint = Pateint::find($id);
            $pateint->update($formField);

            $appoint = Appointment::where("pateint_id",$id)->first();

            $appoint->update([
                "doctor_id" => $req->input("doctor_id")
            ]);

            DB::commit();


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
