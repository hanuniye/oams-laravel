<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    protected $fillable = ["day","start_time","end_time","doctor_id"];

    public function schedDoctor(){
        return $this->hasOne(Doctor::class,"id","doctor_id");
    }
}
