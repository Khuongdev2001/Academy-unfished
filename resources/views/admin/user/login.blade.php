@extends("layouts.admin")
@section('title', 'Đăng Nhập')

@section('header')   
@endsection

@section('slidebar')   
@endsection

@section('footer')    
@endsection

{{-- require css --}}
@section('css')
<style>
    body {
        background: url({{asset('system/img/login.jpg')}});
        background-size: cover;
    }

    #main-container .hero-static {
        width: 350px;
        margin: 70px auto;
        box-shadow: 0px 0px 5px #0000001f;
        border-radius: 2px;
    }

    #main-container .hero-static {
        min-height: 400px;
    }
</style>    
@endsection
{{-- require js --}}
@section('js')
    <script>
         focusActive(['email', 'password']);
    </script>
@endsection

@section('content')
<main id="main-container">
    <div class="bg-image">
        <div class="hero-static d-flex bg-white js-appear-enabled animated bounceIn">
            <div class="p-3 w-100">
                <div class="mb-3 text-center">
                    <a class="link-fx font-w700 font-size-h1" href="index.html">
                        <span class="text-dark">Aca </span><span class="text-primary">demy</span>
                    </a>
                    <p class="text-uppercase font-w700 font-size-sm text-muted">Đăng nhập</p>
                </div>
                <form action="{{route("admin.user.login")}}" method="POST">
                    {{-- chống hack form nguồn ngoài --}}
                    @csrf
                    <div class="py-3">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}">
                            @error('email')
                                <small class="error">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <small class="error">{{$message}}</small>
                            @enderror
                        </div>
                        {{-- thông báo lỗi khi sai email mk --}}
                        @if(session('error'))
                            <small class="error text-danger font-weight-bold my-2 d-block">{{session('error')}}</small>
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-sm btn-primary">
                                <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>    
@endsection

