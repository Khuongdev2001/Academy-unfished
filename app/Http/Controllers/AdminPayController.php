<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pay;
use Illuminate\Support\Str;


class AdminPayController extends Controller
{
    //
    public function index($option = "", Request $request)

    {

        $static = [

            'index' => Pay::count(),

            'trash' => Pay::onlyTrashed()->count()

        ];


        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "info", "created_at"]);
        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $pays = Pay::select('id', 'thumbnail', 'status', 'created_at', 'name', 'discount', 'info');

        if ($option)
            $pays = Pay::onlyTrashed()->select('id', 'thumbnail', 'status', 'created_at', 'name', 'discount', 'info');

        $pays = $pays->where('name', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);


        return view("admin.pay.index", compact("static", "pays", "option"));
    }

    public function add()

    {
    }


    public function doAdd(Request $request)


    {


        $request->validate(
            [
                "thumbnail" => "required|image",
                "name" => "required|string",
                "status" => "in:show,hidden",
                "discount" => "nullable|integer",
                "info" => "required"
            ],
            [
                "thumbnail.required" => ":attribute không được bỏ trống",
                "thumbnail.image" => ":attribute là định dạng ảnh",
                "name.required" => ":attribute là định dạng ảnh",
                "name.string" => ":attribute là định dạng chuỗi",
                "info.required" => ":attribute không được bỏ trống"

            ],
            [

                "thumbnail" => "Ảnh đại diện",
                "name" => "Tên thanh toán",
                "info" => "Thông tin thanh toán"
            ]
        );


        $pay = $request->input();

        // give file width time()
        $filename = Str::slug($pay["name"]) . ".png";

        // convert base 64
        $base64Content = convert_base64($pay["thumbnailHidden"]);
        $dir = "uploads/pays/";
        // create file 
        file_put_contents("public/" . $dir . $filename, $base64Content);
        $pay["thumbnail"] = $dir . $filename;
        // bỏ trường thumbnailHidden
        unset($pay["thumbnailHidden"], $pay["_token"]);

        // add database

        Pay::create($pay);

        // chuyển hướng
        return redirect()->back()->with("notification", ["alert" => "Thêm thành công thanh toán", "type" => "success"]);
    }


    public function update(Request $request, $id)
    {

        $pay = Pay::find($id);


        // get static

        $static = [

            'index' => Pay::count(),



            'trash' => Pay::onlyTrashed()->count()

        ];


        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "info", "created_at"]);
        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $pays = Pay::select('id', 'thumbnail', 'status', 'created_at', 'name', 'discount', 'info');

        $pays = $pays->where('name', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);

        return view("admin.pay.index", compact("pays", "pay", "static"));
    }


    public function doUpdate($id, Request $request)
    {

        $request->validate(
            [
                "thumbnail" => "image",
                "name" => "required|string",
                "status" => "in:show,hidden",
                "discount" => "nullable|integer",
                "info" => "required"
            ],
            [
                "thumbnail.image" => ":attribute là định dạng ảnh",
                "name.required" => ":attribute là định dạng ảnh",
                "name.string" => ":attribute là định dạng chuỗi",
                "info.required" => ":attribute không được bỏ trống"

            ],
            [

                "thumbnail" => "Ảnh đại diện",
                "name" => "Tên thanh toán",
                "info" => "Thông tin thanh toán"
            ]
        );

        $pay = $request->input();


        if ($request->hasFile("thumbnail")) {
            // get thumbnail username
            $thumbnail = Pay::find($id)->thumbnail;
            // xóa thumbnail
            if (is_file("public/" .  $thumbnail))
                unlink("public/" . $thumbnail);
            // slug-a.png
            $filename = $pay["name"] . ".png";
            $dir = "uploads/pays/";
            // convert base 64
            $base64Content = convert_base64($pay["thumbnailHidden"]);
            // create file 
            file_put_contents("public/" . $dir . $filename, $base64Content);
            $pay["thumbnail"] = $dir . $filename;
            // bỏ trường thumbnailHidden
            unset($pay["thumbnailHidden"], $pay["_token"]);
        }

        // update slider

        Pay::find($id)->update($pay);
        return redirect()->back()->with("notification", ["alert" => "Cập Nhật Thành Công Thanh Toán", 'type' => "success"]);
    }



    public function delete($id)

    {

        $pay = Pay::find($id);
        if (!$pay)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy thanh toán", "type" => "error"]);

        $pay->delete();

        return redirect()->back()->with("notification", ["alert" => "Đã đưa thanh toán vào thùng rác", "type" => "success"]);
    }

    public function restore($id)

    {
        $pay = Pay::onlyTrashed()->find($id);
        if (!$pay)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy thanh toán", "type" => "error"]);



        // restore
        $pay->restore();

        // redirect
        return redirect()->back()->with("notification", ["alert" => "Đã phục hồi thanh toán", "type" => "success"]);
    }






    public function destroy($id)
    {

        $pay = Pay::onlyTrashed()->find($id);

        if (!$pay)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy bài viết", "type" => "error"]);

        // get thumbnail

        $thumbnail = "public/" . $pay->thumbnail;
        if (is_file($thumbnail)) {
            // xóa file
            unlink($thumbnail);
        }

        // xóa database
        $pay->forceDelete();


        // chuyển hướng
        return redirect()->back()->with("notification", ["alert" => "Đã xóa vĩnh viễn slider", "type" => "success"]);
    }

    public function multitask($option = "", Request $request)

    {
        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $temp = 0;
        foreach ($ids as $id) {

            if ($option == "trash")
                $pay = Pay::find($id);
            else
                $pay = Pay::onlyTrashed()->find($id);

            //  lại bỏ user không tồn tại 
            if (!$pay)
                continue;

            $temp++;

            // xóa user
            if ($option == "trash")
                $pay->delete();
            else
                $pay->restore();
        }
        return response()->json(["alert" => "Đã Áp dụng $temp thanh toán"]);
    }
}
