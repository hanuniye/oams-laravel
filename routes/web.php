<?php

use App\Models\Specialization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PateintController;
use App\Http\Controllers\scheduleController;
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
        Route::get("/", [AdminController::class, "index"])->name("admin");
        Route::post("/create", [AdminController::class, "store"])->name("admin.create");
        Route::get("/get", [AdminController::class, "getAll"])->name("admin.get");
        Route::get("/get/{id}", [AdminController::class, "getOneUser"])->name("admin.getOneUser");
        Route::post("/update/{id}", [AdminController::class, "update"])->name("admin.update");
        Route::get("/delete/{id}", [AdminController::class, "delete"])->name("admin.delete");
    });

    Route::prefix("/specialization")->group(function () {
        Route::get("/", [SpecializationController::class, "index"])->name("specialization");
        Route::post("/create", [SpecializationController::class, "store"])->name("specialization.create");
        Route::get("/get", [SpecializationController::class, "getAll"])->name("specialization.get");
        Route::get("/get/{id}", [SpecializationController::class, "getOneUser"])->name("specialization.getOneUser");
        Route::post("/update/{id}", [SpecializationController::class, "update"])->name("specialization.update");
        Route::get("/delete/{id}", [SpecializationController::class, "delete"])->name("specialization.delete");
    });

    Route::prefix("/doctor")->group(function () {
        Route::get("/", [DoctorController::class, "index"])->name("doctor");
        Route::post("/create", [DoctorController::class, "store"])->name("doctor.create");
        Route::get("/get", [DoctorController::class, "getAll"])->name("doctor.get");
        Route::get("/get/{id}", [DoctorController::class, "getOneUser"])->name("doctor.getOneUser");
        Route::post("/update/{id}", [DoctorController::class, "update"])->name("doctor.update");
        Route::get("/delete/{id}", [DoctorController::class, "delete"])->name("doctor.delete");
        Route::get("/doctorProfile", [DoctorController::class, "doctorProfile"])->name("doctor.profile");
    });

    Route::prefix("/pateint")->group(function () {
        Route::get("/", [PateintController::class, "index"])->name("pateint");
        Route::post("/create", [PateintController::class, "store"])->name("pateint.create");
        Route::get("/get", [PateintController::class, "getAll"])->name("pateint.get");
        Route::get("/get/{id}", [PateintController::class, "getOneUser"])->name("pateint.getOneUser");
        Route::post("/update/{id}", [PateintController::class, "update"])->name("pateint.update");
        Route::get("/delete/{id}", [PateintController::class, "delete"])->name("pateint.delete");
        Route::get("/getDoctor/{id}", [PateintController::class, "doctor"]);
    });

    Route::prefix("/schedule")->group(function () {
        Route::get("/", [scheduleController::class, "index"])->name("schedule");
        Route::post("/create", [scheduleController::class, "store"])->name("schedule.create");
        Route::get("/get", [scheduleController::class, "getAll"])->name("schedule.get");
        Route::get("/get/{id}", [scheduleController::class, "getOneUser"])->name("schedule.getOneUser");
        Route::post("/update/{id}", [scheduleController::class, "update"])->name("schedule.update");
        Route::get("/delete/{id}", [scheduleController::class, "delete"])->name("schedule.delete");
        Route::get("/getDoctor/{id}", [scheduleController::class, "doctor"]);
    });
});

Route::get("login",[AuthController::class, "index"])->name("login");
Route::post("authanticate",[AuthController::class, "authanticate"]);
Route::get("logout",[AuthController::class, "logout"]);

