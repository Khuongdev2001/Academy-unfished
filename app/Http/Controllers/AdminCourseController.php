<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cat_course;
use App\Models\Course;
use Illuminate\Support\Str;



class AdminCourseController extends Controller
{
    public function add()

    {
        // get cat online or offline
        $catCourse = Cat_course::all('id', 'name');

        // get cat parent tree
        $courses = tree(Course::all());

        // static

        $static = [


            "index" => Course::count(),

            "trash" => Course::onlyTrashed()->count()


        ];

        return view("admin.course.add", compact("catCourse", "courses", "static"));
    }


    public function doAdd(Request $request)

    {

        // get cat parent validate 

        $catCourse = Cat_course::all('id');

        $catCheck = "";
        foreach ($catCourse as $item) {

            $catCheck .= $item->id . ",";
        }
        $catCheck = substr($catCheck, 0, -1);


        $request->validate(
            [

                "name" => "required",
                "price" => "nullable|integer",
                "price_old" => "nullable|integer",
                "status" => "required|in:show,hidden",
                "content" => "required",
                "view" => "nullable|integer",
                "thumbnail" => "image",
                "video" => "mimes:mp4,mov,ogg,qt | max:20000",
                "parent_id" => "nullable|in:{$catCheck}"
            ],
            [
                "name.required" => ":attribute không được bỏ trống",
                "price.integer" => ":attribute phải là dạng số",
                "price_old.integer" => ":attribute phải là dạng số",
                "status.required" => ":attribute không được bỏ trống",
                "content.required" => ":attribute không được bỏ trống",
                "view.integer" => ":attribute phải là dạng số",
                "thumbnail.image" => ":attribute phải là định dạng ảnh",
                "video.mimes" => ":attribute phải định dạng video ",
                "parent_id.in" => ":attribute không phải có database"

            ],
            [
                "name" => "Tên khóa học",
                "price" => "Gía khóa học ",
                "price_old" => "Giá cũ khóa học",
                "status" => "Trạng thái",
                "content" => "Nội dung",
                "view" => "Lược xem",
                "thumbnail" => "Ảnh đại diện",
                "video" => "video demo",
                "parent_id" => "Danh mục cha"

            ]
        );


        // convert để upload theo offline hay online  


        $convert = [1 => "online", 2 => "offline"];

        $course = $request->input();

        $catId = $course["cat_id"];


        // online or offline
        $folderCourse = $convert[$catId];

        // check upload thumbnail
        if ($request->hasFile("thumbnail")) {

            // get input file
            $thumbnail = $request->thumbnail;
            // get type file

            $type = $thumbnail->getClientOriginalExtension();

            // convert file name slug

            $filename = Str::slug($course["name"]);

            // build dir

            $dir = "uploads/courses/" . $folderCourse . "/preview/thumbnail/";

            $thumbnail = $thumbnail->move("public/" . $dir, $filename . "." . $type);
            $course["thumbnail"] = $dir . $filename . "." . $type;
        }

        // check upload video

        if ($request->hasFile("video")) {
            // get input file
            $video = $request->video;
            // get type file

            $type = $video->getClientOriginalExtension();

            // convert file name slug

            $filename = Str::slug($course["name"]);

            // build dir

            $dir = "uploads/courses/" . $folderCourse . "/preview/video/";
            $video = $video->move("public/" . $dir, $filename . "." . $type);
            $course["video"] = $dir . $filename . "." . $type;
        }

        // add database
        $course["parent_id"] = empty($course["parent_id"]) ? 0 : $course["parent_id"];
        Course::create($course);

        // add success
        return redirect()->back();
    }




    public function index($cat, $option = "", Request $request)

    {
        $fields = $request->input();

        // get danh mục nhận khóa học online hay offline

        $catId = $cat;

        // get cat_Course

        $catCourse = Cat_course::find($catId);


        // chuyển hướng khi không tìm thấy cat_id url

        if (!$catCourse)
            return redirect()->back();

        // tạo select sẵn dùng chung


        $courseSelect = empty($catId) ? Course::select("thumbnail", "video", "price", "status", "cat_id", "name", "created_at", "id") : Course::where("cat_id", $catId)->select("thumbnail", "video", "price", "status", "cat_id", "name", "created_at", "id");

        // get static


        $static = [


            "index" => Course::where("cat_id", $catId)->count(),


            'trash' => Course::where("cat_id", $catId)->onlyTrashed()->count()



        ];

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "price", "created_at"]);


        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        // option trash
        if ($option)
            $courses = $courseSelect->onlyTrashed();


        $courses = $courseSelect->where('name', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);
        // $treeCourse = tree($courses);
        return view("admin.course.index", compact("courses","cat", "option", "static", "catCourse"));
    }


    public function update($id)

    {

        $course = Course::find($id);

        if (!$course)
            return redirect()->back();

        // get cat online or offline
        $catCourse = Cat_course::all('id', 'name');

        // get cat parent tree
        $courses = tree(Course::all());

        // static

        $static = [


            "index" => Course::count(),

            "trash" => Course::onlyTrashed()->count()


        ];

        return view("admin.course.add", compact("catCourse", "courses", "static", "course"));
    }


    public function doUpdate($id, Request $request)

    {
        // get course db

        $courseDb = Course::find($id);


        // get cat parent validate 

        $catCourse = Cat_course::all('id');

        $catCheck = "";
        foreach ($catCourse as $item) {

            $catCheck .= $item->id . ",";
        }
        $catCheck = substr($catCheck, 0, -1);


        $request->validate(
            [

                "name" => "required",
                "price" => "nullable|integer",
                "price_old" => "nullable|integer",
                "status" => "required|in:show,hidden",
                "content" => "required",
                "view" => "nullable|integer",
                "thumbnail" => "image",
                "video" => "mimes:mp4,mov,ogg,qt | max:20000",
                "parent_id" => "nullable|in:{$catCheck}"
            ],
            [
                "name.required" => ":attribute không được bỏ trống",
                "price.integer" => ":attribute phải là dạng số",
                "price_old.integer" => ":attribute phải là dạng số",
                "status.required" => ":attribute không được bỏ trống",
                "content.required" => ":attribute không được bỏ trống",
                "view.integer" => ":attribute phải là dạng số",
                "thumbnail.image" => ":attribute phải là định dạng ảnh",
                "video.mimes" => ":attribute phải định dạng video ",
                "parent_id.in" => ":attribute không phải có database"

            ],
            [
                "name" => "Tên khóa học",
                "price" => "Gía khóa học ",
                "price_old" => "Giá cũ khóa học",
                "status" => "Trạng thái",
                "content" => "Nội dung",
                "view" => "Lược xem",
                "thumbnail" => "Ảnh đại diện",
                "video" => "video demo",
                "parent_id" => "Danh mục cha"

            ]
        );


        // convert để upload theo offline hay online  


        $convert = [1 => "online", 2 => "offline"];

        $course = $request->input();

        $catId = $course["cat_id"];


        // online or offline
        $folderCourse = $convert[$catId];

        // check upload thumbnail
        if ($request->hasFile("thumbnail")) {

            // xóa thumbnail

            $thumbnailDb = $courseDb->thumbnail;

            if (is_file("public/" . $thumbnailDb))
                unlink("public/" . $thumbnailDb);

            // create thumbnail new upload    

            // get input file
            $thumbnail = $request->thumbnail;
            // get type file

            $type = $thumbnail->getClientOriginalExtension();

            // convert file name slug

            $filename = Str::slug($course["name"]);

            // build dir

            $dir = "uploads/courses/" . $folderCourse . "/preview/thumbnail/";

            $thumbnail = $thumbnail->move("public/" . $dir, $filename . "." . $type);
            $course["thumbnail"] = $dir . $filename . "." . $type;;
        }

        // check upload video

        if ($request->hasFile("video")) {

            // xóa video

            $videoDb = $courseDb->video;
            if (is_file("public/" . $videoDb))
                unlink("public/" . $videoDb);


            // create video new upload    
            // get input file
            $video = $request->video;
            // get type file

            $type = $video->getClientOriginalExtension();

            // convert file name slug

            $filename = Str::slug($course["name"]);

            // build dir

            $dir = "uploads/courses/" . $folderCourse . "/preview/video/";
            $video = $video->move("public/" . $dir, $filename . "." . $type);
            $course["video"] = $dir . $filename . "." . $type;;
        }

        // do update
        Course::find($id)->update($course);

        return redirect()->back()->with("notification", ["alert" => "Cập nhật thành công khóa học", "type" => "success"]);
    }



    public function delete($id)

    {
        $course = Course::find($id);
        if (!$course)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy khóa học", "type" => "error"]);
        $course->delete();

        return redirect()->back()->with("notification", ["alert" => "Đã đưa khóa học vào thùng rác", "type" => "success"]);
    }





    public function restore($id)

    {

        $course = Course::onlyTrashed()->find($id);
        if (!$course)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);
        // restore
        $course->restore();

        // redirect
        return redirect()->back()->with("notification", ["alert" => "Đã phục hồi bài viết", "type" => "success"]);
    }


    public function destroy($id)

    {

        $course = Course::onlyTrashed()->find($id);

        if (!$course)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy bài viết", "type" => "error"]);

        // get thumbnail

        $thumbnail = "public/" . $course->thumbnail;
        $video = "public/" . $course->video;



        if (is_file($thumbnail))
            // xóa file thumbnail
            unlink($thumbnail);


        if (is_file($video))
            unlink($video);


        // xóa database
        $course->forceDelete();

        // chuyển hướng
        return redirect()->back()->with("notification", ["alert" => "Đã xóa vĩnh viễn khóa học", "type" => "success"]);
    }



    public function multitask($option, Request $request)

    {

        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $temp = 0;
        foreach ($ids as $id) {

            if ($option == "trash")
                $course = Course::find($id);
            else
                $course = Course::onlyTrashed()->find($id);

            //  lại bỏ course không tồn tại 
            if (!$course)
                continue;

            $temp++;

            // xóa course
            if ($option == "trash")
                $course->delete();
            else
                $course->restore();
        }
        return response()->json(["alert" => "Đã thao tác $temp khóa học"]);
    }
}
