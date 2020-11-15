<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// thư viện soft delete
use Illuminate\Database\Eloquent\SoftDeletes;

class User_pay_course extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["course_id", "user_id", "pay_id", "discount", "status", "sort", "code"];

    public function user()
    {

        return $this->belongsTo("App\Models\User", "user_id");
    }



    public function course()
    {

        return $this->belongsTo("App\Models\Course", "course_id");
    }


    public function pay()
    {

        return $this->belongsTo("App\Models\Pay", "pay_id");
    }
}
