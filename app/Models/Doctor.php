<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ["name","contact","exprience","specialist_id","image","user_id","age"];

    public function userDoctor(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function specDoctor(){
        return $this->hasOne(Specialization::class,"id","specialist_id");
    }

}
