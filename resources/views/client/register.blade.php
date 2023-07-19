<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('storage/client/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('storage/client/css/style.css')}}">
    <link rel="icon" href="{{asset('storage/client/images/logo/logo.svg')}}">
    <title>NEXUS</title>
</head>
<body>



<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{asset('storage/uploads/undraw_remotely_2j6y.svg')}}" alt="main-logo" class="img-fluid">
            </div>
            <div class="col-md-6 contents">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-4 text-center">
                            <h3>Đăng ký tài khoản</h3>
                            <div class="welcome d-flex justify-content-center align-items-center mb-4 gap-2">
                                <p class="d-inline m-0">Chào mừng bạn đến với</p><img src="{{asset('storage/client/images/logo/welcome-logo.png')}}" alt="">
                            </div>
                        </div>
                        <form action="/register" method="POST">
                            @csrf
                            <div class="form-group first mb-4">
                                <label for="name">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Họ và tên">
                            </div>
                            @error('name')
                            <span class="v-errors">{{$message}}</span>
                            @enderror
                            <div class="form-group first mb-4">
                                <label for="email">Địa chỉ email example@gmail.com</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com">
                            </div>
                            @error('email')
                            <span class="v-errors">{{$message}}</span>
                            @enderror
                            <div class="form-group last mb-4">
                                <label for="password">Mật khẩu 8-12 ký tự</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="no" placeholder="Vui lòng nhập mật khẩu">
                                <span class="show-password"><i class="icon-eye"></i></span>
                            </div>
                            @error('password')
                            <span class="v-errors">{{$message}}</span>
                            @enderror
                            <div class="form-group last mb-4">
                                <label for="password">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="passwordConfirmation" name="passwordConfirmation" autocomplete="no" placeholder="Nhập lại mật khẩu">
                                <span class="show-password"><i class="icon-eye"></i></span>
                            </div>
                            @error('passwordConfirmation')
                            <span class="v-errors">{{$message}}</span>
                            @enderror
                            <input type="submit" value="Đăng ký" class="btn btn-block btn-primary w-100">
                            <span class="d-block text-center my-4 text-muted">&mdash; Hoặc tiếp tục với &mdash;</span>

                            <div class="social-login d-flex align-items-center justify-content-center">
                                <a href="#" class="facebook mx-2">
                                    <span class="icon-facebook mr-3"></span>
                                </a>
                                <a href="#" class="twitter mx-2">
                                    <span class="icon-twitter mr-3"></span>
                                </a>
                                <a href="#" class="google mx-2">
                                    <span class="icon-google mr-3"></span>
                                </a>
                            </div>
                        </form>
                    </div>
                    <span class="text-center">Đã có tài khoản <a href="/login" class="register">Đăng nhập</a></span>
                </div>

            </div>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--<script src="js/popper.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('storage/client/js/main.js')}}"></script>
</body>
</html>
