<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\User_role;
use App\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Continue_;

class AdminUserController extends Controller
{

    public function login()
    {
        return view("admin.user.login");
    }




    public function doLogin(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'min:13'
            ],
            [
                'email.required' => ':attribute không được bỏ trống',
                'email.email' => ':attribute không phải là dạng email',
                'password.min' => ':attribute ít nhất 13 từ '
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );

        $login = $request->input();
        $email = $login["email"];
        $password =  $login["password"];
        // check login return true = >login
        if (Auth::attempt(
            [
                'email' => $email,
                'password' => $password
            ]
        )) {
            // save info user login
            $role = Auth::user()->role->first()->name;

            $roleAccept = ["admin", "updater", "deleter", "addter"];
        };

        if (!Auth::check() ||  isset($role, $roleAccept) && !in_array($role, $roleAccept)) {

            $this->logout();
            return redirect()->route("admin.user.login")->with("notification", ["alert" => "Thông tin email và mật khẩu không chính xác", "type" => "error"]);
        }

        return redirect()->route("admin.dashboard")->with("notification",["alert"=>"Đăng nhập thành công","type"=>"success"]);
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->route("admin.user.login");
    }



    public function add()
    {
        $roles = Role::all();
        return view("admin.user.add", compact("roles"));
    }



    public function doAdd(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'phone' => 'min:9|max:12|unique:users',
                'username' => 'required|min:10|unique:users',
                'password' => 'required|min:10',
                'thumbnail' => 'required|image'
            ],
            [
                'fullname.required' => ':attribute không được bỏ trống',
                'fullname.unique' => ':attribute đã có tồn tại',
                'email.required' => ':attribute không được bỏ trống',
                'email.email' => ':attribute không phải định dạng Email',
                'phone.min' => ':attribute lỗi định dạng điện thoại',
                'phone.max' => ':attribute lỗi định dạng điện thoại',
                'username.required' => ':attribute không được bỏ trống',
                'username.min' => ':attribute ít nhất 10 ký tự',
                'password.required' => ':attribute không được bỏ trống',
                'password.min' => ':attribute ít nhất 10 ký tự',
                'thumbnail.required' => ':attribute không được bỏ trống',
                'thumbnail.image' => ':attribute không phải là định dạng ảnh',
                'fullname.unique' => ':attribute đã tồn tại trong hệ thống',
                'email.unique' => ':attribute đã tồn tại trong hệ thống',
                'phone.unique' => ':attribute đã tồn tại trong hệ thống',
                'username.unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'fullname' => 'Tên',
                'phone' => 'Số điện thoại',
                'email' => 'Email',
                'username' => 'Tài khoản',
                'password' => 'Mật khẩu',
                'thumbnail' => 'Ảnh đại diện'
            ]
        );
        $user = $request->input();
        // slug-a.png
        $filename = Str::slug($user["fullname"]) . ".png";
        $dir = "uploads/users/";
        // convert base 64
        $base64Content = convert_base64($user["thumbnailHidden"]);
        // create file 
        file_put_contents("public/" . $dir . $filename, $base64Content);

        $user["thumbnail"] = $dir . $filename;
        // bỏ trường thumbnailHidden
        unset($user["thumbnailHidden"], $user["_token"]);

        // hash password
        $user["password"] = Hash::make($user["password"]);
        $role_id = $user["role_id"];
        $user_id = User::create($user)->id;


        // create user_roles
        User_role::create(["role_id" => $role_id, "user_id" => $user_id]);

        // chuyển hướng
        return redirect()->route("admin.user")->with("notification", ["alert" => "Thêm thành công user", "type" => "success"]);
    }

    public function index($option = "", Request $request)
    {
        // get static

        $static = [
            "index" => User::count(),

            'trash' => User::onlyTrashed()->count()
        ];

        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["fullname", "username", "email", "phone", "created_at"]);
        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $users = User::select('id', 'fullname', 'username', 'email', 'phone', 'created_at', 'thumbnail');

        // option trash
        if ($option)
            $users = User::onlyTrashed()->select('id', 'fullname', 'username', 'email', 'phone', 'created_at', 'thumbnail');

        $users = $users->where('fullname', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);
        return view("admin.user.index", compact("users", "option", "static"));
    }
    public function update($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return view("admin.user.add", compact("roles", "user"));
    }

    public function doUpdate($id, Request $request)
    {

        $request->validate(
            [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => 'min:9|max:12',
                'username' => 'required|min:10',
                'password' => 'required|min:10',
                'thumbnail' => 'image'
            ],
            [
                'fullname.required' => ':attribute không được bỏ trống',
                'email.required' => ':attribute không được bỏ trống',
                'email.email' => ':attribute không phải định dạng Email',
                'phone.min' => ':attribute lỗi định dạng điện thoại',
                'phone.max' => ':attribute lỗi định dạng điện thoại',
                'username.required' => ':attribute không được bỏ trống',
                'username.min' => ':attribute ít nhất 10 ký tự',
                'password.required' => ':attribute không được bỏ trống',
                'password.min' => ':attribute ít nhất 10 ký tự',
                'thumbnail.required' => ':attribute không được bỏ trống',
                'thumbnail.image' => ':attribute không phải là định dạng ảnh',
            ],
            [
                'fullname' => 'Tên',
                'phone' => 'Số điện thoại',
                'email' => 'Email',
                'username' => 'Tài khoản',
                'password' => 'Mật khẩu',
                'thumbnail' => 'Ảnh đại diện'
            ]
        );
        $user = $request->input();
        $userSql = User::where("id", "<>", $id)->whereRaw("(`username`='{$user['username']}' OR `fullname`='{$user['fullname']}' OR `email`='{$user['email']}')");
        if ($userSql->count())
            return redirect()->back()->with("notification", ["alert" => "Đã tồn tại tài khoản", "type" => "error"]);
        // check upload file
        if ($request->hasFile("thumbnail")) {
            // get thumbnail username
            $thumbnail = User::find($id)->thumbnail;
            // xóa thumbnail
            if (is_file("public/" .  $thumbnail))
                unlink("public/" . $thumbnail);
            // slug-a.png
            $filename = Str::slug($user["fullname"]) . ".png";
            $dir = "uploads/users/";
            // convert base 64
            $base64Content = convert_base64($user["thumbnailHidden"]);
            // create file 
            file_put_contents("public/" . $dir . $filename, $base64Content);
            $user["thumbnail"] = $dir . $filename;
        }

        // bỏ trường thumbnailHidden
        unset($user["thumbnailHidden"], $user["_token"]);
        // hash password
        $user["password"] = Hash::make($user["password"]);
        $role_id = $user["role_id"];
        
        // update users
        User::find($id)->update($user);
        // update user_roles
        User_role::where("user_id", $id)->update(["role_id" => $role_id]);
        return redirect()->back()->with("notification", ["alert" => "Cập Nhật Thanh Công", 'type' => "success"]);
    }


    public function delete($id)
    {

        $idLogin = Auth::user()->id;
        if ($idLogin == $id)
            return redirect()->back()->with("notification", ["alert" => "Không thể xóa chính mình ", "type" => "error"]);
        $user = User::find($id);
        if (!$user)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);
        $user->delete();
        return redirect()->back()->with("notification", ["alert" => "Đã đưa user vào thùng rác", "type" => "success"]);
    }




    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);
        $user->restore();
        return redirect()->back()->with("notification", ["alert" => "Đã phục hồi user", "type" => "success"]);
    }


    public function destroy($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!$user)
            return redirect()->back()->with("notification", ["alert" => "Không tìm thấy user", "type" => "error"]);

        // get thumbnail

        $thumbnail = "public/" . $user->thumbnail;
        if (is_file($thumbnail)) {
            // xóa file
            unlink($thumbnail);
        }

        // xóa database
        $user->forceDelete();


        // chuyển hướng
        return redirect()->back()->with("notification", ["alert" => "Đã xóa vĩnh viễn user", "type" => "success"]);
    }


    public function multitask($option, Request $request)
    {
        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $temp = 0;
        foreach ($ids as $id) {

            if ($option == "trash")
                $user = User::find($id);
            else
                $user = User::onlyTrashed()->find($id);

            //  lại bỏ user không tồn tại 
            if (!$user)
                continue;

            // loại bỏ user đang đăng nhập    
            if (Auth::user()->id == $id)
                continue;
            $temp++;

            // xóa user
            if ($option == "trash")
                $user->delete();
            else
                $user->restore();
        }
        return response()->json(["alert" => "Đã xóa $temp user"]);
    }
}
