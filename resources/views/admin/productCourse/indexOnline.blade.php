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
                    text: "Bạn muốn phục hồi bài giảng này ",
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
                    text: "Bạn muốn xóa vĩnh viễn bài giảng",
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
                    send+= $(this).attr("product");
                    send+= ",";
                })
                send=send.substr(0, send.length - 1);
                $.get("{{route("admin.course.online.multitask",!empty($option) ?"restore":"trash")}}",{ids:send},function(data){
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

            $(".btn-preview-player").click(function(){

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
@endphp

{{-- require content --}}
@section('content')

<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Danh Sách Bài Giảng {{ empty($option) ? "":"(Thùng rác)" }} <small class="d-block font-size-sm">{{ $course->name  }}</small> </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Giảng</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <form id="content" class="p-2 sort_table">
        <div class="block block-rounded">
            <div class="actions user action-all px-4 pt-4">
               
                {{-- static index  --}}

                <a href="{{ route("admin.course.online",$course->id) }}" type="button" class="btn-action btn-hero-success btn-current">
                    <i class="fas fa-home"></i>
                    <span class="label">

                        {{ $static["index"] }}

                    </span>
                </a>

                {{-- static trash --}}

                <a href="{{ route("admin.course.online",["id"=>$course->id,"option"=>"trash"]) }}" type="button" class="btn-action btn-hero-warning btn-trash mx-2">
                    <i class="far fa-trash-alt"></i>
                    <span class="label">

                        {{ $static["trash"] }}

                    </span>
                </a>
                

                {{-- btn add --}}

                <a href="{{ route("admin.course.online.add",$course->id) }}" type="button" class="btn-action btn-hero-light btn-add">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="block-content">
                <form class="dataTables_wrapper dt-bootstrap4 no-footer sort_table">
                    <input type="hidden" name="mod" value="course">
                    <div class="row">
                        <!-- các tác vụ khác xóa nhiều -->
                        <div class="col-md-3">
                            <div class="dropdown d-inline-block">
                                <a href="" class="btn-sm btn btn-primary" id="dropdown-dropright-hero-primary" data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><i class="text-warning fa fa-trash-alt"></i>
                                        <a href="" id="btn-multitask" class="mx-2 text-muted">{{$option ? "Phục hồi Khóa học" :"Xóa khóa học" }}</a>
                                    </li>
                                </ul>

                            </div>
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
                        </div>
                        <!-- select chapter -->
                        <div class="col-md-3">
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">Tất cả</option>
                                @foreach($chapters as $chapter)

                                <option value="{{ $chapter->id }}"
                                    
                                    @if(request("parent_id") == $chapter->id )

                                        selected

                                    @endif 

                                    > {{ $chapter->name }} </option>

                               @endforeach
                            </select>
                        </div>
                        <!-- select chapter -->
                        <div class="col-md-3">
                            <select name="view" id="chapter" class="form-control">
                                <option value="">Tất cả</option>
                                <option value="pay">Trả Phí</option>
                                <option value="tree">Không trả Phí</option>
                            </select>
                        </div>
                        <!-- seach -->
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="seach" placeholder="Tìm kiếm">
                        </div>
                        <div class="col-12 overflow-auto">
                            <table class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed" id="example" role="grid">
                                <thead>
                                    <tr id="header-row">
                                        <!-- checkall -->
                                        <td class="no-sort">
                                            <div class="custom-control-success custom-control custom-checkbox">
                                                <input type="checkbox"  class="custom-control-input" id="checkall" name="">
                                                <label class="custom-control-label" for="checkall"></label>
                                            </div>
                                        </td>
                                        <th class="sorting sort" style="width: 10px;">
                                            <input type="hidden" name="ID" value="asc">
                                            STT
                                        </th>
                                        <th class="sorting sort">
                                            <input type="hidden" name="video" value="desc">
                                            Video/pdf
                                        </th>
                                        <th class="sorting sort">
                                            <input type="hidden" name="name" value="asc">
                                            Tên Bài Giảng
                                        </th>
                                        <th class="">
                                            <input type="hidden" name="date_created" value="asc">
                                            Trả phí
                                        </th>
                                        <th class="sorting sort" style="width: 10%;">
                                            <input type="hidden" name="course" value="desc">
                                            Chương học
                                        </th>
                                        <th class="sorting sort">
                                            <input type="hidden" name="date_created" value="asc">
                                            Ngày tạo
                                        </th>
                                        <th class="">
                                            <input type="hidden" name="">
                                            Trạng Thái
                                        </th>
                                        <th class="no-sort">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @php
                                    $temp=0;
                                    @endphp
                                    @if(count($productCourses))
                                    @foreach ($productCourses as $productCourse)

                                    <tr>
                                        <td>
                                            <div class="custom-control-success">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input multitask" product="{{ $productCourse->id }}" id="user-4"><label class="custom-control-label" for="user-4"></label></div>
                                            </div>
                                        </td>
                                        <td>{{ ++$temp }}</td>
                                        <td>
                                            {{-- trong database để đường dẫn bị ngu nên phải dùng cách này nhé --}}
                                            <button class="btn-preview-player btn btn-hero-success btn-hero-sm" data-src="{{ $productCourse->type_content=="pdf" ? url($productCourse->player) : $productCourse->player  }}" >{{  $productCourse->type_content  }}</button>
                                        </td>
                                        <td>

                                            {{ $productCourse->name }}

                                        </td>
                                        <td class="">

                                            {{ $productCourse->view }}
                                            
                                        </td>
                                        <td>

                                            {{ App\Models\Product_course::find($productCourse->parent_id)->name }}

                                        </td>
                                        <td>

                                            {{ $productCourse->created_at }}

                                        </td>
                                        <td>

                                            {{ $status[$productCourse->status] }}

                                        </td>
                                        
                                        <td>
                                            @if(empty($option)) 
                                                <a href="{{ route("admin.course.online.update", $productCourse->id) }}" class="btn-update-user btn btn-sm btn-success" user="4"><i class="fas fa-pen"></i></a>
                                                <a href=" {{ route("admin.course.online.delete", $productCourse->id) }} " id="" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                            @else
                                                <a href="{{ route('admin.course.online.restore', $productCourse->id) }}" class="btn-restore btn btn-sm btn-success" user="4"><i class="fas fa-trash-restore"></i></a>
                                                <a href="{{ route('admin.course.online.destroy', $productCourse->id) }}" class="btn-destroy btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                                            @endif
                                        </td>
                                    </tr>

                                    @endforeach
                                    @else

                                    <tr>
                                        <td colspan="9" class="text-warning-light" >Hiện chưa có khóa học online nào trong bảng nay</td>
                                    </tr>
                                        
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <!-- paginate -->
                        <div class="box-paginate col-12">
                            <ul class="paginate list-unstyled">
                                @for ($i = 1; $i <= ceil($productCourses->total() / $productCourses->perPage()); $i++)
                                    <li>
                                        
                                        <button name="page" value="{{ $i }}" class="@if($productCourses->currentPage()==$i) active @endif">{{ $i }}</button>

                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <!-- end paginate -->
                    </div>
                </form>
            </div>
        </div>
    </form>
</main>

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

@endsection
