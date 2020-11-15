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
                    text: "Bạn muốn phục hồi user này ",
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
                    send+=$(this).attr("user");
                    send+=",";
                })
                send=send.substr(0, send.length - 1);
                $.get("{{route("admin.user.multitask",!empty($option) ?"restore":"trash")}}",{ids:send},function(data){
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

@section('content')
    <main id="main-container">
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Danh sách học viên {{$option ? "(Thùng Rác)" :"" }} </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Firs Pi Project</li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách học viên </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div id="content" class="p-2">
            <div class="block block-rounded">
                <div class="actions user action-all px-4 pt-4">
                    <!-- các bản ghi khả dụng -->
                    <a href="{{route("admin.user")}}" type="button"
                        class="btn-action btn-hero-light btn-hero-sm btn-current">
                        <i class="fas fa-home"></i>
                        <span class="label">{{$static["index"]}}</span>
                    </a>
                    <!-- trash: thùng rác -->
                    <a href="{{route("admin.user","trash")}}" type="button"
                        class="btn-action btn-hero-warning btn-hero-sm btn-trash mx-2">
                        <i class="far fa-trash-alt"></i>
                        <span class="label">{{$static["trash"]}}</span>
                    </a>
                    <!-- btn-add:thêm phòng -->
                    <a href="{{route("admin.user.add")}}" type="button"
                        class="btn-action btn-hero-dark btn-sm btn-add">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="block-content">
                    <form id="DataTables_Table_0_wrapper" class="sort_table dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <!-- các tác vụ khác xóa nhiều -->
                                <div class="dropdown d-inline-block">
                                    <a href="" class="btn-sm btn btn-primary" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><i class="text-warning fa fa-trash-alt"></i>
                                            <a href="" id="btn-multitask" class="mx-2 text-muted">{{$option ? "Phục hồi user" :"Xóa user" }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-inline-block">
                                    <label>
                                        <select class="form-control form-control-sm" name="limit" id="limit">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="seach" id="seach" class="form-control" value=""
                                    placeholder="Tìm kiếm">
                            </div>
                            <div class="col-sm-12 overflow-auto">
                                <table
                                    class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed"
                                    id="example" role="grid">
                                    <thead>
                                        <tr id="header-row">
                                            <!-- checkall -->
                                            <td class="no-sort">
                                                <div class="custom-control-success custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkall"
                                                        name="example-cb-custom-inline1">
                                                    <label class="custom-control-label" for="checkall"></label>
                                                </div>
                                            </td>
                                            <th class="" style="width: 10px;">
                                                STT
                                            </th>
                                            <th class="no-sort" style="width: 30px;">
                                                Ảnh
                                            </th>
                                            <th class="sorting sort">
                                                <input type="hidden" name="fullname"
                                                    value="{{ request('fullname') ?? 'desc' }}">
                                                Họ và tên
                                            </th>
                                            <th class="sorting sort">
                                                <input type="hidden" name="email" value="{{ request('email') ?? 'desc' }}">
                                                Email
                                            </th>
                                            <th class="sorting sort" style="width: 10%;">
                                                <input type="hidden" name="phone" value="{{ request('phone') ?? 'desc' }}">
                                                Số điện thoại
                                            </th>
                                            <th>
                                                Quyền
                                            </th>
                                            <th class="sorting sort">
                                                <input type="hidden" name="created_at"
                                                    value="{{ request('created_at') ?? 'desc' }}">
                                                Ngày tạo
                                            </th>
                                            <th class="no-sort">Tác vụ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $temp=0;
                                        @endphp
                                        @if(count($users))
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="custom-control-success">
                                                        <div class="custom-control custom-checkbox"><input type="checkbox"
                                                        class="custom-control-input multitask" user="{{$user->id}}" id="user-{{$user->id}}"><label
                                                                class="custom-control-label" for="user-{{$user->id}}"></label></div>
                                                    </div>
                                                </td>
                                                <td class="" id="">{{ ++$temp }}</td>
                                                <td class="p-1"><a href="">
                                                    <img src="{{ asset($user->thumbnail) }}"></a>
                                                </td>
                                                <td class="" id="">{{ $user->fullname }}</td>
                                                <td class="" id="">{{ $user->email }}</td>
                                                <td class="" id="">{{ $user->phone }}</td>
                                                <td class="" id="">{{ $user->role[0]->name }}</td>
                                                <td class="" id="">{{ $user->created_at }}</td>
                                                @if(!$option)
                                                <td>
                                                    <a href="{{ route('admin.user.update', $user->id) }}" class="btn-update btn btn-sm btn-success" user="4"><i class="fas fa-pen"></i></a>
                                                    <a href="{{ route('admin.user.delete', $user->id) }}" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                                @else
                                                <td>
                                                    <a href="{{ route('admin.user.restore', $user->id) }}" class="btn-restore btn btn-sm btn-success" user="4"><i class="fas fa-trash-restore"></i></a>
                                                    <a href="{{ route('admin.user.destroy', $user->id) }}" class="btn-destroy btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        @else

                                        <tr>
                                            <td colspan="9" class="text-warning-light" >Hiện chưa có user nào trong bảng nay</td>
                                        </tr>
                                            
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-paginate col-12">
                                <ul class="paginate list-unstyled">
                                    @for ($i = 1; $i <= ceil($users->total() / $users->perPage()); $i++)
                                        <li>
                                            <button name="page" value="{{ $i }}" class="@if($users->currentPage()==$i) active @endif"  >{{ $i }}</button>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
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
