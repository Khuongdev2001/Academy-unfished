<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// thư viện soft delete
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["name", "cat_id", "content", "desc", "thumbnail", "creator", "status"];


    function cat()
    {
        return $this->belongsTo("App\Models\Cat_post", "cat_id");
    }




    public function user()
    {

        return $this->belongsTo("App\Models\User", "creator");
    }

    public function comment()
    {

        return $this->hasMany("App\Models\Comment_post","post_id");
    }
}
