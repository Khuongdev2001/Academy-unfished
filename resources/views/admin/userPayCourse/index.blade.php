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
                    text: "Bạn muốn đưa thanh toán của thành viên nay vào thùng rác",
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
                    text: "Bạn muốn phục thanh toán thành viên này ",
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
                    text: "Bạn muốn xóa thanh toán thành viên  này",
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
                    send+= $(this).attr("course");
                    send+= ",";
                })
                send=send.substr(0, send.length - 1);
                $.get("{{route("admin.course.multitask",!empty($option) ?"restore":"trash")}}",{ids:send},function(data){
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


    </script>
@endsection

{{-- status --}}
@php
    $status=["received"=>"đã tiếp nhận","pending"=>"chờ xử lý","success"=>"thành công","error"=>"thất bại"];
@endphp


@section('content')

<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Danh Sách Học Viên Đăng Ký {{ !empty($option)?"(Thùng rác)":""  }}  </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh Sách Học Viên Đăng Ký </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div id="content" class="p-2">
        <div class="block block-rounded">
            <div class="actions user action-all px-4 pt-4">
                <!-- các bản ghi khả dụng -->
                <a href="{{ route("admin.user.pay.course") }}" type="button" class="btn-action btn-dual btn-current">
                    <i class="fas fa-home"></i>
                    <span class="label">

                        {{ $static["index"] }}

                    </span>
                </a>
                <!-- trash: thùng rác -->
                <a href="{{ route("admin.user.pay.course","trash") }}" type="button" class="btn-action btn-warning btn-trash mx-2">
                    <i class="far fa-trash-alt"></i>
                    <span class="label">

                        {{ $static["trash"] }}


                    </span>
                </a>
           </div>
            <div class="block-content">
                <form id="DataTables_Table_0_wrapper" class="dataTables_wrapper sort_table dt-bootstrap4 no-footer">
                    <input type="hidden" name="mod" value="user_pay_course">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <!-- các tác vụ khác xóa nhiều -->
                            <div class="dropdown d-inline-block">
                                <a href="" class="btn-sm btn btn-primary" id="dropdown-dropright-hero-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><i class="text-warning fa fa-trash-alt"></i>
                                        <a href="" id="btn-multitask" class="mx-2 text-muted">Đưa vào thùng rác</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="d-inline-block">
                                <label>
                                    <select name="example_length" class="form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input type="text" name="seach" id="seach" class="form-control" value="{{ request("seach") }}" placeholder="Tìm kiếm...">
                        </div>
                        <div class="col-sm-12 overflow-auto">
                            <table class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed" id="example" role="grid">
                                <thead>
                                    <tr id="header-row">
                                        <!-- checkall -->
                                        <td class="no-sort">
                                            <div class="custom-control-success custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkall" name="example-cb-custom-inline1">
                                                <label class="custom-control-label" for="checkall"></label>
                                            </div>
                                        </td>
                                        <th>
                                            STT
                                        </th>
                                        <th class="sorting sort">
                                            <input type="hidden" name="code" value="{{ request("code") }}">
                                            Code
                                        </th>
                                        <th>
                                            Họ và tên
                                        </th>
                                        <th>
                                            Hình thức
                                        </th>
                                        <th style="width: 10%;">
                                            Khóa Học
                                        </th>
                                        <th >
                                            Giá
                                        </th>
                                        <th>Trạng Thái</th>
                                        <th class="sorting sort">
                                            <input type="hidden" name="created_at" value="{{ request("created_at") }}">
                                            Ngày tạo
                                        </th>
                                        <th class="no-sort">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @php
                                    $temp=0;
                                    @endphp
                                    @if(count($userPayCourses))
                                    @foreach ($userPayCourses as $userPayCourse)

                                    <tr class="status {{ $userPayCourse->status }}" >
                                        <td>
                                            <div class="custom-control-success">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input multitask" user_pay_course="{{ $userPayCourse->id }}" id="user-4"><label class="custom-control-label" for="user-4"></label></div>
                                            </div>
                                        </td>
                                        <td>{{ ++$temp }}</td>
                                        <td>

                                            {{ $userPayCourse->code }}

                                        </td>
                                        <td>

                                            {{ $userPayCourse->user->fullname }}
                                            
                                        </td>
                                        <td>

                                            {{ $userPayCourse->pay->name }}

                                        </td>
                                        <td>

                                            {{ $userPayCourse->course->name }}

                                        </td>
                                        <td>

                                            {{ currencyFormat($userPayCourse->course->price) }}

                                        </td>

                                        <td>

                                            {{ $status[$userPayCourse->status] }}

                                        </td>

                                        <td>

                                            {{ $userPayCourse->created_at }}

                                        </td>
                                        
                                        <td>
                                            @if(empty($option)) 
                                                <a href="{{ route("admin.user.pay.course.update", $userPayCourse->id) }}" class="btn-update btn btn-sm btn-success" user="4"><i class="fas fa-pen"></i></a>
                                                <a href=" {{ route("admin.user.pay.course.delete", $userPayCourse->id) }} " id="" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                            @else
                                                <a href="{{ route('admin.user.pay.course.restore', $userPayCourse->id) }}" class="btn-restore btn btn-sm btn-success" user="4"><i class="fas fa-trash-restore"></i></a>
                                                <a href="{{ route('admin.user.pay.course.destroy', $userPayCourse->id) }}" class="btn-destroy btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                            @endif
                                        </td>
                                    </tr>

                                    @endforeach
                                    @else

                                    <tr>
                                        <td colspan="9" class="text-warning-light" >Hiện chưa có thanh toán nào</td>
                                    </tr>
                                        
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <!-- paginate -->
                        <div class="box-paginate col-12">
                            <ul class="paginate list-unstyled">
                                @for ($i = 1; $i <= ceil($userPayCourses->total() / $userPayCourses->perPage()); $i++)
                                    <li>
                                        
                                        <button name="page" value="{{ $i }}" class="@if($userPayCourses->currentPage()==$i) active @endif">{{ $i }}</button>

                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <!-- end paginate -->
                    </div>
                </form>
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
