<?php

use App\http\Controllers\AdminUserController;
use App\http\Controllers\AdminPostController;
use App\http\Controllers\AdminSliderController;
use App\http\Controllers\AdminPayController;
use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AdminProductCourseController;
use App\Http\Controllers\AdminCommentCourseController;
use App\Http\Controllers\AdminCommentPostController;
use App\Http\Controllers\AdminUserPayCourseController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TestController;

// client controller

use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('test/', [TestController::class, "index"]);

Route::get("/admin", function () {

    return redirect()->route("admin.dashboard");
});

Route::get("admin/user/login", [AdminUserController::class, "login"])->name("admin.user.login");
Route::post("admin/user/login", [AdminUserController::class, "doLogin"]);
Route::get("admin/user/logout", [AdminUserController::class, "logout"])->name("admin.user.logout");

Route::middleware("CheckLogin")->group(function () {

    Route::get("admin/user/add", [AdminUserController::class, "add"])->name("admin.user.add");
    Route::post("admin/user/add", [AdminUserController::class, "doAdd"]);
    Route::get("admin/user/{option?}", [AdminUserController::class, "index"])->name("admin.user")->where('option', 'trash| ');
    Route::get("admin/user/update/{id}", [AdminUserController::class, "update"])->name("admin.user.update")->where("id", "[0-9]+");
    Route::post("admin/user/update/{id}", [AdminUserController::class, "doUpdate"])->name("admin.user.update")->where("id", "[0-9]+");
    Route::get("admin/user/delete/{id}", [AdminUserController::class, "delete"])->name("admin.user.delete")->where("id", "[0-9]+");
    Route::get("admin/user/restore/{id}", [AdminUserController::class, "restore"])->name("admin.user.restore")->where("id", "[0-9]+");
    Route::get("admin/user/destroy/{id}", [AdminUserController::class, "destroy"])->name("admin.user.destroy")->where("id", "[0-9]+");
    Route::get("admin/user/multitask/{option}", [AdminUserController::class, "multitask"])->name("admin.user.multitask")->where("option", "trash|restore");

    // post
    Route::get("admin/post/cat/add", [AdminPostController::class, "addCat"])->name("admin.post.cat.add");
    Route::post("admin/post/cat/add", [AdminPostController::class, "doAddCat"]);
    Route::get("admin/post/cat/update/{id}", [AdminPostController::class, "updateCat"])->name("admin.post.cat.update")->where("id", "[0-9]+");
    Route::post("admin/post/cat/update/{id}", [AdminPostController::class, "doUpdateCat"])->name("admin.post.cat.update")->where("id", "[0-9]+");
    Route::get("admin/post/cat/delete/{id}", [AdminPostController::class, "deleteCat"])->name("admin.post.cat.delete")->where("id", "[0-9]+");
    Route::get("admin/post/add", [AdminPostController::class, "add"])->name("admin.post.add");
    Route::post("admin/post/add", [AdminPostController::class, "doAdd"]);
    Route::get("admin/post/{option?}", [AdminPostController::class, "index"])->name("admin.post")->where('option', 'trash| ');
    Route::get("admin/post/update/{id?}", [AdminPostController::class, "update"])->name("admin.post.update")->where("id", "[0-9]+");
    Route::post("admin/post/update/{id?}", [AdminPostController::class, "doUpdate"])->where("id", "[0-9]+");
    Route::get("admin/post/delete/{id}", [AdminPostController::class, "delete"])->name("admin.post.delete")->where("id", "[0-9]+");
    Route::get("admin/post/restore/{id}", [AdminPostController::class, "restore"])->name("admin.post.restore")->where("id", "[0-9]+");
    Route::get("admin/post/destroy/{id}", [AdminPostController::class, "destroy"])->name("admin.post.destroy")->where("id", "[0-9]+");
    Route::get("admin/post/multitask/{option}", [AdminPostController::class, "multitask"])->name("admin.post.multitask")->where("option", "trash|restore");



    // slider
    Route::get("admin/slider/{option?}", [AdminSliderController::class, "index"])->name("admin.slider")->where('option', 'trash| ');
    Route::get("admin/slider/add", [AdminSliderController::class, "add"])->name("admin.slider.add");
    Route::post("admin/slider/add", [AdminSliderController::class, "doAdd"]);
    Route::get("admin/slider/update/{id?}", [AdminSliderController::class, "update"])->name("admin.slider.update")->where("id", "[0-9]+");
    Route::post("admin/slider/update/{id?}", [AdminSliderController::class, "doUpdate"])->where("id", "[0-9]+");
    Route::get("admin/slider/delete/{id}", [AdminSliderController::class, "delete"])->name("admin.slider.delete")->where("id", "[0-9]+");
    Route::get("admin/slider/restore/{id}", [AdminSliderController::class, "restore"])->name("admin.slider.restore")->where("id", "[0-9]+");
    Route::get("admin/slider/destroy/{id}", [AdminSliderController::class, "destroy"])->name("admin.slider.destroy")->where("id", "[0-9]+");
    Route::get("admin/slider/multitask/{option}", [AdminSliderController::class, "multitask"])->name("admin.slider.multitask")->where("option", "trash|restore");

    //  pay

    Route::get("admin/pay/{option?}", [AdminPayController::class, "index"])->name("admin.pay")->where('option', 'trash| ');
    Route::get("admin/pay/add", [AdminPayController::class, "add"])->name("admin.pay.add");
    Route::post("admin/pay/add", [AdminPayController::class, "doAdd"]);
    Route::get("admin/pay/update/{id?}", [AdminPayController::class, "update"])->name("admin.pay.update")->where("id", "[0-9]+");
    Route::post("admin/pay/update/{id?}", [AdminPayController::class, "doUpdate"])->where("id", "[0-9]+");
    Route::get("admin/pay/delete/{id}", [AdminPayController::class, "delete"])->name("admin.pay.delete")->where("id", "[0-9]+");
    Route::get("admin/pay/restore/{id}", [AdminPayController::class, "restore"])->name("admin.pay.restore")->where("id", "[0-9]+");
    Route::get("admin/pay/destroy/{id}", [AdminPayController::class, "destroy"])->name("admin.pay.destroy")->where("id", "[0-9]+");
    Route::get("admin/pay/multitask/{option}", [AdminPayController::class, "multitask"])->name("admin.pay.multitask")->where("option", "trash|restore");


    // course
    Route::get("admin/course/add", [AdminCourseController::class, "add"])->name("admin.course.add");
    Route::post("admin/course/add", [AdminCourseController::class, "doAdd"]);
    Route::get("admin/course/{cat?}/{option?}", [AdminCourseController::class, "index"])->name("admin.course")->where(["option" => "trash| ", "cat" => "[0-9]+"]);
    Route::get("admin/course/update/{id?}", [AdminCourseController::class, "update"])->name("admin.course.update")->where("id", "[0-9]+");
    Route::post("admin/course/update/{id?}", [AdminCourseController::class, "doUpdate"])->where("id", "[0-9]+");
    Route::get("admin/course/delete/{id?}", [AdminCourseController::class, "delete"])->name("admin.course.delete")->where("id", "[0-9]+");
    Route::get("admin/course/restore/{id?}", [AdminCourseController::class, "restore"])->name("admin.course.restore")->where("id", "[0-9]+");
    Route::get("admin/course/destroy/{id?}", [AdminCourseController::class, "destroy"])->name("admin.course.destroy")->where("id", "[0-9]+");
    Route::get("admin/course/multitask/{option}", [AdminCourseController::class, "multitask"])->name("admin.course.multitask")->where("option", "trash|restore");


    // product course
    // offline
    Route::get("admin/course/offline/route/{id}", [AdminProductCourseController::class, "indexRouteOffline"])->name("admin.course.offline.route")->where("id", "[0-9]+");
    Route::post("admin/course/offline/route/add/{id?}", [AdminProductCourseController::class, "addRouteCourseOffline"])->name("admin.course.offline.route.add")->where("id", "[0-9]+");
    Route::post("admin/course/offline/route/update/{id?}", [AdminProductCourseController::class, "updateRouteCourseOffline"])->name("admin.course.offline.route.update")->where("id", "[0-9]+");
    Route::get("admin/course/offline/route/delete/{id?}", [AdminProductCourseController::class, "deleteRouteCourseOffline"])->name("admin.course.offline.route.delete")->where("id", "[0-9]+");
    Route::get("admin/course/offline/schedule/{id}", [AdminProductCourseController::class, "indexScheduleOffline"])->name("admin.course.offline.schedule")->where("id", "[0-9]+");
    Route::post("admin/course/offline/add/{id}", [AdminProductCourseController::class, "addScheduleOffline"])->name("admin.course.offline.schedule.add")->where("id", "[0-9]+");
    Route::post("admin/course/offline/schedule/update/{id}", [AdminProductCourseController::class, "updateScheduleOffline"])->name("admin.course.offline.schedule.update")->where("id", "[0-9]+");
    Route::get("admin/course/offline/schedule/delete/{id?}", [AdminProductCourseController::class, "deleteScheduleOffline"])->name("admin.course.offline.schedule.delete")->where("id", "[0-9]+");

    // online
    Route::get("admin/course/online/chapter/{id}", [AdminProductCourseController::class, "indexChapterOnline"])->name("admin.course.online.chapter")->where("id", "[0-9]+");
    Route::post("admin/course/online/chapter/add/{id}", [AdminProductCourseController::class, "addOnlineChapter"])->name("admin.course.online.chapter.add")->where("id", "[0-9]+");
    Route::post("admin/course/online/chapter/update/{id}", [AdminProductCourseController::class, "updateOnlineChapter"])->name("admin.course.online.chapter.update")->where("id", "[0-9]+");
    Route::get("admin/course/online/chapter/delete/{id}", [AdminProductCourseController::class, "deleteOnlineChapter"])->name("admin.course.online.chapter.delete")->where("id", "[0-9]+");
    Route::get("admin/course/online/add/{id}", [AdminProductCourseController::class, "addOnline"])->name("admin.course.online.add")->where("id", "[0-9]+");
    Route::post("admin/course/online/add/{id}", [AdminProductCourseController::class, "doAddOnline"])->where("id", "[0-9]+");
    Route::get("admin/course/online/{id}/{option?}", [AdminProductCourseController::class, "indexOnline"])->name("admin.course.online")->where("id", "[0-9]+")->where("option", "trash| ");
    Route::get("admin/course/online/update/{id}", [AdminProductCourseController::class, "updateOnline"])->name("admin.course.online.update")->where("id", "[0-9]+")->where("courseId", "[0-9]+");
    Route::post("admin/course/online/update/{id}", [AdminProductCourseController::class, "doUpdateOnline"])->where("id", "[0-9]+");
    Route::get("admin/course/online/delete/{id}", [AdminProductCourseController::class, "deleteOnline"])->name("admin.course.online.delete")->where("id", "[0-9]+");
    Route::get("admin/course/online/restore/{id}", [AdminProductCourseController::class, "restoreOnline"])->name("admin.course.online.restore")->where("id", "[0-9]+");
    Route::get("admin/course/online/destroy/{id}", [AdminProductCourseController::class, "destroyOnline"])->name("admin.course.online.destroy")->where("id", "[0-9]+");
    Route::get("admin/course/online/multitask/{option}", [AdminProductCourseController::class, "multitaskOnline"])->name("admin.course.online.multitask")->where("option", "trash|restore");

    // comment course
    Route::get("admin/comment/course/{cat}", [AdminCommentCourseController::class, "index"])->name("admin.comment.course")->where(["cat" => "[0-9]+"]);
    Route::get("admin/comment/course/{cat}/response/{id}", [AdminCommentCourseController::class, "response"])->name("admin.comment.course.response")->where(["cat" => "[0-9]+", "id" => "[0-9]+"]);
    Route::post("admin/comment/course/{cat}/response/{id}", [AdminCommentCourseController::class, "doResponse"])->where(["cat" => "[0-9]+", "id" => "[0-9]+"]);
    Route::get("admin/comment/course/{cat}/delete/{id}", [AdminCommentCourseController::class, "delete"])->name("admin.comment.course.delete")->where(["cat" => "[0-9]+", "id" => "[0-9]+"]);
    Route::get("admin/comment/course/multitask/", [AdminCommentCourseController::class, "multitask"])->name("admin.comment.course.multitask");
    // comment post
    Route::get("admin/comment/post/{cat}", [AdminCommentPostController::class, "index"])->name("admin.comment.post")->where(["cat" => "[0-9]+"]);
    Route::get("admin/comment/post/{cat}/response/{id}", [AdminCommentPostController::class, "response"])->name("admin.comment.post.response")->where(["cat" => "[0-9]+", "id" => "[0-9]+"]);
    Route::post("admin/comment/post/{cat}/response/{id}", [AdminCommentPostController::class, "doResponse"])->where(["cat" => "[0-9]+", "id" => "[0-9]+"]);
    Route::get("admin/comment/post/{cat}/delete/{id}", [AdminCommentPostController::class, "delete"])->name("admin.comment.post.delete")->where(["cat" => "[0-9]+", "id" => "[0-9]+"]);
    Route::get("admin/comment/post/multitask/", [AdminCommentPostController::class, "multitask"])->name("admin.comment.post.multitask");
    //  user_pay_course
    Route::get("admin/user/pay/course/{option?}", [AdminUserPayCourseController::class, "index"])->name("admin.user.pay.course")->where("option", "trash| ");
    Route::get("admin/user/pay/course/update/{id}", [AdminUserPayCourseController::class, "update"])->name("admin.user.pay.course.update")->where("id", "[0-9]+");
    Route::post("admin/user/pay/course/update/{id}", [AdminUserPayCourseController::class, "doUpdate"])->where("id", "[0-9]+");
    Route::get("admin/user/pay/course/delete/{id}", [AdminUserPayCourseController::class, "delete"])->name("admin.user.pay.course.delete")->where("id", "[0-9]+");
    Route::get("admin/user/pay/course/restore/{id}", [AdminUserPayCourseController::class, "restore"])->name("admin.user.pay.course.restore")->where("id", "[0-9]+");
    Route::get("admin/user/pay/course/destroy/{id}", [AdminUserPayCourseController::class, "destroy"])->name("admin.user.pay.course.destroy")->where("id", "[0-9]+");
    // dashboard
    Route::get("admin/dashboard", [AdminDashboardController::class, "index"])->name("admin.dashboard");
});



//========================================== client ================================================================//
// 15-11-2020
// by Nguyễn Hữu Khương

Route::get("/");

Route::get("post/{cat?}", [PostController::class, "index"])->name("post")->where("cat", "[0-9]+");
Route::get("post/detail/{id}", [PostController::class, "detail"])->name("post.detail")->where("id", "[0-9]+");
Route::post("post/comment/add/{cat}",[PostController::class,"addComment"])->name("post.comment.add")->where("cat", "[0-9]+");
