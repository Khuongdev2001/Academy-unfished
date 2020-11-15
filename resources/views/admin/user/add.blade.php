@extends("layouts.admin")
@section('title', empty($user->fullname) ? "Thêm Học Viên":"Cập Nhật Học Viên")
    {{-- require css --}}
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

{{-- require js --}}
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
        focusActive(["fullname", "email", "phone", "username", "password"]);
        dropUploadFiles(8, ["image", "video"]);
        onlyNumber(["phone"]);
   </script>
@endsection


{{-- require content --}}
@section('content')
    <main id="main-container">
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{empty($user->fullname) ? "Thêm Học Viên":"Cập Nhật Học Viên" }}</h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Firs Pi Project</li>
                            <li class="breadcrumb-item active" aria-current="page">{{empty($user->fullname) ? "Thêm Học Viên":"Cập Nhật Học Viên" }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="block block-rounded">

                <form action="{{ isset($user)?route('admin.user.update',$user->id) : route('admin.user.add') }}" enctype="multipart/form-data" method="POST"
                    class="block-content row" style="overflow: auto;">

                    @csrf

                    <!-- btn -->
                    <div class="form-group col-12">
                        <button class="btn btn-hero-sm btn-hero-info"><i class="far fa-sticky-note"></i> Danh sách</button>
                        <button class="btn btn-hero-sm btn-hero-warning">Học Tập</button>
                        <button name="" class="btn btn-hero-sm btn-hero-success"><i class="fas fa-save"></i> Lưu</button>
                    </div>
                    {{-- fullname: Tên phòng --}}
                    <div class="form-group col-md-4">
                        <label for="fullname">Họ và tên: *</label>
                        <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" value="{{old("fullname") ??$user->fullname??''}}">
                        @error('fullname')
                            <small class="error">{{$message}}</small>
                        @enderror
                    </div>
                    {{-- email --}}
                    <div class="form-group col-md-4">
                        <label for="email">Email: *</label>
                        <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old("email") ??$user->email??''}}">
                        @error('email')
                            <small class="error">{{$message}}</small>
                        @enderror
                    </div>
                    {{-- phone: Số điện thoại --}}
                    <div class="form-group col-md-4">
                        <label for="phone">SĐT: *</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old("phone") ??$user->phone??''}}">
                        @error('phone')
                            <small class="error">{{$message}}</small>
                        @enderror
                    </div>
                    {{-- username:Tài Khoản --}}
                    <div class="form-group col-md-4">
                        <label for="username" class="label-Unaffected">Tài khoản: *</label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{old("username") ??$user->username??''}}">
                        @error('username')
                            <small class="error">{{$message}}</small>
                        @enderror
                    </div>
                    {{-- password: Mật Khẩu --}}
                    <div class="form-group col-md-4">
                        <label for="password" class="label-Unaffected">Mật khẩu: *</label>
                        <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{old("password") ??''}}">
                        @error('password')
                            <small class="error">{{$message}}</small>
                        @enderror
                    </div>
                    {{-- role --}}
                    <div class="form-group col-md-4">
                        <label for="role_id" class="label-Unaffected">Quyền: *</label>
                        <select name="role_id" class="form-control" id="role_id">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}"

                                    {{-- checked update --}}
                                    
                                    @if(isset($user) && $user->role[0]->id==$role->id)
                                        checked    
                                    @endif
                                >
                                    {{$role->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- note: Ghi Chú --}}
                    <div class="form-group col-md-9">
                        <label for="note" class="label-Unaffected">Ghi chú</label>
                        <textarea name="note" id="note" class="form-control" cols="30" rows="8">{{old('note')}}</textarea>
                    </div>
                    {{-- dropfile --}}
                    <div class="form-group col-md-3 position-relative @error('thumbnail') is-invalid @enderror">
                        @error('thumbnail')
                            <small class="error">{{$message}}</small>
                        @enderror
                        <label for="thumbnail" class="label-Unaffected">Upload Ảnh: *</label>
                        <div class="box-upload position-relative my-2 ">
                            <img src="{{asset($user->thumbnail ?? "" )}}" id="img-uploaded" class="img-responsive img-circle" />
                            <button id="btn-upload" class="btn btn-hero-success btn-hero-sm"><i
                                    class="fas fa-file-upload"></i></button>
                            <input type="file" id="thumbnail" name="thumbnail" style="display:none" />
                            <input type="hidden" id="hidden-thumbnail" name="thumbnailHidden" value="">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <!-- annotate:chú giải -->
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
