<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Pateint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ["date","time","reason","pateint_id","doctor_id"];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function pateint(){
        return $this->belongsTo(Pateint::class);
    }
}
