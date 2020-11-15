{{--


    COMMENT COURSE 14-11-2020

    BY NGUYỄN HỮU KHƯƠNG




    --}}

@extends("layouts.admin")
{{-- require css --}}
@section('css')

    <link rel="stylesheet" href="{{ asset('plugin/datatable/css/table.css') }}">

    {{-- css rate --}}
    <style>
        .js-rating i{

            color:#6c757d!important;


        }

        .js-rating i.active{

            color:#ffb119!important;

        }



    </style>
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

            $(".btn-multi").click(function(e) {
                e.preventDefault();
               let  url=$(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Bạn muốn xóa comment được chọn ",
                    icon: 'danger',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'tiếp tục'
                }).then((result) => {
                    if (result.isConfirmed) {
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
                        send+= $(this).attr("comment");
                        send+= ",";
                     })
                     send=send.substr(0, send.length - 1);
                    
                    @if($option["module"]=="course")

                        $.get("{{route("admin.comment.course.multitask")}}",{ids:send},function(data){
                    
                    @else

                        $.get("{{route("admin.comment.post.multitask")}}",{ids:send},function(data){

                    @endif

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
                 }
                })
            })


            
        })


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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Danh Sách Bình Luận {{ $option["title"] }}  <small class="d-block font-size-sm"> {{$cat->name ??"" }}</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh Sách Bình Luận</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div id="content" class="p-2">
        <div class="block block-rounded">
            <div class="actions user action-all px-4 pt-4">
                <!-- các bản ghi khả dụng -->
                <a href="https://khuong.unitopcv.com/bambooHouse/admin/room" type="button" class="btn-action btn-dual btn-current">
                    <i class="fas fa-home"></i>
                    <span class="label">
                        {{ $static["index"] }}
                    </span>
                </a>
            </div>
            <div class="block-content">
                <form id="DataTables_Table_0_wrapper" class="sort_table dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <!-- các tác vụ khác xóa nhiều -->
                            <div class="dropdown d-inline-block">
                                <a href="" class="btn-sm btn btn-primary" id="dropdown-dropright-hero-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><i class="text-warning fa fa-trash-alt"></i>
                                        <a href="" class="btn-multi mx-2 text-muted">Đưa vào thùng rác</a>
                                        </a>
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
                        <div id="example_filter" class="dataTables_filter"><label>Tìm kiếm <input type="search" name="seach" id="seach" class="form-control form-control-sm"  value="{{ request("seach") }}"></label></div>
                        </div>
                        <div class="col-sm-12 overflow-auto">
                            <table class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed" id="example" role="grid">
                                <thead>
                                    <tr id="header-row">
                                        <!-- checkall -->
                                        <td class="no-sort" style="width: 5%;">
                                            <div class="custom-control-success custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkall" name="example-cb-custom-inline1">
                                                <label class="custom-control-label" for="checkall"></label>
                                            </div>
                                        </td>
                                        <th style="width: 1%;">
                                            STT
                                        </th>
                                        <th class="sorting sort" style="width: 10%;">
                                            <input type="hidden" name="content" value="{{ request("content") }}">
                                            Nội dung
                                        </th>
                                        <th style="width: 10%;">
                                            Khách Bình Luận
                                        </th>
                                        <th style="width: 10%;">
                                            Tên khóa học
                                        </th>
                                        <th class="sorting sort" style="width: 10%;">
                                            <input type="hidden" name="star" value="{{ request("star") }}">
                                            Sao
                                        </th>
                                        <th>
                                            Trạng thái
                                        </th>
                                        <th class="sorting sort" style="width: 10%;">
                                            <input type="hidden" name="created_at" value="{{ request("created_at") }}">
                                            Ngày tạo
                                        </th>
                                        <th class="no-sort sort" style="width: 10%;">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
 
                                    @php

                                        $temp=0;

                                    @endphp

                                   @if(count($comments))

                                   @foreach($comments as $comment)
                                    <tr>
                                        <td>
                                            <div class="custom-control-success">
                                            <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input multitask" comment="{{ $comment->id }}" id="user-4"><label class="custom-control-label" for="user-4"></label></div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ ++$temp }}
                                        </td>
                                        <td>
                                            {{ $comment->content }}
                                        </td>
                                        <td>
                                            {{ $comment->user->fullname }}
                                        </td>
                                        <td>
                                            {{ $comment->cat->name }}
                                        </td>
                                        <td>
                                            {{-- stars --}}
                                            <div class="js-rating" style="cursor: pointer;">

                                                @for($i=0; $i<5; $i++)

                                                    @php

                                                        $class="active";
                                                        if($i>=$comment->star)
                                                            $class="";

                                                    @endphp


                                                    <i data-alt="1" class="fa fa-fw fa-star {{ $class }}" title="Just Bad!"></i>&nbsp;

                                                @endfor
                                                <input name="score" type="hidden" value="4">
                                            </div>
                                        </td>
                                        <th>
                                            {{ $status[$comment->status] }}
                                        </th>
                                        <td>

                                            {{ $comment->created_at }}

                                        </td>
                                        <td>
                                            @if( $option["module"]=="course" )

                                                <a href="{{ route("admin.comment.course.response",[ "cat"=>$cat->id , "id"=>$comment->id ]) }}" id="" class="btn-update-user btn btn-sm btn-success" user="4">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="{{ route("admin.comment.course.delete",[ "cat"=>$cat->id , "id"=>$comment->id ]) }}" id="" class="btn-delete btn btn-sm btn-danger ml-1" user="4">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @else

                                                <a href="{{ route("admin.comment.post.response",[ "cat"=>$cat->id , "id"=>$comment->id ]) }}" id="" class="btn-update-user btn btn-sm btn-success" user="4">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="{{ route("admin.comment.post.delete",[ "cat"=>$cat->id , "id"=>$comment->id ]) }}" id="" class="btn-delete btn btn-sm btn-danger ml-1" user="4">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @else

                                    <tr>
                                        <td colspan="9" class="text-warning-light" >Hiện chưa có bài viết nào trong bảng nay</td>
                                    </tr>
                                        
                                    @endif 
                                </tbody>

                            </table>
                        </div>
                        <!-- paginate -->
                    <div class="box-paginate col-12">
                        <ul class="paginate list-unstyled">
                            @for ($i = 1; $i <= ceil($comments->total() / $comments->perPage()); $i++)
                                <li>
                                    <button name="page" value="{{ $i }}" class="@if($comments->currentPage()==$i) active @endif" >{{ $i }}</button>
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
