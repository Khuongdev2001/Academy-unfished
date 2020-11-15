<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// thư viện soft delete
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["name", "thumbnail", "video","content","note", "parent_id", "price", "price_old", "cat_id", "time_end", "sort","status"];
}
