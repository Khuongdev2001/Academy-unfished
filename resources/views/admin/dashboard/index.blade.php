@extends("layouts.admin")
{{-- require css --}}
@section('css')

    <link rel="stylesheet" href="{{ asset('plugin/datatable/css/table.css') }}">

@endsection



{{-- require js --}}
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="{{ asset('plugin/datatable/js/table.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatable();

            {{-- btn delete --}}

            $(".btn-delete").click(function(e) {
                e.preventDefault();
               let  url=$(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'tiếp tục'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=url;
                    }
                })
            })

            {{-- btn restore --}}


            $(".btn-restore").click(function(e) {
                e.preventDefault();
               let  url=$(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Bạn muốn phục hồi bài viết này ",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'tiếp tục'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=url;
                    }
                })
            })

            {{-- btn destroy --}}

            $(".btn-destroy").click(function(e) {
                e.preventDefault();
               let  url=$(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Bạn muốn xóa user nay",
                    icon: 'danger',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'tiếp tục'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=url;
                    }
                })
            })


            $("#btn-multitask").click(function(e){
                let checked=$(".multitask:checked"),
                    send="";
                if(!checked.length)
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Bạn chưa chọn ô!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                        return false;
                    }
                checked.each(function(){
                    send+= $(this).attr("post");
                    send+= ",";
                })
                send=send.substr(0, send.length - 1);
                $.get("{{route("admin.post.multitask",!empty($option) ?"restore":"trash")}}",{ids:send},function(data){
                    let timerInterval
                    Swal.fire({
                        title: 'Tự động load trang sau 1s',
                        html: data.alert,
                        timer: 1000,
                        timerProgressBar: true,
                        willOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                                const b = content.querySelector('b')
                                if (b) {
                                b.textContent = Swal.getTimerLeft()
                                }
                            }
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        // reload
                        location.reload();
                    }
                    })
                },"json")
                e.preventDefault();
            })
        })

        datatable("");
        numberDely({
            id: ["statis-student", "static-carouse", "static-success", "static-error", "static-styding", "static-post"],
            data: [{{ $static["cStudent"] }},{{ $static["cCourse"] }},{{ $static["cUserPayCourseSuccess"] }}, {{ $static["cUserPayCourseError"] }}, 334, {{ $static["cPost"] }}],
            delay: 100,
            step: 1
        });

    </script>
@endsection

{{-- status --}}
@php
    $status=["show"=>"công khai","hidden"=>"chờ duyệt"];
@endphp


@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Dashboard</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách học viên </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div id="dashboard" class="content" class="py-2">
        <div class="row row-deck">
            <div class="col-md-3">
                <div class="block block-rounded text-center d-flex flex-column">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-lg bg-body-dark mx-auto my-3">
                            <i class="fa fa-users text-muted"></i>
                        </div>
                        <div id="statis-student" class="text-black font-size-h1 font-w700">0</div>
                        <div class="text-muted mb-3">Học Viên</div>
                        <a href="{{ route("admin.user") }}" class="d-inline-block px-3 py-1 rounded-lg font-size-sm font-w600 text-info bg-info-lighter">
                            <i class="fas fa-caret-right"></i>
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block block-rounded text-center d-flex flex-column">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-lg bg-body-dark mx-auto my-3">
                            <i class="fas fa-book text-info"></i>
                        </div>
                        <div id="static-carouse" class="text-black font-size-h1 font-w700">20</div>
                        <div class="text-muted mb-3">Khóa Học</div>
                        <a href="{{ route("admin.course") }}" class="d-inline-block px-3 py-1 rounded-lg font-size-sm font-w600 text-danger bg-info-lighter">
                            <i class="fas fa-caret-right"></i>
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block block-rounded text-center d-flex flex-column">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-lg bg-body-dark mx-auto my-3">
                            <i class="far fa-check-circle text-success"></i>
                        </div>
                        <div id="static-success" class="text-black font-size-h1 font-w700">386</div>
                        <div class="text-muted mb-3">Đơn hàng Thành Công</div>
                        <a href="{{ route("admin.user.pay.course") }}" class="d-inline-block px-3 py-1 rounded-lg font-size-sm font-w600 text-success bg-success-lighter">
                            <i class="fas fa-caret-right"></i>
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block block-rounded text-center d-flex flex-column">
                    <div class="block-content block-content-full">
                        <div class="item rounded-lg bg-body-dark mx-auto my-3">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                        </div>
                        <div id="static-error" class="text-black font-size-h1 font-w700">20</div>
                        <div class="text-muted mb-3">Đơn Hàng Thất Bại</div>
                        <a href="{{ route("admin.user.pay.course") }}" class="d-inline-block px-3 py-1 rounded-lg font-size-sm font-w600 text-warning bg-warning-lighter">
                            <i class="fas fa-caret-right"></i>
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            @if(count($userPayCoursesReceived))
            <div class="col-12">
                <div class="block-content block overflow-auto rounded">
                    <h1 class="font-size-h4">Đơn hàng chờ duyệt</h1>
                    <table class="text-center table w-100 table-bordered datable nowrap">
                        <thead>
                            <tr id="header-row">
                                <th class="" style="width: 10px;">
                                    STT
                                </th>
                                <th class="">
                                    Code
                                </th>
                                <th class="">
                                    Họ và tên
                                </th>
                                <th class="">
                                    Hình thức
                                </th>
                                <th class="" style="width: 10%;">
                                    Khóa Học
                                </th>
                                <th class="">
                                    Giá
                                </th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                    $temp=0;
                                    @endphp
                                    @foreach ($userPayCoursesReceived as $userPayCourseReceived)
                                    <tr class="status {{ $userPayCourseReceived->status }}">
                                        <td> {{ ++$temp }} </td>
                                        <td> {{ $userPayCourseReceived->code }} </td>
                                        <td> {{ $userPayCourseReceived->user->fullname }} </td>
                                        <td> {{ $userPayCourseReceived->pay->name }} </td>
                                        <td> {{ $userPayCourseReceived->course->name }} </td>
                                        <td>  {{ currencyFormat($userPayCourseReceived->price) }} </td>
                                        <td> {{ $userPayCourseReceived->status }} </td>
                                    </tr>
                                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <div class="col-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="block">
                                    <div class="block-content block-content-full d-flex justify-content-between align-items-center flex-grow-1">
                                        <div class="mr-3">
                                            <p id="static-post" class="font-size-h3 font-w700 mb-0">
                                                1000
                                            </p>
                                            <p class="text-muted mb-0">
                                                Bài viết được đăng
                                            </p>
                                        </div>
                                        <div class="item rounded-lg bg-body-dark">
                                            <i class="far fa-address-card"></i>
                                        </div>
                                    </div>
                                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-center">
                                        <a href="{{ route("admin.post") }}" class="font-w500" href="javascript:void(0)">
                                            Chi tiết
                                            <i class="fa fa-arrow-right ml-1 opacity-25"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full d-flex justify-content-between align-items-center flex-grow-1">
                                        <div class="mr-3">
                                            <p id="static-styding" class="font-size-h3 font-w700 mb-0">
                                                100
                                            </p>
                                            <p class="text-muted mb-0">
                                                Đang học
                                            </p>
                                        </div>
                                        <div class="item rounded-lg bg-body-dark">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </div>
                                    </div>
                                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-center">
                                        <a class="font-w500" href="javascript:void(0)">
                                            Không chi tiết
                                            <i class="fa fa-arrow-right ml-1 opacity-25"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- chart -->
                            <div class="col-md-12">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas class="js-chartjs-lines chartjs-render-monitor" style="display: block; width: 424px; height: 212px;" width="424" height="212"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- box right  -->
                    <div id="box-note" class="col-md-4">
                        <div class="block p-4">
                            <h4 class="title">Note <span class="icon float-right"><i class="far rounded fa-clipboard bg-info-lighter"></i></span></h4>
                            <ul class="content-note">
                                <li>
                                    Họ tập laravel
                                    <div class="box-action">
                                        <button class="btn btn-info btn-sm "><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </li>
                                <li>
                                    Họ tập laravel
                                    <div class="box-action">
                                        <button class="btn btn-info btn-sm "><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </li>
                                <li>
                                    Họ tập laravel
                                    <div class="box-action">
                                        <button class="btn btn-info btn-sm "><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </li>
                                <li>
                                    Họ tập laravel
                                    <div class="box-action">
                                        <button class="btn btn-info btn-sm "><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </li>
                            </ul>
                            <div class="note-input">
                                <input type="text" name="note" id="note" class="form-control form-control-sm" placeholder="Nhập Nội Dung Cần Thêm....">
                                <button class="btn-add btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection

@section('header')
    @parent
@endsection
