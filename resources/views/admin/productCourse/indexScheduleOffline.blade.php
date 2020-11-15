@extends("layouts.admin")

{{-- require title --}}

@section("title","Danh sách thanh toán")

{{-- require css --}}
@section('css')

    <link rel="stylesheet" href="{{ asset('plugin/datatable/css/table.css') }}">

@endsection

{{-- require js --}}
@section('js')

    {{-- sweetalert  --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    {{-- datatable --}}
    <script src="{{ asset('plugin/datatable/js/table.js') }}"></script>

    {{-- only number --}}
    <script src="{{ asset('js/onlynumber.js') }}"></script>

<script>

    {{-- auto open modal add cat  --}}

    @if ($errors->any())
        jQuery('#schedule-course').modal('show');
    @endif

    {{-- auto open model update cat --}}

    @if(isset($scheduleCourse))
        jQuery('#schedule-course').modal('show');
    @endif


    $(document).ready(function() {
            datatable();
            focusActive(["name","discount"]);
            {{-- btn crop thumbnail --}}

            let $modal = $('#modal-crop-img'),
                image = document.getElementById('sample_image'),
                cropper;

            $("#btn-upload").click(() => {
                $("#thumbnail").trigger("click");
                return false;
            })
            $('#thumbnail').change(function(event) {
                var files = event.target.files;
                var done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };

                if (files && files.length > 0) {
                    reader = new FileReader();
                    reader.onload = function(event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 1000,
                    height: 5000
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        $('#img-uploaded').attr("src", base64data);
                        $("#hidden-thumbnail").val(base64data);
                        $modal.modal('hide');
                        $("#slider").modal('hide');
                        // delay open modal
                        setTimeout(function(){

                            jQuery('#slider').modal('show');

                        },500)
                    };
                });
            });

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
                    text: "Bạn muốn phục hồi thanh toán này ",
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
                    text: "Bạn muốn xóa thanh toán này",
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
                    send+= $(this).attr("pay");
                    send+= ",";
                })
                send=send.substr(0, send.length - 1);
                $.get("{{route("admin.pay.multitask",!empty($option) ?"restore":"trash")}}",{ids:send},function(data){
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

            {{-- only number --}}
            onlyNumber(["discount"]);
            


        })
</script>

@endsection


{{-- status --}}
@php
    $status=["show"=>"công khai","hidden"=>"chờ duyệt"];
@endphp

{{-- require content --}}
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Thiết Lập Lịch Học Offline <small class="d-block font-size-sm"> {{$course->name}} </small></h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Thiết Lập Lịch Học Offline </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content p-0 course-offline">
        <!-- schedule -->
        <div id="schedule" class="pt-1">
            <!-- line -->
            <div class="line">
                <span class="label rounded">Thời Khóa Biểu</span>
            </div>
            
            <h3 class="font-size-h3 font-w300 p-3 mb-0 mb-sm-2">Danh Sách Lịch Học </h3>
            
            <form class="block block-rounded p-3 sort_table table-responsive ">
                <div class="d-flex justify-content-between align-items-center ">
                    <a href="" data-toggle="modal" data-target="#schedule-course" class="p-2 btn-action btn-hero-info  btn-add">
                        <i class="fas fa-plus"></i>
                    </a>
                    <div class="form-group d-inline-block">
                        <input type="text" id="seach" name="seach" class="form-control w-auto form-control-sm" placeholder="Tìm kiếm chương học" value="{{request("seach")}}">
                    </div>
                </div>

                <table id="indexChapter" class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th style="width: 10%;" >STT</th>

                            <th class="sort sorting" style="width: 10%;" >
                                Tiêu đề
                                <input type="hidden" name="title" value="{{ request("title") }}">    
                            </th>

                            <th class="sort sorting" style="width: 10%;" >
                                Ngày khai giảng
                                <input type="hidden" name="date_start" value="{{ request("date_start") }}">    
                            </th>

                            <th class="sort sorting" style="width: 10%;" >
                                Thời gian học 
                                <input type="hidden" name="text_time_learn" value="{{ request("text_time_learn") }}">    
                            </th>

                            <th>
                                Trạng thái
                            </th>

                            <th class="sort sorting" style="width: 10%;" >
                                Học viên tối đa
                                <input type="hidden" name="title" value="{{ request("title") }}">    
                            </th>
                            <th style="width: 10%;" >
                                Học viên hiện có
                            </th>
                            <th class="sort sorting" style="width: 10%;" >
                                Ngày tạo
                                <input type="hidden" name="title" value="{{ request("title") }}">    
                            </th>
                            <th style="width: 10%;" >Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $temp=0;
                        @endphp
                        @if(count($scheduleCourses))
                        @foreach ($scheduleCourses as $item)
                            <tr>
                                <td>{{ ++$temp }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->date_start }}</td>
                                <td>{{ $item->text_time_learn }}</td>
                                <td>{{ $status[$item->status] }}</td>
                                <td>{{ $item->max_student }}</td>
                                <td>{{ $item->now_student }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{route("admin.course.offline.schedule",$course->id)}}?update={{$item->id}}" class="btn-update-user btn btn-sm btn-success" user="4"><i class="fas fa-pen"></i></a>
                                    <a href="{{route("admin.course.offline.schedule.delete",$item->id)}}" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
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
                <div class="box-paginate clearfix">
                    <ul class="paginate list-unstyled">
                        @for ($i = 1; $i <= ceil($scheduleCourses->total() / $scheduleCourses->perPage()); $i++)
                            <li>
                                <button name="page" value="{{ $i }}" class="@if($scheduleCourses->currentPage()==$i) active @endif">{{ $i }}</button>
                            </li>
                        @endfor
                    </ul>
                </div>
            </form>
        </div>
        <!-- end route -->
    </div>



{{-- model schedule --}}

<div class="modal fade" id="schedule-course" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="registermodal">
            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
            <div class="modal-body">
                <h4 class="modal-header-title">{{ isset($scheduleCourse) ? "Cập nhật Thời khóa biểu":"Thêm Thời Khóa Biểu" }}</h4>
                
                <div class="block block-rounded">
                    <form action="{{ isset($scheduleCourse) ?route("admin.course.offline.schedule.update",$scheduleCourse->id) : route("admin.course.offline.schedule.add",$course->id) }}" enctype="multipart/form-data" method="POST" class="block-content row" style="overflow: auto;">
                        
                        {{-- btn --}}
    
                        <div class="form-group col-12">
                            <a href="#route" class="btn btn-hero-sm btn-hero-light">Thêm Lộ Trình</a>
                        </div>

                        @csrf
    
                        {{-- title --}}
    
                        <div class="form-group col-md-12">
                            <label for="title" class="label-Unaffected">Tên thời khóa biểu: * </label>
                            <input type="text" name="title" id="title" class="form-control @error("title") is-invalid @enderror " value="{{old("title") ??$scheduleCourse->title??''}}">
                            @error('title')
                                <small class="error">{{$message}}</small>
                            @enderror
                        </div>
                        
                        {{-- text-date --}}

                        <div class="form-group col-md-6">
                            <label for="text_time_learn" class="label-Unaffected">Thời gian học hàng tuần: * </label>
                            <input type="text" name="text_time_learn" id="text_time_learn" class="form-control @error("text_time_learn") is-invalid @enderror " value="{{old("text_time_learn") ??$scheduleCourse->text_time_learn??''}}" placeholder="Thời gian thuộc dạng ký tự">
                            @error('text_time_learn')
                                <small class="error">{{$message}}</small>
                            @enderror
                        </div>


                        {{-- status --}}
    
                        <div class="form-group col-md-6">
                            <label for="status" class="label-Unaffected" >Công khai: *</label>
                            <select name="status" id="status" class="form-control">
                                @foreach($status as $k=> $item)
                                    <option value="{{$k}}"
                                        {{-- seclected  status --}}
                                        @if(isset($scheduleCourse) && $scheduleCourse->status==$k)
    
                                            selected
    
                                        @endif
    
                                >       {{$item}}
                                    </option>
                                @endforeach
                            </select>
    
                        </div>

                        {{-- date_start --}}
    
                        <div class="form-group col-md-4">
                            <label for="date_start" class="label-Unaffected">Thời gian bắt đầu: * </label>
                            <input type="date" name="date_start" id="date_start" class="form-control @error('date_start') is-invalid @enderror" value="{{old("date_start") ??$scheduleCourse->date_start ??''}}">
                        
                            @error('date_start')
                                <small class="error">{{$message}}</small>
                            @enderror
                            
                        </div>
    
                        {{--  max-student --}}
    
                        <div class="form-group col-md-4">
                            <label for="max_student" class="label-Unaffected">Số lượng HV tối đa: *</label>
                            <input type="text" name="max_student" id="max_student" class="form-control @error('max_student') is-invalid @enderror" value="{{old("max_student") ??$scheduleCourse->max_student ??''}}">

                            @error('max_student')
                                <small class="error">{{$message}}</small>
                            @enderror
                        </div>
                        
                        {{-- now_student --}}
    
                        <div class="form-group col-md-4">
                            <label for="now_student" class="label-Unaffected">Số lượng HV hiện học: *</label>
                            <input type="text" name="now_student" id="now_student" class="form-control @error('now_student') is-invalid @enderror" readonly value="{{old("now_student") ??$scheduleCourse->now_student ??''}}">
                        </div>
                        
                        {{-- note --}}
    
                        <div class="form-group col-md-12">
                            <label for="note" class="label-Unaffected">Ghi Chú: </label>
                            <textarea name="note" id="note" class="form-control" cols="30" rows="5">{{old("note") ??$scheduleCourse->note ??''}}</textarea>
                        </div>
                        
                        {{-- btn --}}
    
                        <div class="col-12">
                            <button name="" class="btn btn-hero-info float-right">Lưu</button>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="annotate text-danger font-weight-bold text-shadow">
                                <small class="d-block">Các dấu * là trường bắt buộc</small>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}




</main>


@endsection
