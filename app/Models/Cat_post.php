<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat_post extends Model
{
    use HasFactory;
    protected $fillable = ["name", "parent_id", "sort","status"];

    function post()
    {
        return $this->hasMany("App\Post","id");
    }
}
