<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment_post;
use App\Models\Post;

class AdminCommentPostController extends Controller
{
    public function index($catId, Request $request)

    {
        $option = ["title"=>"Bài Viết","module"=>"post"];
        $cat = Post::find($catId);

        $static = [

            "index" => Comment_post::where([["parent_id", 0], ["cat_id", $catId]])->count(),

        ];

        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["content", "star"]);


        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $comments = Comment_post::select('id', 'content', 'user_id', 'cat_id', 'created_at', 'star', 'status');

        $comments = $comments->where([["parent_id", 0], ["cat_id", $catId], ["content", "LIKE", "%{$seach}%"]])->orderByRaw($orderBy)->paginate($limit);


        return view("admin.comment.index", compact("option", "cat", "comments", "static"));
    }




    public function response($catId, $id)
    {
        $option = ["title"=>"Bài Viết","module"=>"post"];

        $cat = Post::find($catId);

        $comment = Comment_post::find($id);


        return view("admin.comment.response", compact("option", "cat", "comment"));
    }




    public function doResponse($catId, $id, Request $request)
    {

        Comment_post::find($id)->update($request->input());
        return redirect()->route("admin.comment.course", $catId)->with("notification", ["alert" => "Cập nhật thành công comment", "type" => "success"]);
    }




    public function delete($catId, $id)

    {
        // get comment_course
        $comment = Comment_post::find($id);

        // delete file public

        if (is_file("public/" . $comment->thumbnail))
            unlink("public/" . $comment->thumbnail);

        if (is_file("public/" . $comment->video))
            unlink("public/" . $comment->video);

        // delete file database
        $comment->delete();
        return redirect()->route("admin.comment.course", $catId)->with("notification", ["alert" => "Xóa thành công comment", "type" => "success"]);
    }



    public function multitask(Request $request)

    {
        // option

        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $temp = 0;
        foreach ($ids as $id) {

            $comment = Comment_post::find($id);

            //  lại bỏ course không tồn tại 
            if (!$comment)
                continue;

            $temp++;

            // delete file public

            if (is_file("public/" . $comment->thumbnail))
                unlink("public/" . $comment->thumbnail);

            if (is_file("public/" . $comment->video))
                unlink("public/" . $comment->video);

            // delete file database
            $comment->delete();
        }
        return response()->json(["alert" => "Đã thao tác $temp comment"]);
    }
}
