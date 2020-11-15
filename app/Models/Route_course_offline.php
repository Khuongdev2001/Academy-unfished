<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route_course_offline extends Model
{
    use HasFactory;
    protected $fillable = ["name", "content","title","course_id","status"];
}
