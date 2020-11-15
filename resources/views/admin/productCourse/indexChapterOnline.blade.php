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
            
            dropUploadFiles([1], ["image"]);

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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Thêm Chương học Online <small class="d-block font-size-sm"> {{$course->name ??"" }} </small></h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm Chương học Online</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <!-- chapter -->
        <form class="block block-rounded p-3 sort_table ">
            <div class="form-group col-12">
                <a href="#" class="btn btn-hero-sm btn-hero-light" data-toggle="modal" data-target="#modal-chapter">Thêm Chương Học</a>
            </div>

            <div class="form-group d-inline-block">
                <input type="text" id="seach" name="seach" class="form-control w-auto form-control-sm" placeholder="Tìm kiếm chương học" value="{{ request("seach") }}">
            </div>
            <table id="indexChapter" class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th class="sort sorting" >
                            
                            Tên Chương

                            <input type="hidden" name="name" value="{{ request("name") }}">
                        </th>
                        <th>Trạng thái</th>
                        <th class="sort sorting">
                            Ngày tạo
                            <input type="hidden" name="created_at" value="{{ request("created_at") }}">
                        </th>
                        <th>Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $temp=0;
                    @endphp
                    @if(count($chapters))
                    @foreach ($chapters as $item)
                    <tr>
                        <td>{{ ++$temp }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $status[$item->status] }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{route("admin.course.online.chapter",$course->id)}}?update={{$item->id}}" class="btn-update-user btn btn-sm btn-success"><i class="fas fa-pen"></i></a>
                            <a href="{{route("admin.course.online.chapter.delete",$item->id)}}" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach
                        @else

                            <tr>
                                <td colspan="4" class="text-warning-light" >Hiện chưa có bài viết nào trong bảng nay</td>
                            </tr>
                            
                        @endif  
                </tbody>
            </table>
            <div class="box-paginate clearfix">
                <ul class="paginate list-unstyled">
                    @for ($i = 1; $i <= ceil($chapters->total() / $chapters->perPage()); $i++)
                        <li>
                            <button name="page" value="{{ $i }}" class="@if($chapters->currentPage()==$i) active @endif">{{ $i }}</button>
                        </li>
                    @endfor
                </ul>
            </div>
        </form>
    </div>
</main>



{{-- model chapter --}}

<div class="modal fade" id="modal-chapter" tabindex="-1" role="dialog" aria-labelledby="chapter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
        <div class="modal-content" id="sign-up">
            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
            <div class="modal-body">
                <h4 class="modal-header-title">{{ isset($chapter) ?"Cập nhật chương" :"Thêm chương" }}</h4>
                <div>
                    <form action="{{ isset($chapter) ? route("admin.course.online.chapter.update",$chapter->id) : route("admin.course.online.chapter.add",$course->id) }}" enctype="multipart/form-data" method="POST" class="block-content row" style="overflow: auto;">
                        
                        @csrf
                        
                        <div class="col-md-12 my-2">                            
                            <button name="" class="btn btn-hero-sm btn-hero-light"><i class="fas fa-save"></i> Lưu</button>
                        </div>

                        {{-- name --}}
                        
                        <div class="col-md-12">
                            <label for="name">Tên chương: *</label>
                            <input type="text" id="nameChapter" class="form-control" name="nameChapter"value="{{old("nameChapter") ??$chapter->name ??''}}">

                            @error('nameChapter')
                                <small class="error">{{$message}}</small>
                            @enderror

                        </div>

                        {{-- status chapter --}}

                        <div class="col-md-12 my-3">

                            <label for="status" class="label-Unaffected" >Công khai: *</label>
                            <select name="status" id="status" class="form-control">
                            @foreach($status as $k=> $item)
                                <option value="{{$k}}"
                                    {{-- seclected  status --}}
                                    @if(isset($chapter) && $chapter->status==$k)

                                        selected

                                    @endif

                                >       {{$item}}
                                </option>
                            @endforeach
                            </select>

                        </div>
                        

                        
                        {{-- note --}}
                        
                        <div class="col-12 m-3">
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

{{-- end model chapter --}}

@endsection
