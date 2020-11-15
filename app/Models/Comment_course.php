<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_course extends Model
{
    use HasFactory;
    protected $fillable = ["content", "user_id", "cat_id", "star", "video", "thumbnail", "parent_id", "status"];



    public function user()
    {

        return $this->belongsTo("App\Models\User", "user_id");
    }


    public function cat()
    {

        return $this->belongsTo("App\Models\Course", "cat_id");
    }
}
