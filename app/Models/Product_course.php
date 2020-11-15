<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// thư viện soft delete
use Illuminate\Database\Eloquent\SoftDeletes;


class Product_course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["name", "desc", "course_id", "parent_id", "status", "view", "player", "content", "type_content", "thumbnail",  "video_id"];


    public function course()

    {
        return $this->belongsTo("App\Models\Course", "course_id");
    }
}
