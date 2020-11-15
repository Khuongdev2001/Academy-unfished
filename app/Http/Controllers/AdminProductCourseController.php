<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Product_course;
use App\Models\Route_course_offline;
use App\Models\Schedule_course_offline;
use Illuminate\Support\Str;
use  ApiVideo\Client\Client;

use Illuminate\Routing\Route;

class AdminProductCourseController extends Controller
{

    public function indexRouteOffline($id, Request $request)
    {

        // chỉ chọn course có id và 

        $course = Course::where([["id", $id], ["cat_id", 2]]);


        // chuyển hướng khi không tìm  được course id
        if (!$course->count())
            return redirect()->back();

        $fields = $request->input();

        // check request update

        $routeCourse = NULL;
        if ($request->input("update")) {

            $routeCourse = Route_course_offline::where([["id", $request->input("update")], ["course_id", $id]])->first();
        }

        $seachRoute = $fields["seachRoute"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["title", "content", "created_at"]);


        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";


        // thiếu chức năng thùng rác    

        $routeCourses = Route_course_offline::select('id', 'title', 'content', 'created_at');

        $course = $course->first();
        $routeCourses = Route_course_offline::where('title', 'LIKE', "%{$seachRoute}%")->orderByRaw($orderBy)->paginate($limit);

        return view("admin.productCourse.indexRouteOffline", compact("course", "routeCourses", "routeCourse"));
    }

    public function addRouteCourseOffline($id, Request $request)
    {
        $request->validate(
            [
                "title" => "required",
                "content" => "required",
                "status" => "required|in:show,hidden"
            ],
            [
                "title.required" => ":attribute không được bỏ trống",
                "content.required" => ":attribute không được bỏ trống"
            ],
            [
                "title" => "Tiêu đề",
                "content" => "Nội dung"
            ]
        );

        // validate 

        $routeCourse = $request->input();

        $course = Course::find($id);
        if (!$course)
            return redirect()->back();

        $routeCourse["course_id"] = $id;
        // add database

        Route_course_offline::create($routeCourse);


        return redirect()->back()->with("notification", ["alert" => "Thêm thành công lộ trình của khóa học", "type" => "success"]);
    }



    public function updateRouteCourseOffline($id, Request $request)

    {

        $request->validate(
            [
                "title" => "required",
                "content" => "required",
                "status" => "required|in:show,hidden"
            ],
            [
                "title.required" => ":attribute không được bỏ trống",
                "content.required" => ":attribute không được bỏ trống"
            ],
            [
                "title" => "Tiêu đề",
                "content" => "Nội dung"
            ]
        );

        Route_course_offline::find($id)->update($request->input());

        return redirect()->back()->with("notification", ["alert" => "Cập nhật thành công lộ trình học offline", "type" => "success"]);
    }



    public function deleteRouteCourseOffline($id)
    {

        Route_course_offline::find($id)->delete();

        return redirect()->back()->with("notification", ["alert" => "xóa thành công lộ trình học offline", "type" => "success"]);
    }




    public function indexScheduleOffline($id, Request $request)

    {

        // chỉ chọn course có id và 

        $course = Course::where([["id", $id], ["cat_id", 2]]);


        // chuyển hướng khi không tìm  được course id
        if (!$course->count())
            return redirect()->back();

        $fields = $request->input();

        // check request update

        $scheduleCourse = NULL;
        if ($request->input("update")) {

            $scheduleCourse = Schedule_course_offline::where([["id", $request->input("update")], ["course_id", $id]])->first();
        }

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["date_start", 'text_time_date', "max_student", "now_student", "note", "created_at"]);


        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";


        // thiếu chức năng thùng rác    

        $scheduleCourses = Schedule_course_offline::select('id', 'title', 'created_at', 'date_start', 'text_time_date', 'max_student');

        $course = $course->first();
        $scheduleCourses = Schedule_course_offline::where('title', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);

        return view("admin.productCourse.indexScheduleOffline", compact("course", "scheduleCourse", "scheduleCourses"));
    }



    public function addScheduleOffline($id, Request $request)

    {

        $request->validate(
            [
                "title" => "required",
                "date_start" => "required|date_format:Y-m-d",
                "text_time_learn" => "required",
                "max_student" => "required|integer",
                "now_student" => "nullable|integer"
            ],
            [
                "title.required" => ":attribute không được bỏ trống",
                "date_start.required" => ":attribute không được bỏ trống",
                "date_start.date_format" => ":attribute sai định dạng",
                "text_time_learn.required" => ":attribute không được bỏ trống",
                "max_student.required" => ":attribute không được bỏ trống",
                "max_student.integer" => ":attribute là dạng số",
                "now_student.integer" => ":attribute là dạng số"

            ],
            [
                "title" => "Tiêu đề",
                "date_start" => "Thời gian khai giảng ",
                "text_time_learn" => "Thời gian học hàng tuần",
                "max_student" => "Số học viên tối đa",
                "now_student" => "Số học viên hiện có"

            ]
        );

        $scheduleCourse = $request->input();



        // add fiels course_id
        $scheduleCourse["course_id"] = $id;
        Schedule_course_offline::create($scheduleCourse);

        return redirect()->back()->with("notification", ["alert" => "Thêm thành công thời khóa biểu", "type" => "success"]);
    }


    public function updateScheduleOffline($id, Request $request)

    {

        $request->validate(
            [
                "title" => "required",
                "date_start" => "required|date_format:Y-m-d",
                "text_time_learn" => "required",
                "max_student" => "required|integer",
                "now_student" => "nullable|integer"
            ],
            [
                "title.required" => ":attribute không được bỏ trống",
                "date_start.required" => ":attribute không được bỏ trống",
                "date_start.date_format" => ":attribute sai định dạng",
                "text_time_learn.required" => ":attribute không được bỏ trống",
                "max_student.required" => ":attribute không được bỏ trống",
                "max_student.integer" => ":attribute là dạng số",
                "now_student.integer" => ":attribute là dạng số"

            ],
            [
                "title" => "Tiêu đề",
                "date_start" => "Thời gian khai giảng ",
                "text_time_learn" => "Thời gian học hàng tuần",
                "max_student" => "Số học viên tối đa",
                "now_student" => "Số học viên hiện có"

            ]
        );

        $scheduleCourse = $request->input();

        Schedule_course_offline::find($id)->update($scheduleCourse);
        return redirect()->back()->with("notification", ["alert" => "Cập nhật thành công thời khóa biểu", "type" => "success"]);
    }




    public function deleteScheduleOffline($id)
    {


        Schedule_course_offline::find($id)->delete();

        return redirect()->back()->with("notification", ["alert" => "xóa thành công thời khóa biểu học offline", "type" => "success"]);
    }



    //===================================================== 12-10-2020 ===================================================================
    //====================================================== online ======================================================================



    public function indexChapterOnline($id, Request $request)
    {


        // chỉ chọn course có id và 

        $course = Course::where([["id", $id], ["cat_id", 1]])->first();

        if (!$course)
            return redirect()->back();

        // check update chapter

        $chapter = NULL;

        if ($request->input("update")) {

            $chapter = Product_course::where([["id", $request->input("update")], ["course_id", $id]])->first();
        }



        $fields = $request->input();
        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "created_at"]);


        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";


        // thiếu chức năng thùng rác    



        // get chapters dành cho table

        $chapters = Product_course::where([["course_id", $id], ["parent_id", 0], ["name", "LIKE", "%{$seach}%"]]);

        $chapters = $chapters->select('id', 'name', 'status', 'created_at');

        $chapters = $chapters->orderByRaw($orderBy)->paginate($limit);

        return view("admin.productCourse.indexChapterOnline", compact("course", "chapters", "chapter"));
    }


    public function addOnlineChapter($id, Request $request)

    {

        // chỉ chọn course có id và 

        $course = Course::where([["id", $id], ["cat_id", 1]])->first();



        if (!$course)
            return redirect()->back();

        // 
        $request->validate(
            [
                "nameChapter" => "required",
                "status" => "in:show,hidden"
            ],
            [
                "nameChapter.required" => ":attribute không được bỏ trống ",
            ],
            [
                "nameChapter" => "Tên Chương"
            ]
        );


        $chapter = [

            "name" => $request->input("nameChapter"),

            "status" => $request->input("status"),

            "course_id" => $id,



            "parent_id" => 0


        ];


        Product_course::create($chapter);

        return redirect()->back()->with("notification", ["alert" => "Thêm thành công chương học online", "type" => "success"]);
    }



    public function updateOnlineChapter($id, Request $request)
    {


        $request->validate(
            [
                "nameChapter" => "required",
                "status" => "in:show,hidden"
            ],
            [
                "nameChapter.required" => ":attribute không được bỏ trống ",
            ],
            [
                "nameChapter" => "Tên Chương"
            ]
        );


        $chapter = [

            "name" => $request->input("nameChapter"),

            "status" => $request->input("status"),

            "parent_id" => 0


        ];


        Product_course::find($id)->update($chapter);

        return redirect()->back()->with("notification", ["alert" => "Thêm thành công chương học online", "type" => "success"]);
    }






    public function deleteOnlineChapter($id)

    {

        Product_course::find($id)->delete();

        return redirect()->back()->with("notification", ["alert" => "xóa thành công chương học offline", "type" => "success"]);
    }




    public function addOnline($id)

    {


        // chỉ chọn course có id và 

        $course = Course::where([["id", $id], ["cat_id", 1]])->first();

        if (!$course)
            return redirect()->back();

        $chapters = Product_course::where([["course_id", $id], ["parent_id", 0]])->get();

        return view("admin.productCourse.addOnline", compact("course", "chapters"));
    }


    public function doAddOnline($id, Request $request)

    {

        // chỉ chọn course có id và 

        $course = Course::where([["id", $id], ["cat_id", 1]])->first();

        if (!$course)
            return redirect()->back();


        // get chapter validate

        $chapters = Product_course::where("parent_id", 0)->get();

        $chapterCheck = "";
        foreach ($chapters as $item) {

            $chapterCheck .= $item->id . ",";
        }
        $chapterCheck = substr($chapterCheck, 0, -1);


        $request->validate(
            [
                "name" => "required:unique:product_courses",
                "course_id" => "nullable|integer",
                "parent_id" => "in:" . $chapterCheck,
                "view" => "required|in:pay,free",
                "status" => "required|in:show,hiden",
                "content" => "required|mimes:mp4,mov,ogg,qt,pdf"
            ],
            [
                "name.required" => ":attribute không được bỏ trống",
                "unique.unique" => ":attribute đã tồn tại hệ thống",
                "content.required" => ":attribute không được bỏ trống",
                'content.mimes' => ":attribute phải định dạng video hay pdf",
            ],
            [
                "name" => "Tên bài giảng",
                "content" => "nội dung bài học"
            ]
        );

        $productCourse = $request->input();

        // add field course id
        $productCourse["course_id"] = $id;

        if ($request->hasFile("content")) {

            $content = $request->content;

            // get file name settup
            $filename = Str::slug($productCourse["name"]);


            // get type file

            $type = $content->getClientOriginalExtension();

            $dir = "uploads/courses/online/video";
            if ($content->getMimeType() == "application/pdf")
                $dir = "uploads/courses/online/pdf";

            // di chuyển file

            $file = $content->move("public/" . $dir, $filename . "." . $type);


            if (Str::upper($type) != "PDF") {

                // move api video

                // Authenticate in production environment
                $client = Client::create('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');


                // Alternatively, authenticate in sandbox environment for testing
                $client = Client::createSandbox('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');

                // Create and upload a video resource from local drive
                $video = $client->videos->upload(
                    $file,
                    array('title' => $productCourse["name"])
                );

                // seach tìm id

                // Search video by tags filter and paginate results
                $videos = $client->videos->search(
                    array(
                        'title' => $productCourse["name"]
                    )
                );

                /**
                 *  [
                 * {"videoId":"vi5QKd6gFEq1PFFjmablsMBq",
                 * "title":"B\u00e0i gi\u1ea3ng 13",
                 * "description":"",
                 * "public":true,
                 * "tags":[],
                 * "metadata":[],
                 * "source":{"type":"upload","uri":"\/videos\/vi5QKd6gFEq1PFFjmablsMBq\/source"},
                 * "assets":{"iframe":"<iframe src=\"https:\/\/embed.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\" width=\"100%\" height=\"100%\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"true\"><\/iframe>",
                 * "player":"https:\/\/embed.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq",
                 * "hls":"https:\/\/cdn.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\/hls\/manifest.m3u8",
                 * "thumbnail":"https:\/\/cdn.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\/thumbnail.jpg",
                 * "mp4":"https:\/\/cdn.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\/mp4\/720\/source.mp4"},
                 * "publishedAt":{"date":"2020-11-13 08:10:44.000000","timezone_type":1,"timezone":"+00:00"},
                 * "updatedAt":{"date":"2020-11-13 08:10:44.000000","timezone_type":1,"timezone":"+00:00"},
                 * "captions":null,"playerId":null,"panoramic":false,"mp4Support":true}]
                 * 
                 * 
                 */

                foreach ($videos as $video) {


                    // nối mảng trên để đưa vào database
                    $productCourse = array_merge($productCourse, [


                        "video_id" => $video->videoId,

                        "thumbnail" => $video->assets["thumbnail"],

                        "type_content" => "vimeo",


                        "player" => $video->assets["player"]


                    ]);

                    // chỉ cần chọn 1 là đủ

                    break;
                }

                // xóa video của hệ thống
                if (is_file($file))
                    unlink($file);
            }

            // nếu là file pdf


            else {

                $productCourse["type_content"] = "pdf";
                $productCourse["player"] = $file;
            }
        }

        Product_course::create($productCourse);

        return redirect()->back()->with("notification", ["alert" => "Thêm thành công", "type" => "success"]);
    }





    public function indexOnline($id, $option = "", Request $request)
    {

        // static

        $static = [

            "index" => Product_course::where([["course_id", $id], ["parent_id", "<>", 0]])->count(),


            "trash" => Product_course::onlyTrashed()->where([["course_id", $id], ["parent_id", "<>", 0]])->count()


        ];


        // get course by id

        $course = Course::where([["id", $id], ["cat_id", 1]])->first();

        // validate

        if (!$course)
            return redirect()->back();


        $chapters = Product_course::where([["course_id", $id], ["parent_id", 0]])->get();

        // $productCourse = Product_course::where([['course_id', $id], []]);

        $fields = $request->input();
        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "created_at"]);


        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";


        // thiếu chức năng thùng rác    


        $whereAdvance = "`course_id` = {$id} AND `parent_id` != 0 ";

        // where fields chapter pay
        $fillters = ['parent_id', 'view'];
        foreach ($fillters as $fillter) {

            // kết hợp 2 điều kiện mới được nếu k sẽ bị lỗi

            if (array_key_exists($fillter, $fields) && $fields[$fillter]) {

                $whereAdvance .= " AND `{$fillter}`= '$fields[$fillter]' ";
            }
        }

        $whereAdvance .= " AND `name` LIKE '%{$seach}%'";

        // return $whereAdvance;

        $productCourses = empty($option) ? Product_course::select('id', 'name', 'view',  'type_content', 'parent_id', 'status', 'created_at', 'player') : Product_course::onlyTrashed()->select('id', 'name', 'view', 'type_content', 'parent_id', 'status', 'created_at', 'player');

        $productCourses = $productCourses->whereRaw($whereAdvance)->orderByRaw($orderBy)->paginate($limit);


        return view("admin.productCourse.indexOnline", compact("course", "chapters", "productCourses", "static", "option"));
    }


    public function updateOnline($id)

    {
        // get prouduct course lấy id cập nhật và lấy chương
        $productCourse = Product_course::where([["id", $id], ["parent_id", "<>", 0]])->first();

        // get chapters
        $chapters = Product_course::where("parent_id", 0)->get();

        return view("admin.productCourse.addOnline", compact("productCourse", "chapters"));
    }




    public function doUpdateOnline($id, Request $request)

    {
        // get chapter validate

        $chapters = Product_course::where("parent_id", 0)->get();

        $chapterCheck = "";
        foreach ($chapters as $item) {

            $chapterCheck .= $item->id . ",";
        }
        $chapterCheck = substr($chapterCheck, 0, -1);


        $request->validate(
            [
                "name" => "required:unique:product_courses",
                "course_id" => "nullable|integer",
                "parent_id" => "in:" . $chapterCheck,
                "view" => "required|in:pay,free",
                "status" => "required|in:show,hiden",
                "content" => "mimes:mp4,mov,ogg,qt,pdf"
            ],
            [
                "name.required" => ":attribute không được bỏ trống",
                "unique.unique" => ":attribute đã tồn tại hệ thống",
                'content.mimes' => ":attribute phải định dạng video hay pdf",
            ],
            [
                "name" => "Tên bài giảng",
                "content" => "nội dung bài học"
            ]
        );

        $productCourse = $request->input();

        // không cho phép update cùng tên bài giảng
        $productCourseSql = Product_course::where("id", "<>", $id)->whereRaw("`name`='{$productCourse['name']}'");


        if ($productCourseSql->count())
            return redirect()->back()->with("notification", ["alert" => "Đã tồn tại bài giảng này", "type" => "error"]);


        // check upload file

        if ($request->hasFile("content")) {
            // config api 

            // Authenticate in production environment
            $client = Client::create('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');


            // Alternatively, authenticate in sandbox environment for testing
            $client = Client::createSandbox('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');


            $productCourseDb = Product_course::find($id);
            $player = $request->content;

            // get videoId and player  
            $videoId = $productCourseDb->video_id;
            $playerDb = $productCourseDb->player;

            // xóa file upload pdf nếu có

            if (is_file($playerDb))
                unlink($playerDb);


            // xóa video api video nếu có
            $client->videos->delete($videoId);

            // get file name upload file
            $filename = Str::slug($productCourse["name"]);



            // get type file

            $type = $player->getClientOriginalExtension();

            // đường dẫn video của khóa học online
            $dir = "uploads/courses/online/video";
            // là file pdf đường dẫn khác
            if ($player->getMimeType() == "application/pdf")
                $dir = "uploads/courses/online/pdf";

            // di chuyển file upload

            $file = $player->move("public/" . $dir, $filename . "." . $type);

            if (Str::upper($type) != "PDF") {

                // Create and upload a video resource from local drive
                $video = $client->videos->upload(
                    $file,
                    array('title' => $filename)
                );

                // seach tìm id

                // Search video by tags filter and paginate results
                $videos = $client->videos->search(
                    array(
                        'title' => $filename
                    )
                );

                /**
                 *  [
                 * {"videoId":"vi5QKd6gFEq1PFFjmablsMBq",
                 * "title":"B\u00e0i gi\u1ea3ng 13",
                 * "description":"",
                 * "public":true,
                 * "tags":[],
                 * "metadata":[],
                 * "source":{"type":"upload","uri":"\/videos\/vi5QKd6gFEq1PFFjmablsMBq\/source"},
                 * "assets":{"iframe":"<iframe src=\"https:\/\/embed.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\" width=\"100%\" height=\"100%\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"true\"><\/iframe>",
                 * "player":"https:\/\/embed.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq",
                 * "hls":"https:\/\/cdn.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\/hls\/manifest.m3u8",
                 * "thumbnail":"https:\/\/cdn.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\/thumbnail.jpg",
                 * "mp4":"https:\/\/cdn.api.video\/vod\/vi5QKd6gFEq1PFFjmablsMBq\/mp4\/720\/source.mp4"},
                 * "publishedAt":{"date":"2020-11-13 08:10:44.000000","timezone_type":1,"timezone":"+00:00"},
                 * "updatedAt":{"date":"2020-11-13 08:10:44.000000","timezone_type":1,"timezone":"+00:00"},
                 * "captions":null,"playerId":null,"panoramic":false,"mp4Support":true}]
                 * 
                 * 
                 */

                foreach ($videos as $video) {


                    // nối mảng trên để đưa vào database
                    $productCourse["video_id"] = $video->videoId;

                    $productCourse["thumbnail"] = $video->assets["thumbnail"];

                    $productCourse["type_content"] = "vimeo";

                    $productCourse["player"] = $video->assets["player"];

                    // chỉ cần chọn 1 là đủ

                    break;
                }

                // xóa video của hệ thống
                if (is_file($file))
                    unlink($file);
            }

            // nếu là file pdf
            else {


                $productCourse["type_content"] = "pdf";
                $productCourse["player"] = $file;
                $productCourse["video_id"] = NULL;
            }
        }


        Product_course::find($id)->update($productCourse);

        return redirect()->back()->with("notification", ["alert" => "Cập nhật thành công bài giang online ", "type" => "success"]);
    }




    public function deleteOnline($id)
    {

        $productCourse = Product_course::find($id);

        // check product course
        if (!$productCourse)
            return redirect()->back();

        // delete 

        $productCourse->delete();

        return redirect()->back()->with("notification", ["alert" => "Đã đưa bài giảng online vào thùng rác ", "type" => "success"]);
    }




    public function restoreOnline($id)
    {



        $productCourse = Product_course::onlyTrashed()->find($id);

        // check product course
        if (!$productCourse)
            return redirect()->back();

        // delete 

        $productCourse->restore();

        return redirect()->back()->with("notification", ["alert" => "Đã phục hồi bài giảng online", "type" => "success"]);
    }


    public function destroyOnline($id)

    {
        // Authenticate in production environment
        $client = Client::create('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');


        // Alternatively, authenticate in sandbox environment for testing
        $client = Client::createSandbox('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');

        $productCourse = Product_course::onlyTrashed()->find($id);

        // xóa api video 
        $client->videos->delete($productCourse->video_id);

        // xóa file pdf
        if (is_file($productCourse->player))
            unlink($productCourse->player);
        // xóa db
        $productCourse->forceDelete();
        return redirect()->back()->with("notification", ["alert" => "Xóa thành công bài giảng", "type" => "success"]);
    }



    public function multitaskOnline ($option, Request $request)
    {
        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $temp = 0;
        foreach ($ids as $id) {

            if ($option == "trash")
                $slider = Product_course::find($id);
            else
                $slider = Product_course::onlyTrashed()->find($id);

            //  lại bỏ user không tồn tại 
            if (!$slider)
                continue;

            $temp++;

            // xóa user
            if ($option == "trash")
                $slider->delete();
            else
                $slider->restore();
        }
        return response()->json(["alert" => "Đã Áp dụng $temp khóa học"]);
    }
}
