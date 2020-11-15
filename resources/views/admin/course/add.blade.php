@extends("layouts.admin")
@section('title', empty($course->name) ? "Thêm Khóa Học":"Cập Nhật Khóa Học")

{{-- required css --}}
@section('css')
    
@endsection

{{-- required js --}}

@section('js')
    <script src="{{ asset('js/onlynumber.js') }}"></script>
    <script>
        $(document).ready(function() {
            onlyNumber(["price","price_old","view"]);
            focusActive(["name", "desc"]);
            dropUploadFiles([1, 1], ["image", "video"]);        
        });
   </script>
@endsection


{{-- status --}}
@php
    $status=["show"=>"công khai","hidden"=>"chờ duyệt"];
@endphp


{{-- require content --}}
@section('content')

<main id="main-container">
    <div class="content">
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ empty($course->name) ? "Thêm Khóa Học":"Cập Nhật Khóa Học" }}</h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Firs Pi Project</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ empty($course->name) ? "Thêm Khóa Học":"Cập Nhật Khóa Học" }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div id="content" class="p-2">
            <div class="block block-rounded">
                <form action="{{ isset($course)?route('admin.course.update',$course->id) : route('admin.course.add') }}" method="POST" id="course" class="block-content" enctype="multipart/form-data">
                    <div class="actions user action-all">
                        <!-- trash: thùng rác -->
                        <a href="https://khuong.unitopcv.com/bambooHouse/admin/room/trash" class="btn-action btn-hero-warning btn-trash btn-sm">
                            <i class="far fa-trash-alt"></i>
                            <span class="label">{{ $static["index"] }}</span>
                        </a>
                        <a href="" class="btn-action btn-hero-success mx-2 btn-sm"><i class="far fa-file"></i>
                            <span class="label">
                                <span class="label">{{ $static["trash"] }}</span>
                            </span>
                        </a>
                        <!-- btn-add:thêm phòng -->
                        <a href="{{route("admin.course.add")}}" class="btn-action btn-hero-light btn-add btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>

                    @csrf

                    <div id="content-body" class="row my-4">

                        {{-- name --}}

                        <div class="form-group col-md-6">
                            <label for="name" class="label-Unaffected">Tên khóa học</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old("name") ??$course->name ??''}}">

                            @error('name')
                                <small class="error">{{$message}}</small>
                            @enderror
                        </div>

                        {{-- price --}}

                        
                        <div class="form-group col-md-3">
                            <label for="price" class="label-Unaffected">Giá: *</label>
                            <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{old("price") ??$course->price ??''}}" placeholder="Bỏ trống là free">
                        
                            @error('price')
                                <small class="error">{{$message}}</small>
                            @enderror

                        </div>


                        {{-- price_old --}}


                        <div class="form-group col-md-3">
                            <label for="price_old" class="label-Unaffected">Giá Cũ: </label>
                            <input type="text" name="price_old" id="price_old" class="form-control @error('price_old') is-invalid @enderror" value="{{old("price_old") ??$course->price_old ??''}}" placeholder="Đơn vị VNĐ">
                        
                            @error('price_old')
                                <small class="error">{{$message}}</small>
                            @enderror
                            
                        </div>


                        {{-- status --}}

                        <div class="form-group col-md-4">
                            <label for="status" class="label-Unaffected">Trạng Thái: *</label>
                            <select name="status" id="status" class="form-control">
                                @foreach($status as $k=>$item)

                                    <option value="{{$k}}"
                                    
                                        @if(isset($course) && $k==$course->status)

                                            selected

                                        @endif

                                    >{{$item}}</option>

                                @endforeach
                            </select>
                        
                            @error('status')
                                <small class="error">{{$message}}</small>
                            @enderror
                        
                        </div>

                        {{-- cat_id cho biết khóa học online hay offline --}}

                        <div class="form-group col-md-4">
                            <label for="cat_id" class="label-Unaffected">Online/Offline: *</label>
                            <select name="cat_id" id="cat_id" class="form-control @error('cat_id') is-invalid @enderror">
                                @foreach($catCourse as $cat)

                                    <option value="{{$cat->id}}"
                                        
                                        @if(isset($course) && $cat->id==$course->cat_id)

                                            selected

                                        @endif

                                    >{{$cat->name}}</option>
                                
                                @endforeach
                            </select>

                            @error('cat_id')
                                <small class="error">{{$message}}</small>
                            @enderror

                        </div>

                        {{-- số view --}}


                        <div class="form-group col-md-4">
                            <label for="view" class="label-Unaffected">Lược view khóa học: </label>
                            <input type="text" name="view" id="view" class="form-control @error('view') is-invalid @enderror" placeholder="Mặc định auto" value="{{old("view") ??$course->view ??''}}" >
                        
                            @error('view')
                                <small class="error">{{$message}}</small>
                            @enderror
                        
                        </div>


                        <!-- line -->
                        <div class="line">
                            <span class="label">Phần nội dung của các khối</span>
                        </div>


                        {{-- content:nội dung --}}


                        <div class="form-group col-12">
                            <label for="content " class="label-Unaffected">Nội dung: </label>
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" cols="30" rows="6" placeholder="Vui lòng nhập các yêu cầu của khóa học này">{{old("content") ??$course->content??''}}</textarea>
                        
                            @error('content')
                                <small class="error">{{$message}}</small>
                            @enderror
                        
                        </div>
                        
                        {{-- note  --}}


                        <div class="form-group col-12">
                            <label for="note" class="label-Unaffected">Ghi chú: </label>
                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" cols="30" rows="5" placeholder="Ghi chú chỉ có thể nhìn thấy ở đây">{{old("note") ??$course->note??''}}</textarea>
                        
                            @error('note')
                                <small class="error">{{$message}}</small>
                            @enderror
                        
                        </div>
                        
                        {{-- thumbnail --}}


                        <div class="form-group col-md-6">
                            <label for="thumbnail" class="label-Unaffected">Upload Ảnh: </label>
                            <div class="drop-file">
                                <input type="file" name="thumbnail" id="thumbnail" class="files">
                                <a href="" class="btn btn-success btn-sm btn-upload"><i class="fas fa-upload"></i> Tải lên</a>
                                <div class="row box-preview">

                                    @if(!empty($course->thumbnail))

                                        <img src="{{asset($course->thumbnail)}}" controls class="w-100 d-inline-block">

                                    @endif

                                </div>
                            </div>
                        
                            @error('thumbnail')
                                <small class="error">{{$message}}</small>
                            @enderror
                        
                        </div>
                        

                        {{-- video preview --}}

                        <div class="form-group col-md-6">
                            <label for="video" class="label-Unaffected">Video Preview: </label>
                            <div class="drop-file">
                                <input type="file" name="video" id="video" class="files">
                                <a href="" class="btn btn-danger btn-sm btn-upload"><i class="fas fa-upload"></i> Tải lên</a>
                                <div class="row box-preview">

                                    @if(!empty($course->video))

                                        <video src="{{asset($course->video)}}" controls class="w-100"></video>

                                    @endif

                                </div>
                            </div>

                            @error('video')
                                <small class="error">{{$message}}</small>
                            @enderror

                        </div>
                       
                        {{-- btn add --}}

                        <div class="btn col-md-12">
                            <button class="btn btn-hero-info float-right">lưu</button>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="annotate text-danger font-weight-bold text-shadow">
                                <small class="d-block">Các dấu * là trường bắt buộc</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- /resources/views/post/create.blade.php -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Create Post Form -->

@endsection


