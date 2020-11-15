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
        jQuery('#route-course').modal('show');
    @endif

    {{-- auto open model update cat --}}

    @if(isset($routeCourse))
        jQuery('#route-course').modal('show');
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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Trang chỉnh sửa lộ trình offline<small class="d-block font-size-sm"> {{$course->name}} </small></h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Trang chỉnh sửa lộ trình</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content p-0 course-offline">
        <!-- route -->
        <div id="route" class="pt-2">
            <!-- line -->
            <div class="line">
                <span class="label rounded">Lộ Trình Học</span>
            </div>
            
            <h3 class="font-size-h3 font-w300 p-3 mb-0 mb-sm-2">Danh sách lộ trình học</h3>
            <!-- chapter -->
            <form class="block block-rounded p-3 sort_table ">
                <div class="form-group d-flex justify-content-between">
                <a href="" data-toggle="modal" data-target="#route-course" class="p-2 btn-action btn-hero-info  btn-add">
                    <i class="fas fa-plus"></i>
                </a>
                <input type="text" id="seach" name="seachRoute" class="form-control w-auto form-control-sm" placeholder="Tìm kiếm chương học" value="{{ request("seachRoute") }}">
                </div>
                <table id="indexChapter" class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th class="sort sorting">
                                Tiêu đề lộ trình

                            <input type="hidden" name="title" value="{{ request("title") }}">    
                            </th>
                            <th class="sort sorting">
                                Nội dung lộ trình
                            <input type="hidden" name="content" value="{{ request("content") }}">    
                            
                            </th>
                            <th class="sort sorting">
                                Ngày tạo

                            <input type="hidden" name="created_at" value="{{ request("content") }}">    
                            </th>
                            <th>
                                Trạng thái
                            </th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $temp=0;
                        @endphp
                        @if(count($routeCourses))
                        @foreach ($routeCourses as $item)
                            <tr>
                                <td>{{ ++$temp }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->content }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $status[$item->status] }}</td>
                                <td>
                                    <a href="{{route("admin.course.offline.route",$course->id)}}?update={{$item->id}}" class="btn-update-user btn btn-sm btn-success" user="4"><i class="fas fa-pen"></i></a>
                                    <a href="{{route("admin.course.offline.route.delete",$item->id)}}" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
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
                        @for ($i = 1; $i <= ceil($routeCourses->total() / $routeCourses->perPage()); $i++)
                            <li>
                                <button name="page" value="{{ $i }}" class="@if($routeCourses->currentPage()==$i) active @endif">{{ $i }}</button>
                            </li>
                        @endfor
                    </ul>
                </div>
            </form>
        </div>
        <!-- end route -->

{{-- model route course --}}

<div class="modal fade" id="route-course" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="registermodal">
            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
            <div class="modal-body">
                <h4 class="modal-header-title">{{ isset($routeCourse) ? "Cập nhật lộ trình học":"Thêm Lộ Trình Học" }}</h4>
                <div class="block block-rounded">
                    <form action="{{ isset($routeCourse) ? route("admin.course.offline.route.update",$routeCourse->id) : route("admin.course.offline.route.add",$course->id) }}" enctype="multipart/form-data" method="POST" class="block-content row" style="overflow: auto;">
                        
                        @csrf
                        
                        <!-- btn -->
                        <div class="form-group col-12">
                            <a href="#schedule" class="btn btn-hero-sm btn-hero-light">Thêm Thời Khóa Biểu</a>
                        </div>
                        <!-- title -->
                        <div class="form-group col-md-6">
                            <label for="title" class="label-Unaffected">Tiêu đề : * </label>
                            <input type="text" name="title" id="title" class="form-control @error("title") is-invalid @enderror " value="{{old("title") ??$routeCourse->title ??''}}">
                            
                            @error('title')
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
                                        @if(isset($routeCourse) && $routeCourse->status==$k)
    
                                            selected
    
                                        @endif
    
                                >       {{$item}}
                                    </option>
                                @endforeach
                            </select>
    
                        </div>
    
                        <!-- content -->
                        <div class="form-group col-md-12">
                            <label for="content" class="label-Unaffected">Nội dung: *</label>
                            <textarea name="content" id="content" class="form-control @error("content") is-invalid @enderror " cols="30" rows="5">{{old("content") ??$routeCourse->content??''}}</textarea>
    
                            @error('content')
                                <small class="error">{{$message}}</small>
                            @enderror
    
                        </div>
                        <!-- btn -->
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
