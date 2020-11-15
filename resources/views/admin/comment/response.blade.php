@extends("layouts.admin")
@section('title', empty($comment->content) ? "Thêm Bài Viết":"Cập Nhật Comment")

{{-- required css --}}
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
    <style>
        .image_area {
            position: relative;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }

        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }


        {{-- css rate --}}

        .js-rating i{

            color:#6c757d!important;


        }

        .js-rating i.active{

            color:#ffb119!important;

        }



    </style>

@endsection

{{-- required js --}}

@section('js')
    {{-- drop image --}}
    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>
    <script src="{{ asset('js/onlynumber.js') }}"></script>
    <script>
        $(document).ready(function() {
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
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
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
                    };
                });
            });

                        
        });
        focusActive(["name", "desc"]);
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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Cập Nhật Comment {{ $option["title"] }} <small class="d-block font-size-sm"> {{$cat->name ??"" }}</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Cập Nhật Comment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <form action=" @if($option["module"]=="course" ){{ route("admin.comment.course.response",["cat"=>$cat->id,"id"=>$comment->id]) }} @else {{ route("admin.comment.course.response",["cat"=>$cat->id,"id"=>$comment->id]) }} @endif " enctype="multipart/form-data" method="POST" class="block-content row" style="overflow: auto;">
                
                @csrf
                
                <!-- btn -->
                <div class="col-12 mb-4">
                    <button name="" class="btn btn-sm btn-success"><i class="far fa-edit"></i> Cập nhật</button>
                    <button name="" class="btn btn-sm btn-info"><i class="fas fa-share-square"></i> Chuyển đến comment</button>
                </div>
                <!-- name:tên phòng -->
                <div class="form-group col-md-4">
                    <label for="name">Người Bình Luận</label>
                    <input type="text" name="name" id="name" class="form-control" readonly value="{{ $comment->user->fullname }}">
                </div>
                <!-- star -->
                <div class="form-group d-flex col-md-4 align-self-center">
                    <label for="email" class="label-Unaffected">Số Sao:<small>(Tuyệt vời)</small></label>
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
                </div>

                {{-- status --}}

                <select name="status" class="col-md-4 form-control">

                    @foreach($status as $k=> $item)
                    
                        <option value="{{ $k }}"
                        
                        @if($k==$comment->status)

                            selected

                        @endif

                        >{{$item}}</option>
                    
                    @endforeach

                </select>

                <!-- content -->
                <div class="form-group col-md-12">
                    <label for="content" class="label-Unaffected">Nội dung:</label>
                    <textarea name="content" id="content" class="form-control" cols="30" rows="3">{{ $comment->content }}</textarea>
                </div>
                <!-- preview thumbnail comment -->
                <div class="form-group col-md-6">
                    <label for="file" class="label-Unaffected">Ảnh Comment: </label>
                    
                    <div class="row box-preview">
                        {{-- nếu có thumbnail --}}

                        @if(!empty($comment->thumbnail))

                            <img src="{{ asset($comment->thumbnail) }}" alt="">

                        {{-- không có thumbnail --}}

                        @else

                            <small class="text-warning font-weight-bold col-4">Hiện không có ảnh </small>

                        @endif    
                    </div>
                   
                </div>
                <!-- preview video comment -->
                <div class="form-group col-md-6">
                    <label for="file" class="label-Unaffected">Video Comment:</label>

                    <div class="row box-preview">
                        {{-- nếu có video --}}

                        @if(!empty($comment->video))

                            <img src="{{ asset($comment->video) }}" alt="">

                        {{-- không có video --}}

                        @else

                            <small class="text-warning font-weight-bold col-4">Hiện không video </small>

                        @endif    
                    </div>
                </div>
                <!-- note -->
                <div class="form-group col-md-12 nnotate text-danger font-weight-bold text-shadow">
                    <small class="d-block">Bạn Chỉ được phép trả lời comment hoặc xóa đi </small>
                </div>
            </form>
        </div>
    </div>
</main>


@endsection


