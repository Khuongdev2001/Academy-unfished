<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;


class AdminSliderController extends Controller
{
    //

    public function index($option = "", Request $request)

    {
        // get static

        $static = [

            "index" => Slider::count(),

            "trash" => Slider::onlyTrashed()->count()

        ];

        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "created_at"]);
        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $sliders = Slider::select('id', 'thumbnail', 'status', 'created_at', 'name');

        if ($option)
            $sliders = Slider::onlyTrashed()->select('id', 'thumbnail', 'status', 'created_at', 'name');

        $sliders = $sliders->where('name', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);
        return view("admin.slider.index", compact("sliders", "static", "option"));
    }

    public function add()
    {

        // no code


    }


    public function doAdd(Request $request)
    {
        $request->validate(
            [
                "status" => "required|in:show,hidden",
                "thumbnail" => "required|image",
                "name" => "required"
            ],
            [
                "status.required" => ":attribute không được bỏ trống",
                "thumbnail.required" => ":attribute không được bỏ trống",
                "thumbnail.image" => ":attribute không phải định dạng ảnh",
                "name.required" => ":attribute không được bỏ trống"
            ],
            [
                "status" => "Trạng thái ",
                "thumbnail" => "Ảnh đại diện",
                "name" => "Tiêu đề slider"

            ]
        );

        $slider = $request->input();

        // give file width time()
        $filename = time() . ".png";

        // convert base 64
        $base64Content = convert_base64($slider["thumbnailHidden"]);
        $dir = "uploads/sliders/";
        // create file 
        file_put_contents("public/" . $dir . $filename, $base64Content);
        $slider["thumbnail"] = $dir . $filename;
        // bỏ trường thumbnailHidden
        unset($slider["thumbnailHidden"], $slider["_token"]);

        // add database

        Slider::create($slider);

        // chuyển hướng
        return redirect()->back()->with("notification", ["alert" => "Thêm thành công slider", "type" => "success"]);
    }




    public function update($id, Request $request)
    {


        $slider = Slider::find($id);


        // get static

        $static = [

            "index" => Slider::count(),

            "trash" => Slider::onlyTrashed()->count()

        ];

        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "created_at"]);
        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $sliders = Slider::select('id', 'thumbnail', 'status', 'created_at', 'name');

        $sliders = $sliders->where('name', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);


        return view("admin.slider.index", compact("sliders", "slider", "static"));
    }

    public function doUpdate($id, Request $request)
    {

        $request->validate(
            [
                "status" => "required|in:show,hidden",
                "thumbnail" => "image",
                "name" => "required"
            ],
            [
                "status.required" => ":attribute không được bỏ trống",
                "thumbnail.image" => ":attribute không phải định dạng ảnh",
                "name.required" => ":attribute không được bỏ trống"
            ],
            [
                "status" => "Trạng thái ",
                "thumbnail" => "Ảnh đại diện",
                "name" => "Tiêu đề slider"

            ]
        );

        $slider = $request->input();


        if ($request->hasFile("thumbnail")) {
            // get thumbnail username
            $thumbnail = Slider::find($id)->thumbnail;
            // xóa thumbnail
            if (is_file("public/" .  $thumbnail))
                unlink("public/" . $thumbnail);
            // slug-a.png
            $filename = time() . ".png";
            $dir = "uploads/sliders/";
            // convert base 64
            $base64Content = convert_base64($slider["thumbnailHidden"]);
            // create file 
            file_put_contents("public/" . $dir . $filename, $base64Content);
            $slider["thumbnail"] = $dir . $filename;
            // bỏ trường thumbnailHidden
            unset($slider["thumbnailHidden"], $slider["_token"]);
        }

        // update slider


        

        Slider::find($id)->update($slider);
        return redirect()->back()->with("notification", ["alert" => "Cập Nhật Thanh Công", 'type' => "success"]);
    }





    public function delete($id)
    {


        $slider = Slider::find($id);
        if (!$slider)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);

        $slider->delete();

        return redirect()->back()->with("notification", ["alert" => "Đã đưa bài viết vào thùng rác", "type" => "success"]);
    }


    public function restore($id)


    {
        $slider = Slider::onlyTrashed()->find($id);
        if (!$slider)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);

        // restore
        $slider->restore();

        // redirect
        return redirect()->back()->with("notification", ["alert" => "Đã phục hồi bài viết", "type" => "success"]);
    }

    public function destroy($id)

    {

        $slider = Slider::onlyTrashed()->find($id);

        if (!$slider)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy bài viết", "type" => "error"]);

        // get thumbnail

        $thumbnail = "public/" . $slider->thumbnail;
        if (is_file($thumbnail)) {
            // xóa file
            unlink($thumbnail);
        }

        // xóa database
        $slider->forceDelete();


        // chuyển hướng
        return redirect()->back()->with("notification", ["alert" => "Đã xóa vĩnh viễn slider", "type" => "success"]);
    }


    public function multitask($option, Request $request)
    {
        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $temp = 0;
        foreach ($ids as $id) {

            if ($option == "trash")
                $slider = Slider::find($id);
            else
                $slider = Slider::onlyTrashed()->find($id);

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
        return response()->json(["alert" => "Đã Áp dụng $temp slider"]);
    }
}
