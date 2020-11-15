<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\User_pay_course;

class AdminUserPayCourseController extends Controller
{
    public function index($option = "", Request $request)
    {

        // get static

        $static = [

            "index" => User_pay_course::count(),

            'trash' => User_pay_course::onlyTrashed()->count()
        ];

        $fields = $request->input();

        $seach = $fields["seach"] ?? "";
        $limit = $fields["limit"] ?? 4;
        $orderBy = sort_table($fields, ["code"]);
        // set default no sort
        if (!$orderBy)
            $orderBy = "id ASC";

        $userPayCourses = User_pay_course::select('id', 'code', 'course_id', 'user_id', 'pay_id', 'discount', 'status', 'created_at');

        // option trash
        if ($option)
            $userPayCourses = User_pay_course::onlyTrashed()->select('id', 'code', 'course_id', 'user_id', 'pay_id', 'discount', 'status', 'created_at');

        $userPayCourses = $userPayCourses->where('code', 'LIKE', "%{$seach}%")->orderByRaw($orderBy)->paginate($limit);


        return view("admin.userPayCourse.index", compact("userPayCourses", "option", "static"));
    }




    public function update($id)
    {
        $userPayCourse = User_pay_course::find($id);

        return view("admin.userPayCourse.update", compact("userPayCourse"));
    }




    public function doUpdate($id, Request $request)
    {

        $request->validate(
            [
                "status" => "in:received,pending,success,error"
            ]
        );

        $userPayCourse = ["status" => $request->input("status")];

        User_pay_course::find($id)->update($userPayCourse);
        return redirect()->back()->with("notification", ["alert" => "cập nhật thành công thanh toán khóa học user", "type" => "success"]);
    }


    public function delete($id)
    {


        User_pay_course::find($id)->delete();
        return redirect()->back()->with("notification", ["alert" => "đã đưa thanh toán vào thùng rác của thành viên này", "type" => "success"]);
    }

    public function restore($id)
    {

        User_pay_course::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with("notification", ["alert" => "đã phục hồi thanh toán của thành viên này", "type" => "success"]);
    }

    public function destroy($id)
    {


        User_pay_course::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with("notification", ["alert" => "đã xóa thanh toán của thành viên này", "type" => "success"]);
    }
}
