<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pateint extends Model
{
    protected $fillable = ["name","fullname","gender","age","birth_date","doctor_id","user_id","contact","status"];

    public function docPateint(){
        return $this->hasOne(Doctor::class,"id","doctor_id");
    }

}
