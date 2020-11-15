@extends("layouts.admin")

{{-- require title --}}

@section("title",$option  ?? "" ? "Hiện thành" :"" )

{{-- require css --}}
@section('css')

    <link rel="stylesheet" href="{{ asset('plugin/datatable/css/table.css') }}">

    {{-- css plugin crop img --}}

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

    {{-- sweetalert  --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    {{-- datatable --}}
    <script src="{{ asset('plugin/datatable/js/table.js') }}"></script>

    {{-- drop image --}}
    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>

<script>

    {{-- auto open modal add cat  --}}

    @if ($errors->any())
        jQuery('#slider').modal('show');
    @endif

    {{-- auto open model update cat --}}

    @if(isset($slider))
        jQuery('#slider').modal('show');
    @endif


    $(document).ready(function() {
            datatable();
            focusActive(["name"]);
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
                    text: "Bạn muốn phục hồi slider này ",
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
                    text: "Bạn muốn xóa slider này",
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
                    send+=$(this).attr("slider");
                    send+=",";
                })
                send=send.substr(0, send.length - 1);
                $.get("{{route("admin.slider.multitask",!empty($option) ?"restore":"trash")}}",{ids:send},function(data){
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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Danh sách Slider {{ $option  ?? "" ? "(Thùng Rác)" :"" }}  </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách Slider </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div id="content" class="p-2">
        <div class="block block-rounded">
            <div class="actions user action-all px-4 pt-4">
                {{-- index --}}

                <a href="{{route("admin.slider")}}" class="btn-action btn-dual btn-current mr-2 ">
                    <i class="fas fa-home"></i>
                    <span class="label">{{$static["index"]}}</span>
                </a>
                {{-- trash --}}

                <a href="{{route("admin.slider","trash")}}" class="btn-action btn-danger btn-trash mx-2">
                    <i class="far fa-trash-alt"></i>
                    <span class="label">{{$static["trash"]}}</span>
                </a>
                {{-- btn add --}}

                <a href="" data-toggle="modal" data-target="#slider" class="btn-action btn-dark btn-add">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <form class="block-content sort_table" action="">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <!-- các tác vụ khác xóa nhiều -->
                            <div class="dropdown d-inline-block">
                                <a href="" class="btn-sm btn btn-danger" id="dropdown-dropright-hero-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <a href="" id="btn-multitask" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i> Đưa vào thùng rác</a>
                                </ul>
                            </div>
                            <div class="d-inline-block">
                                <label>
                                    <select class="form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input type="text" name="seach" id="seach" class="form-control form-control-sm" placeholder="Tìm kiếm....">
                        </div>
                        <div class="col-sm-12 overflow-auto">
                            <table class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed" id="example" role="grid">
                                <thead>
                                    <tr id="header-row">
                                        <!-- checkall -->
                                        <td class="no-sort sort" style="width: 0.5%;">
                                            <div class="custom-control-success custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkall" name="example-cb-custom-inline1">
                                                <label class="custom-control-label" for="checkall"></label>
                                            </div>
                                        </td>
                                        <th  style="width: 5%;">
                                            ID
                                        </th>
                                        <th  style="width: 2%;">
                                            Ảnh
                                        </th>
                                        <th class="sort sorting" style="width: 2%;">
                                            <input type="hidden" name="name" value="{{ request("name") }}">
                                            Tiêu đề
                                        </th>
                                        <th style="width: 10%;">
                                            Trạng thái
                                        </th>
                                        <th class="sorting sort" style="width: 15%;">
                                            <input type="hidden" name="created_at" value="{{ request("created_at") }}">
                                            Ngày tạo
                                        </th>
                                        <th class="no-sort" style="width: 5%;">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $temp=0;
                                    @endphp
                                    @if(count($sliders))
                                    @foreach($sliders as $item )
                                    <tr>
                                        <td>
                                            <div class="custom-control-success">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input multitask"  slider="{{$item->id}}" id="{{$item->id}}"><label class="custom-control-label" for="slider-{{$item->id}}"></label></div>
                                            </div>
                                        </td>
                                        <td class="">{{++ $temp}}</td>
                                        <td class="p-1"><a href=""><img src="{{ asset($item->thumbnail) }}"></a></td>
                                        <td>{{$item->name}}</td>
                                        <td class="">{{ $status[$item->status] }}...</td>
                                        <td class="">{{ $item->created_at }}</td>
                                        
                                        @if(empty($option))
                                            <td>
                                                <a href="{{ route('admin.slider.update', $item->id) }}" class="btn-update btn btn-sm btn-success" slider="4"><i class="fas fa-pen"></i></a>
                                                <a href="{{ route('admin.slider.delete', $item->id) }}" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                            @else
                                            <td>
                                                <a href="{{ route('admin.slider.restore', $item->id) }}" class="btn-restore btn btn-sm btn-success" user="4"><i class="fas fa-trash-restore"></i></a>
                                                <a href="{{ route('admin.slider.destroy', $item->id) }}" class="btn-destroy btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        @endif
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
                        <div class="box-paginate col-12">
                            <ul class="paginate list-unstyled">
                                @for ($i = 1; $i <= ceil($sliders->total() / $sliders->perPage()); $i++)
                                    <li>
                                        <button name="page" value="{{ $i }}" class="@if($sliders->currentPage()==$i) active @endif"  >{{ $i }}</button>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

{{-- modal add slider  --}}

<div class="modal fade" id="slider" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="registermodal">
            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
            <div class="modal-body">
                <h4 class="modal-header-title">{{ isset($slider) ? "Cập nhật Slider":"Thêm Slider " }}</h4>
                <form method="POST" action="{{ isset($slider)?route('admin.slider.update',$slider->id) : route('admin.slider.add') }}" enctype="multipart/form-data" class="slider-add slider-update row">

                    @csrf

                    {{-- name --}}

                    <div class="form-group col-md-12">
                        <label for="name">Tiêu đề: * </label>
                        <input type="text" name="name" id="name" class="form-control form-control @error('name') is-invalid @enderror" value="{{old("name") ??$slider->name ??''}}">
                        @error('name')
                            <small class="error">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group  col-12">
                        <select name="status" id="status" class="form-control">

                            {{-- foreach status --}}

                            @foreach($status as $k=>$item)
                                <option value="{{$k}}"
                                @if(isset($slider) && $k==$slider->status)

                                    selected

                                @endif

                                >{{$item}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- dropfile --}}


                    <div class="form-group col-md-12 position-relative">
                        @error('thumbnail')
                        <small class="error">{{$message}}</small>
                        @enderror
                        <label for="thumbnail" class="label-Unaffected">Upload Ảnh: *</label>
                        <div class="box-upload position-relative my-2 @error('thumbnail') is-invalid @enderror">
                            <img src="{{asset($slider->thumbnail ?? "" )}}" id="img-uploaded" class="img-responsive img-circle" />
                            <a href="" id="btn-upload" class="btn btn-hero-success btn-hero-sm"><i class="fas fa-file-upload"></i></a>
                            <input type="file" id="thumbnail" name="thumbnail" style="display:none" />
                            <input type="hidden" id="hidden-thumbnail" name="thumbnailHidden" value="">
                        </div>
                    </div>

                    {{-- btn add --}}

                    <div class="form-group col-12 ">
                        <button class="btn btn-hero-sm btn-hero-success"><i class="fas fa-save"></i> Lưu</button>
                        <a href="{{route("admin.slider.add")}}" class="btn btn-hero-sm btn-hero-info float-right"><i class="fas fa-save"></i> Chuyển trang thêm</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}

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
{{-- End model --}}
@endsection
