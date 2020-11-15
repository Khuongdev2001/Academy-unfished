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

    @error('nameChapter')
    
        jQuery('#modal-chapter').modal('show');
    
    @enderror

    {{-- auto open model update cat --}}

    @if(isset($chapter))
        jQuery('#modal-chapter').modal('show');
    @endif


    $(document).ready(function() {
            datatable();
            focusActive(["name","desc"]);
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

            {{-- datatablse --}}
            datatable();
            
            dropUploadFiles([1], ["video"]);

            $("#btn-save").click(function(){
                
            })


            // btn preview

            $("#btn-preview-player").click(function(){

            let iframe=$(this).attr("data-src");
            // open model
            jQuery('#preview_player').modal('show');

            jQuery('#preview_player iframe').attr("src",iframe);            

            return false;

            })
        })
</script>

@endsection


{{-- status --}}
@php
    $status=["show"=>"công khai","hidden"=>"chờ duyệt"];

    $views=["free"=>"miễn phí","pay"=>"tính phí"];
@endphp

{{-- require content --}}
@section('content')

<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ isset($productCourse) ? "Cập Nhật Bài Giảng Online ":"Thêm Bài Giảng Online"  }}<small class="d-block font-size-sm"> {{$course->name ?? $productCourse->course->name ??""  }} </small> </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($productCourse) ? "Cập Nhật Bài Giảng Online ":"Thêm Bài Giảng Online"  }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <form action="{{ isset($productCourse) ?route("admin.course.online.update",$productCourse->id):route("admin.course.online.add",$course->id) }}" enctype="multipart/form-data" method="POST" class="block-content row" style="overflow: auto;">
                

                @csrf



                <div class="form-group col-md-12">
                    <label for="name">Tên Bài Giảng : * </label>
                    <input type="text" name="name" id="name" class="form-control @error("name") is-invalid @enderror " value="{{old("name") ??$productCourse->name ??''}}">
                    
                    @error('title')
                        <small class="error">{{ $message }}</small>
                    @enderror

                </div>
                <!-- desc -->
                <div class="form-group col-md-12">
                    <label for="desc">Mô tả:</label>
                    <textarea name="desc" class="form-control @error("desc") is-invalid @enderror " id="desc" cols="30" rows="6">{{old("desc") ??$productCourse->desc ??''}}</textarea>
                
                    @error('desc')
                        <small class="error">{{ $message }}</small>
                    @enderror
                
                </div>

                {{-- status --}}
    
                <div class="form-group col-md-4">

                    <div class="row">

                        {{-- col status --}}

                        <div class="col-12">
                            <label for="status" class="label-Unaffected" >Công khai: *</label>
                            <select name="status" id="status" class="form-control">
                            @foreach($status as $k=> $item)
                                <option value="{{$k}}"
                                    {{-- seclected  status --}}
                                    @if(isset($productCourse) && $productCourse->status==$k)

                                        selected

                                    @endif

                                >       {{$item}}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        {{-- col chapter --}}

                        <div class="col-12 my-3">
                            <label for="parent_id" class="label-Unaffected" >Chương học: *</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                            @foreach($chapters as $chapter)
                                <option value="{{ $chapter->id }}"
                                    {{-- seclected  status --}}
                                    @if(isset($chapter) && $chapter->status==$k)

                                        selected

                                    @endif

                                >       {{ $chapter->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        
                        {{-- view --}}


                        <div class="col-12 my-3">
                            <label for="view  " class="label-Unaffected" >Chương học: *</label>
                            <select name="view" id="view" class="form-control ">
                                @foreach( $views as $key => $view )

                                    <option value="{{ $key }}"> {{ $view }} </option>

                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    

                </div>

                <!-- drop file content -->
                <div class="form-group col-md-8 ">
                    <label for="file" class="label-Unaffected">Upload Video/pdf: *</label>
                    <div class="drop-file">
                        <input type="file" name="content" class="files">
                        <a href=""  class="btn btn-sm btn-danger btn-upload"><i class="fas fa-upload"></i> Tải lên</a>
                        
                        @if(isset($productCourse))


                            <a href=""  id="btn-preview-player" data-src="{{ $productCourse->type_content=="pdf" ? url($productCourse->player) : $productCourse->player  }}" class="btn btn-hero-success text-light btn-hero-sm">
                                <i class="far fa-eye"></i>
                            </a>

                        @endif


                        <div class="row box-preview @error("content") is-invalid @enderror ">

                        </div>

                        @error("content") 

                        <small class="error">{{ $message }}</small>

                        @enderror

                    </div>
                </div>
                <!-- btn -->
                <div class="col-12">
                    <button name="" id="btn-save" class="btn btn-hero-info float-right">Lưu</button>
                </div>
                <div class="col-12 mb-3">
                    <div class="annotate text-danger font-weight-bold text-shadow">
                        <small class="d-block">Các dấu * là trường bắt buộc</small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

@if(isset($productCourse))

{{-- model route course --}}

<div class="modal fade" id="preview_player" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="registermodal">
            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
            <div class="modal-body">
                <h4 class="modal-header-title"> Preview sản phẩm của bài giảng  </h4>

                <iframe src="" width="100%" height="500px"></iframe>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}

@endif


@endsection
