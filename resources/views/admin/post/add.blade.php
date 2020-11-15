@extends("layouts.admin")
@section('title', empty($post->name) ? "Thêm Bài Viết":"Cập Nhật Bài Viết")

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

        // tiny editer
        tinymce.init({
            selector: '#content,#desc',
            width: '100%',
            height: 300,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'table emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                    'link image | print preview media fullpage | ' +
                    'forecolor backcolor emoticons | color',
            menu: {
            favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
            },
            menubar: 'favs file edit view insert format tools table help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });  
        });
        focusActive(["name", "desc"]);
   </script>
   {{-- tiny --}}
   <script src="https://cdn.tiny.cloud/1/edh27xw97jy1skqrcujdby7j08ri5t8b51xrh6dp8fyiblko/tinymce/5/tinymce.min.js"></script>
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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{empty($post->name) ? "Thêm Bài Viết":"Cập Nhật Bài Viết" }}</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">{{empty($post->name) ? "Thêm Bài Viết":"Cập Nhật Bài Viết" }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <form action="{{ isset($post)?route('admin.post.update',$post->id) : route('admin.post.add') }}" enctype="multipart/form-data" method="POST" class="block-content row" style="overflow: auto;">
                
                @csrf
                
                <div class="form-group col-12">
                    <a href="{{ route("admin.post") }}" class="btn btn-hero-sm btn-hero-info"><i class="far fa-sticky-note"></i> Danh sách</a>
                </div>

                {{-- name --}}

                <div class="form-group col-md-12">
                    <label for="name">Tiêu đề: * </label>
                    <input type="text" name="name" id="name" class="form-control form-control @error('name') is-invalid @enderror" value="{{old("name") ??$post->name ??''}}">
                    @error('name')
                        <small class="error">{{$message}}</small>
                    @enderror
                </div>
                {{-- cat --}}
                <div class="form-group col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cat_id" class="label-Unaffected">Danh mục: *</label>
                            <select name="cat_id" id="cat_id" class="form-control @error('cat_id') is-invalid @enderror">
                                
                                <option>Chọn danh mục</option>
                               @foreach($cats as $cat)

                                <option value="{{$cat->id}}"
                                    
                                    {{-- checked update --}}
                                    
                                    @if(isset($post) && $post->cat_id==$cat->id)
                                        selected    
                                    @endif     

                                >{{$cat->name}}</option>

                               @endforeach

                               @error('cat_id')
                                    <small class="error">{{$message}}</small>
                                @enderror    
                            </select>
                        </div>

                         {{-- status --}}

                        <div class="form-group col-md-6">
                            <label for="status" class="label-Unaffected" >Công khai: *</label>
                            <select name="status" id="status" class="form-control">
                                @foreach($status as $k=> $status)
                                    <option value="{{$k}}"
                                        {{-- seclected  status --}}
                                        @if(isset($post) && $post->status==$k)
    
                                            selected
    
                                        @endif
    
                                >       {{$status}}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                
                </div>


                {{-- content --}}


                <div class="form-group col-md-12">
                    <label for="content" class="label-Unaffected" >Nội dung: *</label>
                    <textarea name="content" id="content" placeholder="Nội dung bài viết" class="form-control @error('content') is-invalid @enderror" cols="30" rows="5">{{old("content") ??$post->content??''}}</textarea>
                    @error('content')
                        <small class="error">{{$message}}</small>
                    @enderror
                </div>

                {{-- desc --}}


                <div class="form-group col-md-8">
                    <label for="content" class="label-Unaffected">Mô tả: *</label>
                    <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Mô tả bài viết" class="form-control @error('content') is-invalid @enderror" >{{old("desc") ??$post->desc??''}}</textarea>
                    @error('desc')
                        <small class="error">{{$message}}</small>
                    @enderror
                </div>

                {{-- dropfile --}}


                <div class="form-group col-md-4 position-relative">
                    @error('thumbnail')
                        <small class="error">{{$message}}</small>
                    @enderror
                    <label for="thumbnail" class="label-Unaffected">Upload Ảnh: *</label>
                    <div class="box-upload position-relative my-2 @error('thumbnail') is-invalid @enderror">
                        <img src="{{asset($post->thumbnail ?? "" )}}" id="img-uploaded" class="img-responsive img-circle" />
                        <a href="" id="btn-upload" class="btn btn-hero-success btn-hero-sm"><i class="fas fa-file-upload"></i></a>
                        <input type="file" id="thumbnail" name="thumbnail" style="display:none" />
                        <input type="hidden" id="hidden-thumbnail" name="thumbnailHidden" value="">
                    </div>
                </div>
                
                {{-- btn --}}


                <div class="col-12 mb-3">
                    <button class="btn btn-hero-sm btn-hero-info float-right"><i class="fas fa-save"></i> Lưu</button>
                    <div class="annotate text-danger font-weight-bold text-shadow">
                        <small class="d-block">Các dấu * là trường bắt buộc</small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

{{-- modal drop file --}}
<div class="modal fade" id="modal-crop-img" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image Before Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection


