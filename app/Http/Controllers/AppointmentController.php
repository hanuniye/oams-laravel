<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Pateint;
use App\Models\schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(){
        return view("appointment.index");
    }

    public function getAll(){
        if(Auth()->user()->role == "doctor"){
            $doctor = Doctor::where("user_id",Auth()->user()->id)->first();
            $appointId = 0;

            $data = Appointment::where("doctor_id",$doctor->id)->get();
            foreach($data as $item){
                $appointId++;
                if($item->status === "booked"){
                    $item["appointstatus"] = "<span class='badge bg-warning'>$item->status</span>";
                }
                if($item->status === "in-process"){
                    $item["appointstatus"] = "<span class='badge bg-primary'>$item->status</span>";
                }
                if($item->status === "completed"){
                    $item["appointstatus"] = "<span class='badge bg-success'>$item->status</span>";
                }
                if($item->status === "cencel"){
                    $item["appointstatus"] = "<span class='badge bg-danger'>$item->status</span>";
                }

                $item["appointId"] = $appointId;
                $item["doctor_name"] = $item->doctor->name;
                $item["pateint_name"] = $item->pateint->fullname;
                $item["contact"] = $item->pateint->contact;
                $specialist = Specialization::find($item->doctor->specialist_id);
                $item["specialist"] = $specialist->name;

                $item["action"] =  "
                <td><i onclick='view($item->pateint_id)'  class='fa-solid fa-eye text-primary ' style='font-size:20px; cursor:pointer;'></i></td>";
            }
            return $data;

        }
        else{
            $data = Appointment::all();
            $id = 0;

            foreach($data as $item){
                $id++;
                if($item->status === "booked"){
                    $item["appointstatus"] = "<span class='badge bg-warning'>$item->status</span>";
                }
                if($item->status === "in-process"){
                    $item["appointstatus"] = "<span class='badge bg-primary'>$item->status</span>";
                }
                if($item->status === "completed"){
                    $item["appointstatus"] = "<span class='badge bg-success'>$item->status</span>";
                }
                if($item->status === "cencel"){
                    $item["appointstatus"] = "<span class='badge bg-danger'>$item->status</span>";
                }
                $item["appointId"] = $id;
                $item["doctor_name"] = $item->doctor->name;
                $item["pateint_name"] = $item->pateint->fullname;
                $item["contact"] = $item->pateint->contact;
                $specialist = Specialization::find($item->doctor->specialist_id);
                $item["specialist"] = $specialist->name;

               if(Auth()->user()->role == "admin"){
                    $item["action"] =  "
                    <td><i onclick='deleteUser($item->id)'  class='fa-solid fa-trash text-danger ' style='font-size:20px; cursor:pointer;'></i></td>";
               }
               else{
                    if($item->status != "completed"){
                        $item["action"] =  "
                    <td><i onclick='updateStatus($item->pateint_id)'  class='fa-solid fa-pen-to-square  text-primary ' style='font-size:20px; cursor:pointer;'></i></td>";
                    }
                    else{
                        $item["action"] =  "
                        <td><i class='fa-solid fa-pen-to-square  text-primary ' style='font-size:20px; cursor:pointer;'></i></td>";
                    }
               }

            }
            return $data;
        }
    }

    public function viewAppoint($id){
        $data = Appointment::where("pateint_id",$id)->first();

        $data["doctor_name"] = $data->doctor->name;
        $data["pateint_name"] = $data->pateint->fullname;
        $data["contact"] = $data->pateint->contact;
        $specialist = Specialization::find($data->doctor->specialist_id);
        $data["specialist"] = $specialist->name;

        return $data;
    }

    public function delete($id){
        $data = Appointment::find($id);
        $data->delete();

        return ["data" => "seccessfuly deleted"];
    }
}

