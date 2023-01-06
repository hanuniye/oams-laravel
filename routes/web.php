<?php

use App\Models\Specialization;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\appointment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PateintController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\doctorViewController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SpecializationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view("home.index",["data" => Specialization::all()]);
});



Route::middleware(['auth'])->group(function () {
    Route::get("layout", function () {

        return view("layout");
    });

    Route::prefix("/admin")->group(function () {
        Route::get("/", [AdminController::class, "index"])->name("admin")->middleware("role:admin");
        Route::post("/create", [AdminController::class, "store"])->name("admin.create")->middleware("role:admin");
        Route::get("/get", [AdminController::class, "getAll"])->name("admin.get")->middleware("role:admin");
        Route::get("/get/{id}", [AdminController::class, "getOneUser"])->name("admin.getOneUser")->middleware("role:admin");
        Route::post("/update/{id}", [AdminController::class, "update"])->name("admin.update")->middleware("role:admin");
        Route::get("/delete/{id}", [AdminController::class, "delete"])->name("admin.delete")->middleware("role:admin");
    });

    Route::prefix("/specialization")->group(function () {
        Route::get("/", [SpecializationController::class, "index"])->name("specialization")->middleware("role:admin");
        Route::post("/create", [SpecializationController::class, "store"])->name("specialization.create")->middleware("role:admin");
        Route::get("/get", [SpecializationController::class, "getAll"])->name("specialization.get")->middleware("role:admin");
        Route::get("/get/{id}", [SpecializationController::class, "getOneUser"])->name("specialization.getOneUser")->middleware("role:admin");
        Route::post("/update/{id}", [SpecializationController::class, "update"])->name("specialization.update")->middleware("role:admin");
        Route::get("/delete/{id}", [SpecializationController::class, "delete"])->name("specialization.delete")->middleware("role:admin");
    });

    Route::prefix("/doctor")->group(function () {
        Route::get("/", [DoctorController::class, "index"])->name("doctor")->middleware("role:admin|doctor");
        Route::post("/create", [DoctorController::class, "store"])->name("doctor.create")->middleware("role:admin|doctor");
        Route::get("/get", [DoctorController::class, "getAll"])->name("doctor.get")->middleware("role:admin|doctor");
        Route::get("/get/{id}", [DoctorController::class, "getOneUser"])->name("doctor.getOneUser")->middleware("role:admin|doctor");
        Route::post("/update/{id}", [DoctorController::class, "update"])->name("doctor.update")->middleware("role:admin|doctor");
        Route::get("/delete/{id}", [DoctorController::class, "delete"])->name("doctor.delete")->middleware("role:admin|doctor");
        Route::get("/doctorProfile", [DoctorController::class, "doctorProfile"])->name("doctor.profile")->middleware("role:admin|doctor");
    });

    Route::prefix("/pateint")->group(function () {
        Route::get("/", [PateintController::class, "index"])->name("pateint")->middleware("role:admin|receptionist");
        Route::post("/create", [PateintController::class, "store"])->name("pateint.create")->middleware("role:admin|receptionist");
        Route::get("/get", [PateintController::class, "getAll"])->name("pateint.get")->middleware("role:admin|receptionist");
        Route::get("/get/{id}", [PateintController::class, "getOneUser"])->name("pateint.getOneUser")->middleware("role:admin|receptionist");
        Route::post("/update/{id}", [PateintController::class, "update"])->name("pateint.update")->middleware("role:admin|receptionist");
        Route::get("/delete/{id}", [PateintController::class, "delete"])->name("pateint.delete")->middleware("role:admin|receptionist");
        Route::get("/getDoctor/{id}", [PateintController::class, "doctor"])->middleware("role:admin|receptionist");
    });

    Route::prefix("/schedule")->group(function () {
        Route::get("/", [scheduleController::class, "index"])->name("schedule")->middleware("role:admin");
        Route::post("/create", [scheduleController::class, "store"])->name("schedule.create")->middleware("role:admin");
        Route::get("/get", [scheduleController::class, "getAll"])->name("schedule.get");
        Route::get("/get/{id}", [scheduleController::class, "getOneUser"])->name("schedule.getOneUser")->middleware("role:admin");
        Route::post("/update/{id}", [scheduleController::class, "update"])->name("schedule.update")->middleware("role:admin");
        Route::get("/delete/{id}", [scheduleController::class, "delete"])->name("schedule.delete")->middleware("role:admin");
        Route::get("/getDoctor/{id}", [scheduleController::class, "doctor"])->middleware("role:admin");
    });

    Route::prefix("/appointment")->group(function () {
        Route::get("/", [AppointmentController::class, "index"])->name("AppointmentController.create")->middleware("role:admin|receptionist|doctor");
        Route::get("/get", [AppointmentController::class, "getAll"])->name("AppointmentController.get")->middleware("role:admin|receptionist|doctor");
        Route::get("/get/{id}", [AppointmentController::class, "getDoctorSched"])->middleware("role:admin|receptionist|doctor");
        Route::get("/view/{id}", [AppointmentController::class, "viewAppoint"])->middleware("role:admin|receptionist|doctor");
        Route::post("/update/{id}", [AppointmentController::class, "update"])->name("AppointmentController.update")->middleware("role:admin|receptionist|doctor");
        Route::get("/delete/{id}", [AppointmentController::class, "delete"])->name("AppointmentController.delete")->middleware("role:admin|receptionist|doctor");
        Route::get("/getDoctor/{id}", [AppointmentController::class, "doctor"])->middleware("role:admin|receptionist|doctor");
    });

    Route::prefix("/reception")->group(function () {
        Route::get("/", [ReceptionController::class, "index"])->middleware("role:admin|receptionist");
        Route::post("/create", [ReceptionController::class, "store"])->middleware("role:admin|receptionist");
        Route::get("/get", [ReceptionController::class, "getAll"])->middleware("role:admin|receptionist");
        Route::get("/get/{id}", [ReceptionController::class, "getOneUser"])->middleware("role:admin|receptionist");
        Route::post("/update/{id}", [ReceptionController::class, "update"])->middleware("role:admin|receptionist");
        Route::get("/delete/{id}", [ReceptionController::class, "delete"])->middleware("role:admin|receptionist");
        Route::get("/doctorProfile", [ReceptionController::class, "doctorProfile"])->middleware("role:admin|receptionist");
        Route::post("/updateStatus/{id}",[ReceptionController::class, "updateStatus"])->middleware("role:admin|receptionist");
    });
});

// Route::prefix("/doctorview")->group(function () {
//     Route::get("/", [appointment::class, "index"])->name("appointment");
//     Route::post("/create", [appointment::class, "store"])->name("appointment.create");
//     Route::get("/get", [appointment::class, "getAll"])->name("appointment.get");
//     Route::get("/get/{id}", [appointment::class, "getDoctorSched"])->name("appointment.getDoctorSched");
//     Route::post("/update/{id}", [appointment::class, "update"])->name("appointment.update");
//     Route::get("/delete/{id}", [appointment::class, "delete"])->name("appointment.delete");
//     Route::get("/getDoctor/{id}", [appointment::class, "doctor"]);
// });



Route::get("doctorview",[doctorViewController::class, "index"]);
Route::get("/getDoctors", [doctorViewController::class, "getAllDoctors"]);
Route::get("/getDoctors/{id}", [doctorViewController::class, "getDoctorSched"]);
Route::get("setappointment",[doctorViewController::class, "setAppoint"])->middleware("auth");
Route::get("myappointment",[doctorViewController::class, "myappointment"])->middleware("auth");
Route::post("/createAppoint",[doctorViewController::class, "createAppoint"])->middleware("auth");
Route::get("/getMyAppointment/{id}",[doctorViewController::class, "getMyAppointment"])->middleware("auth");
Route::post("/updateStatus/{id}",[doctorViewController::class, "updateStatus"])->middleware("auth");

//patient login and register
Route::get("patientlogin",[AuthController::class, "toPateintLogin"])->name("patientlogin");
Route::get("register",[AuthController::class, "register"])->name("register");
Route::post("pateintCreate",[AuthController::class, "store"])->name("pateintCreate");


Route::get("login",[AuthController::class, "index"])->name("login");
Route::post("authanticate",[AuthController::class, "authanticate"]);
Route::get("logout",[AuthController::class, "logout"]);

