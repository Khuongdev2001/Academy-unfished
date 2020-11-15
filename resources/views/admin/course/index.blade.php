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


            $(".course-video").click(function()
            {
                let video=$(this).attr("video");
                if(video.length>0)
                {

                    jQuery('#modal-video-course').modal('show');

                    $('#modal-video-course video').attr('src',video);

                }
                
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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Danh Sách {{$catCourse->name}} {{$option ? "(Thùng Rác)" :"" }} </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh Sách {{$catCourse->name}} </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <form id="content" class="sort_table p-2">
        <div class="block block-rounded p-2">
            <div class="actions user action-all py-3">

                {{-- index --}}

                <a href="{{route("admin.course", ["cat" => $cat])}}" class="btn-action btn-hero-success btn-trash btn-sm">
                    <i class="far fa-file"></i>
                    <span class="label">
                        {{$static["index"]}}
                    </span>
                </a>

                {{-- trash --}}

                <a href="{{route("admin.course",["cat" => $cat,"option" => "trash"])}}" class="btn-action btn-hero-warning mx-2 btn-sm">
                    <i class="far fa-trash-alt"></i>
                    <span class="label">
                        {{$static["trash"]}}
                    </span>
                </a>

                {{-- multitask --}}


                <a href="" id="btn-multitask" class="btn-action btn-hero-danger mr-2 btn-sm">
                    {{$option ? "Phục hồi nhiều" :"Xóa nhiều" }}
                </a>


                <!-- btn-add:thêm phòng -->

                <a href="{{ route("admin.course.add") }}" class="btn-action btn-hero-light btn-add btn-sm">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <!-- start filter -->
            <div class="d-flex justify-content-between">
                <!-- limit -->
                <div class="d-inline-block">
                    <label>
                        <select name="limit" class="form-control">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </label>
                </div>
                <!-- seach -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="seach" placeholder="Tìm kiếm" value="{{request("seach")}}" >
                </div>
            </div>
            <!-- end filter -->
            <div class="overflow-auto">
                <table class="text-center table w-100 table-bordered table-vcenter datable no-footer display nowrap dataTable">
                    <thead>
                        <tr id="header-row">
                            <!-- checkall -->
                            <td class="no-sort">
                                <div class="custom-control-success custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkall" name="example-cb-custom-inline1">
                                    <label class="custom-control-label" for="checkall"></label>
                                </div>
                            </td>
                            <th class="no-sort" style="width: 10px;">
                                STT
                            </th>
                            <th class="no-sort" style="width: 10px;">
                                Ảnh
                            </th>
                            <th>
                                Video
                            </th>
                            <th class="sorting sort">
                                <input type="hidden" name="name" value="{{ request("name") }}">
                                Tên Danh Mục
                            </th>
                            <th class="sorting sort" style="width: 10%;">
                                <input type="hidden" name="price" value="{{ request("price") }}">
                                Giá
                            </th>
                            <th>
                               Trạng thái
                            </th>
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
                        @if(count($courses))
                        @foreach ($courses as $course)
                        <tr>
                            <td>
                                <div class="custom-control-success"><div class="custom-control custom-checkbox">
                                    <input type="checkbox"class="custom-control-input multitask" course="{{$course->id}}" id="course-{{$course->id}}">
                                    <label class="custom-control-label" for="course-{{$course->id}}"></label></div>
                                </div>
                            </td>
                            <td class="" id="">{{ ++$temp }}</td>
                            <td class="p-1"><a href="" class="text-dark font-weight-bold">@if(!empty($course->thumbnail))<img src="{{ asset($course->thumbnail) }}"> @else không có ảnh  @endif</a></td>
                            <td class="course-video" @if(!empty($course->video)) video="{{ asset($course->video) }}"  @endif>
                               
    
                                @if(!empty($course->video)) Xem video @else Chưa upload  @endif
    
                                
                            </td>
                            <td class="">{{ $course->name }}</td>
                            <td class="">{{ currencyFormat($course->price) }}</td>
                            <td class="">{{ $status[$course->status] }}</td>
                            <td class="" id="">{{ $course->created_at }}</td>
                            @if(!$option)
                            <td>

                                <div>
                                    <button type="button" class="btn btn-hero-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                     
                                        <a href="{{route("admin.course.update",$course->id)}}" class="btn-update btn btn-sm btn-success"><i class="fas fa-pen"></i></a>
                                        <a href="{{route("admin.course.delete",$course->id)}}" class="btn-delete btn btn-sm btn-danger ml-1"><i class="fas fa-trash-alt"></i></a>
                                    
                                    {{-- chỉ áp dụng cho khóa học offline  --}}
    
                                    @if($cat==2)
    
                                        <a href="{{route("admin.course.offline.route",$course->id)}}" class="btn btn-sm btn-info ml-1">
                                            Lộ trình
                                        </a>

                                        <a href="{{route("admin.course.offline.schedule",$course->id)}}" class="btn btn-sm btn-warning ml-1">
                                            lịch học
                                        </a>
                                     
                                    {{-- chỉ áp dụng khóa học online  --}}
                                    @else    
                                    
                                        <a href="{{route("admin.course.online.chapter",$course->id)}}" class="btn btn-sm btn-info ml-1">
                                           Chương học
                                        </a>
                                        <a href="{{route("admin.course.online",$course->id)}}" class="btn btn-sm btn-warning ml-1">
                                           Bài giảng
                                        </a>

                                    @endif
                                        
                                    <a href="{{route("admin.comment.course",$course->id)}}" class="btn btn-sm btn-dark ml-1">
                                       Xem comment
                                     </a>

                                    </div>
                                </div>
   
                            </td>
                            @else
                            <td>
                                <a href="{{route("admin.course.restore",$course->id)}}" class="btn-restore btn btn-sm btn-success" ><i class="fas fa-trash-restore"></i></a>
                                <a href="{{route("admin.course.destroy",$course->id)}}" class="btn-destroy btn btn-sm btn-danger ml-1"><i class="fas fa-trash-alt"></i></a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @else
    
                        <tr>
                            <td colspan="9" class="text-warning-light" >Hiện chưa có khóa học nào trong bảng nay</td>
                        </tr>
                            
                        @endif   
                    </tbody>
                </table>
            </div>
            <!-- paginate -->
            <div class="box-paginate col-12">
                <ul class="paginate list-unstyled">
                    @for ($i = 1; $i <= ceil($courses->total() / $courses->perPage()); $i++)
                        <li>
                            <button name="page" value="{{ $i }}" class="@if($courses->currentPage()==$i) active @endif" >{{ $i }}</button>
                        </li>
                    @endfor
                </ul>
            </div>
            <!-- end paginate -->
        </div>
    </form>



    {{-- modal video course --}}

    <div id="modal-video-course" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <video src="" controls ></video>
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
