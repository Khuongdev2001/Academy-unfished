<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule_course_offline extends Model
{
    use HasFactory;
    protected $fillable = ["date_start", "text_time_learn", "course_id", "max_student", "now_student", "note","title","status"];
}
