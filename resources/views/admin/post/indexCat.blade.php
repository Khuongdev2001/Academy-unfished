@extends("layouts.admin")
{{-- require css --}}
@section('css')

    <link rel="stylesheet" href="{{ asset('plugin/datatable/css/table.css') }}">

@endsection

{{-- require js --}}
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    {{-- auto open modal add cat  --}}

    @if ($errors->any())
        jQuery('#post').modal('show');
    @endif

    {{-- auto open model update cat --}}

    @if(isset($catDb))
        jQuery('#post').modal('show');
    @endif




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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Danh mục Bài Viết</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Firs Pi Project</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh mục Bài Viết</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div id="content" class="p-2">
        <div class="block block-rounded p-2">
            <div class="actions user action-all">
                <!-- trash: thùng rác -->
                <a href="" type="button" class="btn-action btn-hero-warning btn-trash mr-2">
                    <i class="far fa-trash-alt"></i>
                    <span class="label">{{$static["index"]}}</span>
                </a>
                <!-- btn-add:thêm phòng -->
                <a href="" data-toggle="modal" data-target="#post" type="button" class="btn-action btn-hero-dark btn-add">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <table class="text-center table w-100 table-bordered table-vcenter js-dataTable-full datable no-footer display nowrap dataTable dtr-inline collapsed" id="example" role="grid">
                <thead>
                    <tr id="header-row">
                        <th class="no-sort" style="width: 10px;">STT</th>
                        <th class="no-sort">Tiêu đề</th>
                        <th class="no-sort">Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th class="no-sort">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $temp=0;
                    @endphp
                    @if(count($cats))
                    @foreach($cats as $cat)
                        <tr>
                            <td>{{ ++ $temp }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $cat->created_at }}</td>
                            <td>{{ $status[$cat->status] }}</td>
                            <td><a href="{{route("admin.post.cat.update",$cat->id)}}" class="btn-update btn btn-sm btn-success" user="4"><i class="fas fa-pen"></i></a>
                                <a href="{{route("admin.post.cat.delete",$cat->id)}}" id="" class="btn-delete btn btn-sm btn-danger ml-1" user="4"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    @else

                    <tr>
                        <td colspan="9" class="text-warning-light" >Hiện chưa có danh mục bài viết nào trong bảng nay</td>
                    </tr>
                        
                    @endif  
                </tbody>
            </table>
        </div>
    </div>
</main>

{{-- modal add cat  post  --}}

<div class="modal fade" id="post" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
      <div class="modal-content" id="registermodal">
        <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
        <div class="modal-body">
            <h4 class="modal-header-title">{{ isset($catDb) ? "Cập nhật danh mục":"Thêm Danh Mục Bài Viết" }}</h4>
          <div class="login-form">
            <form method="POST" action="{{ isset($catDb) ? route("admin.post.cat.update",$catDb->id) : route("admin.post.cat.add") }}"  class="block-content">

                @csrf

                <div id="content-body" class="row my-4">
                    <div class="form-group col-md-12">
                        <label for="name" class="label-Unaffected">Danh mục: *</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old("name") ??$catDb->name??''}} ">
                        @error('name')
                            <small class="error">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="parent_id" class="label-Unaffected">Danh mục cha: </label>
                        <select name="parent_id" id="parent_id" class="form-control">
                                <option value="0">Danh Mục Cha</option>
                            @foreach($cats as $cat)
                                @php
                                    if(isset($catDb) && $cat->id==$catDb->id)
                                        continue
                                @endphp
                            <option value="{{$cat->id}}"

                                {{-- seclected  cat --}}
                                @if(isset($catDb) && $catDb->parent_id==$cat->id )

                                    selected

                                @endif


                            >{{$cat->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="status" class="label-Unaffected" >Trang thái</label>
                        <select name="status" id="status" class="form-control">
                            @foreach($status as $k=> $status)
                            <option value="{{$k}}"
                                {{-- seclected  status --}}
                                @if(isset($catDb) && $catDb->status==$k)

                                    selected

                                @endif

                        >       {{$status}}
                            </option>
                                @endforeach
                        </select>

                    </div>
                        
                    <div class="form-group col-12">
                        <button class="btn btn-hero-sm btn-hero-success">
                            <i class="fas fa-save"></i>
                            Lưu
                        </button>

                        <a href="{{route("admin.post.cat.add")}}" class="btn btn-hero-sm btn-hero-info">
                            <i class="fas fa-plug"></i>
                            Chuyển qua Thêm
                        </a>

                    </div>
                </div>
            </form>
          </div>
      </div>
    </div>
  </div>
  <!-- End Modal -->

@endsection
