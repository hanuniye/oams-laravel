<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = ['name','contact',"user_id",'image'];

    public function userAdmin(){
        return $this->hasOne(User::class,"id","user_id");
    }
}
