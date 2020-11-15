@extends("layouts.admin")

{{-- require title --}}

@section("title","Cập nhật thanh toán khóa học ")

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
    $(document).ready(function() {
            datatable();
            focusActive(["user_id","course_id","pay_id","desc"]);
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
    $status=["received"=>"đã tiếp nhận","pending"=>"chờ xử lý","success"=>"thành công","error"=>"thất bại"];
@endphp

{{-- require content --}}
@section('content')

<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Cập Nhật Thanh Toán Học Viên</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Cập Nhật Thanh Toán Học Viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <form action="{{ route("admin.user.pay.course.update",$userPayCourse->id) }}" enctype="multipart/form-data" method="POST" class="block-content row" style="overflow: auto;">
                
                @csrf
                
                <div class="form-group col-12">
                    <a href="{{ route("admin.user.pay.course") }}" class="btn btn-sm btn-info"><i class="far fa-sticky-note"></i> Danh sách</a>
                    <button name="" class="btn btn-sm btn-success"><i class="fas fa-save"></i> Lưu</button>
                </div>
                <!-- user id -->
                <div class="form-group col-md-4">
                    <label for="user_id">USER:</label>
                    <input type="text" id="user_id" class="form-control" readonly value="{{ $userPayCourse->user->fullname }}">
                    <span class="icon-seach"><i class="fas fa-search"></i></span>
                </div>
                <!-- course id -->
                <div class="form-group col-md-4">
                    <label for="course_id">COURSE:</label>
                    <input type="text" id="course_id" class="form-control" readonly value="{{ $userPayCourse->course->name }}">
                    <span class="icon-seach"><i class="fas fa-search"></i></span>
                </div>
                <!-- pay id -->
                <div class="form-group col-md-4">
                    <label for="pay_id">PAY:</label>
                    <input type="text" id="pay_id" class="form-control" readonly value="{{ $userPayCourse->pay->name }}">
                    <span class="icon-seach"><i class="fas fa-search"></i></span>
                </div>
                <!-- discount -->
                <div class="form-group col-md-4">
                    <label for="discount" class="label-Unaffected">Khuyến Mãi(%)</label>
                    <input type="text"  id="discount" readonly value="{{ $userPayCourse->discount }}" class="form-control">
                </div>
                <!-- price -->
                <div class="form-group col-md-4">
                    <label for="price" class="label-Unaffected">Giá:(VNĐ)</label>
                    <input type="text" id="price" readonly value="{{ currencyFormat($userPayCourse->course->price) }}" class="form-control">
                </div>
                <!--  -->
                <div class="form-group col-md-4">
                    <label for="status" class="label-Unaffected">Trạng Thái Thanh Toán</label>
                    <select id="status" name="status" class="form-control">
                      @foreach( $status as $k=> $item )

                        <option value="{{ $k }}"
                        
                            @if($k==$userPayCourse->status)
                            
                                selected

                            @endif
                        
                        
                        >{{ $item }}</option>

                      @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection
