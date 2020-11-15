<?php

namespace App\Http\Controllers;

use App\Models\Comment_post;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index($id = "", Request $request)
    {

        // get post by cat

        $seach = $request->input("seach") ?? "n";

        $orderBy = sort_table($request->input(), ["created_at"]);

        $orderBy = $orderBy ? $orderBy : "`id` DESC ";

        $fieldSeach = ["name", "desc", "content"];

        $whereSeach = "`cat_id` = {$id} AND `status`='show' AND ( ";

        if (empty($id))
            $whereSeach = "`status`='show' AND ( ";


        foreach ($fieldSeach as $item) {

            $whereSeach .= "`{$item}` LIKE '%{$seach}%' OR ";
        }

        $whereSeach = substr($whereSeach, 0, -3);
        $whereSeach .= " )";

        $posts = Post::whereRaw($whereSeach)->orderByRaw($orderBy)->paginate(10);
        return view("client.post.index", compact("posts"));
    }

    public function detail($id)

    {

        $post = Post::find($id);
        // get next id 
        $nextId = Post::where("id", ">", $id)->min("id");
        // get prev id 
        $prevId = Post::where("id", "<", $id)->max("id");
        // get number comment
        $numComment = Comment_post::where("cat_id", $id)->count();
        // get comment
        $comments = Comment_post::where("cat_id", $id)->get();
        return view("client.post.detail", compact("post", "nextId", "prevId", "numComment", "comments"));
    }


    public function addComment($cat, Request $request)
    {

        // check login

        if (!Auth::check())
            return redirect()->back()->with("notification", ["alert" => "Bản phải đăng nhập", "type" => "error"]);


        $userId = Auth::user()->id;

        $comment = [

            "cat_id" => $cat,

            "user_id" => $userId,


            "content" => $request->input("content")

        ];

        Comment_post::create($comment);

        return redirect()->back()->with("notification", ["alert" => "Bình luận thành công", "type" => "success"]);
    }
}
