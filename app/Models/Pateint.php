<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pateint extends Model
{
    use HasFactory;
    protected $fillable = ["name","fullname","gender","age","birth_date","doctor_id","user_id","contact","status"];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

}
