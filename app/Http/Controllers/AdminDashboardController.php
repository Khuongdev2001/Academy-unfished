<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\User_pay_course;
use App\Models\Post;

class AdminDashboardController extends Controller
{
    public function index()
    {

        $cUser = User::leftJoin("user_roles", "users.id", "=", "user_roles.user_id")->leftJoin("roles", "user_roles.role_id", "=", "roles.id")->where("roles.name", "student")->count();
        $cCourse = Course::count();
        $cUserPayCourseSuccess = User_pay_course::where("status", "success")->count();
        $cUserPayCourseError = User_pay_course::where("status", "error")->count();
        $userPayCoursesReceived = User_pay_course::where("status", "received")->orwhere("status","pending")->get();
        $cPost = Post::count();
        $static = [

            "cStudent" => $cUser,


            "cCourse" => $cCourse,


            "cUserPayCourseSuccess" => $cUserPayCourseSuccess,


            "cUserPayCourseError" => $cUserPayCourseError,


            "cPost" => $cPost

        ];


        return view("admin.dashboard.index",compact("static","userPayCoursesReceived"));
    }
}
