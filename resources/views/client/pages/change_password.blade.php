@extends('client.pages.layout')
@section('main-content')
    <div class="col-md-6 offset-md-3">
        <span class="anchor" id="formChangePassword"></span>
        <!-- form card change password -->
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Thay đổi mật khẩu</h3>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" action="changePassword" method="POST">
                    @csrf
{{--                    <div class="form-group mb-2">--}}
{{--                        <label for="inputPasswordOld">Mật khẩu hiện tại</label>--}}
{{--                        @error('old_password')--}}
{{--                        <span class="v-errors">{{$message}}</span>--}}
{{--                        @enderror--}}
{{--                        <input type="password" class="form-control" name="old_password" id="inputPasswordOld" required="">--}}
{{--                    </div>--}}
                    <div class="form-group mb-2">
                        <label for="inputPasswordNew">Nhập mật khẩu mới</label>
                        @error('new_password')
                        <span class="form-text small text-danger">{{$message}}</span>
                        @enderror
                        <input type="password" class="form-control" name="new_password" id="inputPasswordNew">
                        <span class="form-text small text-muted">Mật khẩu phải từ 8-12 ký tự, phải chứa ít nhất một ký tự viết hoa, một số và một ký tự đặc biệt.</span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="inputPasswordNewVerify">Nhập lại mật khẩu mới</label>
                        @error('confirm_password')
                        <span class="form-text small text-danger">{{$message}}</span>
                        @enderror
                        <input type="password" class="form-control" name="confirm_password" id="inputPasswordNewVerify">
                        <span class="form-text small text-muted">Nhập lại mật khẩu mới để xác nhận</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /form card change password -->

    </div>
@endsection
