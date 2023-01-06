<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Pateint;
use App\Models\schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class doctorViewController extends Controller
{

    public function index(){
        return view("appointment.doctorview");
    }

    public function getAllDoctors(){
        $data = Doctor::all();

        foreach($data as $item){
            $item["email"] = $item->userDoctor->email;
            $item["specialist_name"] = $item->specDoctor->name;
        }
        return $data;
    }

    public function getDoctorSched($id){
        $data = schedule::where("doctor_id",$id)->get();

        foreach($data as $item){
            $item["doctor_name"] = $item->schedDoctor->name;
        }
        return $data;
    }

    public function setAppoint(){
        return view("appointment.setAppointment");
    }

    public function myappointment(){
        return view("appointment.myAppointmen");
    }

    public function createAppoint(Request $req){
        $formField = $req->validate([
            "date" => "required",
            "time" => "required",
            "reason" => "required",
            "user_id" => "required",
            "doctorId" => "required"
        ]);

        DB::beginTransaction();

        $pateint = Pateint::where("user_id",$formField["user_id"])->first();
        Appointment::create([
            "date" => $req->input("date"),
            "time" => $req->input("time"),
            "reason" => $req->input("reason"),
            "doctor_id" => $req->input("doctorId"),
            "pateint_id" => $pateint->id
        ]);

        $pateintUpdate = Pateint::where("user_id",$formField["user_id"])->first();
        $pateintUpdate->doctor_id = $formField["doctorId"];
        $pateintUpdate->save();

        DB::commit();

        return [
            "status" => true,
            "data" => "seccesfuly added"
        ];

    }

    public function getMyAppointment($id){
        $pateint = Pateint::where('user_id',$id)->first();

        $data = Appointment::where("pateint_id",$pateint->id)->get();

        foreach($data as $item){
            if($item->status === "booked"){
                $item["status"] = "<span class='badge bg-warning'>$item->status</span>";
            }
            if($item->status === "in-process"){
                $item["status"] = "<span class='badge bg-primary'>$item->status</span>";
            }
            if($item->status === "completed"){
                $item["status"] = "<span class='badge bg-success'>$item->status</span>";
            }
            if($item->status === "cencel"){
                $item["status"] = "<span class='badge bg-danger'>$item->status</span>";
            }

            $item["doctor_name"] = $item->doctor->name;
            $item["pateint_name"] = $item->pateint->name;
            $item["contact"] = $item->pateint->contact;

            $specialist = Specialization::find($item->doctor->specialist_id);
            $item["specialist"] = $specialist->name;
            $item["action"] =
                    "<td><i onclick='printPatient($item->id)' class='fa-solid fa-print text-success' style='font-size:22px; cursor:pointer;'></i></td>
            <td><i onclick='cencelAppoint($item->pateint_id)' class='fa-sharp fa-solid fa-square-xmark text-danger ' style='font-size:22px; cursor:pointer; margin-left:10px;'></i></td>";
        }
        return $data;
    }

    public function updateStatus($id){
        $status = "";
        if(isset($_POST['status'])){
            $status = $_POST['status'];
        }

        DB::beginTransaction();
        $appoint = Appointment::where("pateint_id",$id)->first();

        $appoint->status = $status;
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
