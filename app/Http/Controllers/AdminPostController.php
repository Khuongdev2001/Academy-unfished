<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cat_post;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AdminPostController extends Controller
{
    //
    public function addCat()
    {

        $cats = tree(Cat_post::all());
        $static = [
            'index' => Cat_post::count()
        ];
        return view("admin.post.indexCat", compact("cats", "static"));
    }

    public function doAddCat(Request $request)
    {

        $request->validate(

            [
                'name' => 'required|min:5',
                'parent_id' => 'nullable|integer',
                'status' => 'in:show,hidden'
            ],

            [
                'name.required' => ":attribute không được bỏ trống",
                'name.min' => ":attribute it nhất 5 ký tự"
            ],

            [

                'name' => 'Tiêu đề Danh mục'

            ]
        );

        Cat_post::create($request->input());
        return redirect()->back()->with("notification", ["alert" => "Thêm Thành công danh mục", "type" => "success"]);
    }


    public function updateCat($id)
    {

        $catDb = Cat_post::find($id);
        $cats = tree(Cat_post::all());


        $static = [
            'index' => Cat_post::count()
        ];
        return view("admin.post.indexCat", compact("cats", "catDb", "static"));
    }



    public function doUpdateCat($id, Request $request)

    {

        $request->validate(

            [
                'name' => 'required|min:5',
                'parent_id' => 'nullable|integer'
            ],

            [
                'name.required' => ":attribute không được bỏ trống",
                'name.min' => ":attribute it nhất 5 ký tự"
            ],

            [

                'name' => 'Tiêu đề Danh mục'

            ]
        );
        $cat = request()->input();

        // update
        if (Cat_post::where("parent_id", $id)->count()) {

            Cat_post::find($id)->update(["name" => $cat["name"], "status" => $cat["status"]]);

            return redirect()->back()->with("notification", ["alert" => "Không thể di chuyển danh mục cha khi có danh mục con", "type" => "error"]);
        }


        Cat_post::find($id)->update($cat);
        return redirect()->back()->with("notification", ["alert" => "Cập nhật thành công danh mục", "type" => "success"]);
    }


    public function deleteCat($id)

    {
        // check cat exitst
        if (!Cat_post::find($id))
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy danh mục", "type" => "error"]);
        // check cat parent xem có con không

        if (Cat_post::where("parent_id", $id)->count())
            return redirect()->back()->with("notification", ["alert" => "Không thể xóa danh mục cha đang chưa con", "type" => "error"]);

        Cat_post::find($id)->delete();
        return redirect()->back()->with("notification", ["alert" => "Xóa thành công danh mục", "type" => "success"]);
    }


    public function add()

    {
        $cats = tree(Cat_post::all()->where("status", "show"));
        return view("admin.post.add", compact("cats"));
    }


    public function doAdd(Request $request)
    {

        $request->validate(
            [
                "name" => "required|min:12",
                "cat_id" => "required|integer",
                "content" => "required|min:12",
                "desc" => "required|min:12",
                "thumbnail" => "required|image",
                "status" => "in:show,hidden"
            ],
            [
                "name.required" => ":attribute không được bỏ trống ",
                'name.min' => ":attribute ít nhất 12 ký tự",
                "content.required" => ":attribute không được bỏ trống",
                "content.min" => ":attribute ít nhất 12 ký tự ",
                "desc.required" => ":attribute không được bỏ trống",
                "desc.min" => ":attribute ít nhất 12 ký tự",
                "thumbnail.required" => ":attribute không được bỏ trống",
                "thumbnail.image" => ":attribute là định dạng ảnh",
                "cat_id.required" => ":attribute không được bỏ trống",
            ],
            [
                "name" => "Tiêu đề bài viết",
                "content" => "Nội dung bài viết",
                "desc" => "Mô tả bài viết",
                "thumbnail" => "Ảnh đại diện",
                "cat_id" => "Danh mục"
            ]
        );
        $post = $request->input();
        // slug-a.png
        $filename = Str::slug($post["name"]) . ".png";
        $dir = "uploads/posts/";
        // convert base 64
        $base64Content = convert_base64($post["thumbnailHidden"]);
        // create file 
        file_put_contents("public/" . $dir . $filename, $base64Content);

        $post["thumbnail"] = $dir . $filename;
        // bỏ trường thumbnailHidden
        unset($post["thumbnailHidden"], $post["_token"]);

        // add database

        // get creator
        $post["creator"] = Auth::user()->id;


        Post::create($post);

        // chuyển hướng
        return redirect()->route("admin.post")->with("notification", ["alert" => "Thêm thành công bài viết", "type" => "success"]);
    }


    public function index($option = "", Request $request)

    {
        // get static

        $static = [
            "index" => Post::count(),

            'trash' => Post::onlyTrashed()->count()
        ];

        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["name", "desc"]);


        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $posts = Post::select('id', 'name','status', 'desc', 'thumbnail', 'created_at', 'cat_id');

        // option trash
        if ($option)
            $posts = Post::onlyTrashed()->select('id', 'name','status', 'desc', 'thumbnail', 'created_at', 'cat_id');


        $posts = $posts->where('name', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);



        return view("admin.post.index", compact("posts", "option", "static"));
    }



    public function update($id)

    {
        /// get post 
        $post = Post::find($id);


        // get cat
        $cats = tree(Cat_post::all());
        return view("admin.post.add", compact("cats", "post"));
    }

    public function doUpdate($id, Request $request)

    {

        $request->validate(
            [
                "name" => "required|min:12",
                "cat_id" => "required|integer",
                "content" => "required|min:12",
                "desc" => "required|min:12",
                "thumbnail" => "image",
                "status" => "in:show,hidden"
            ],
            [
                "name.required" => ":attribute không được bỏ trống ",
                'name.min' => ":attribute ít nhất 12 ký tự",
                "content.required" => ":attribute không được bỏ trống",
                "content.min" => ":attribute ít nhất 12 ký tự ",
                "desc.required" => ":attribute không được bỏ trống",
                "desc.min" => ":attribute ít nhất 12 ký tự",
                "thumbnail.image" => ":attribute là định dạng ảnh",
                "cat_id.required" => ":attribute không được bỏ trống",
            ],
            [
                "name" => "Tiêu đề bài viết",
                "content" => "Nội dung bài viết",
                "desc" => "Mô tả bài viết",
                "thumbnail" => "Ảnh đại diện",
                "cat_id" => "Danh mục"
            ]
        );
        $post = $request->input();
        // check upload file
        if ($request->hasFile("thumbnail")) {
            // get thumbnail username
            $thumbnail = Post::find($id)->thumbnail;
            // xóa thumbnail
            if (is_file("public/" .  $thumbnail))
                unlink("public/" . $thumbnail);
            // slug-a.png
            $filename = Str::slug($post["name"]) . ".png";
            $dir = "uploads/posts/";
            // convert base 64
            $base64Content = convert_base64($post["thumbnailHidden"]);
            // create file 
            file_put_contents("public/" . $dir . $filename, $base64Content);
            $post["thumbnail"] = $dir . $filename;
        }
        // bỏ trường thumbnailHidden
        unset($post["thumbnailHidden"], $post["_token"]);

        // update users

        Post::find($id)->update($post);

        return redirect()->back()->with("notification", ["alert" => "Cập Nhật Thanh Công", 'type' => "success"]);
    }



    public function delete($id)

    {
        $post = Post::find($id);
        if (!$post)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);
        $post->delete();


        return redirect()->back()->with("notification", ["alert" => "Đã đưa bài viết vào thùng rác", "type" => "success"]);
    }




    public function restore($id)


    {
        $post = Post::onlyTrashed()->find($id);
        if (!$post)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);
        // restore
        $post->restore();

        // redirect
        return redirect()->back()->with("notification", ["alert" => "Đã phục hồi bài viết", "type" => "success"]);
    }

    public function destroy($id)

    {

        $post = Post::onlyTrashed()->find($id);

        if (!$post)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy bài viết", "type" => "error"]);

        // get thumbnail

        $thumbnail = "public/" . $post->thumbnail;
        if (is_file($thumbnail)) {
            // xóa file
            unlink($thumbnail);
        }

        // xóa database
        $post->forceDelete();


        // chuyển hướng
        return redirect()->back()->with("notification", ["alert" => "Đã xóa vĩnh viễn bài viết ", "type" => "success"]);
    }



    public function multitask($option, Request $request)
    {
        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $temp = 0;
        foreach ($ids as $id) {

            if ($option == "trash")
                $post = Post::find($id);
            else
                $post = Post::onlyTrashed()->find($id);

            //  lại bỏ user không tồn tại 
            if (!$post)
                continue;

            $temp++;

            // xóa user
            if ($option == "trash")
                $post->delete();
            else
                $post->restore();
        }
        return response()->json(["alert" => "Đã xóa $temp bài viết"]);
    }
}
