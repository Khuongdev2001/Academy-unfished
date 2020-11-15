<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ["content", "user_id", "cat_id", "type", "star", "video", "thumbnail", "parent_id"];
}
