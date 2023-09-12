@extends('admin.layout')
@section('title','Edit employees')
@section('employeeEdit')
    <style>
        .required {
            color: red;
        }
    </style>
    <div class="container">
        <div class="jumbotron">
            <a href="/admin/users" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Trở về danh sách người dùng</a>
            <br>
            <br>
            <form enctype="multipart/form-data" method="post" action="/admin/edit_user/{{$user->id}}">
                @csrf
                <div class="form-group">
                    <label for="EmployeesName">Tên người dùng <span class="required">*</span></label>
                    <input type="text" class="form-control" id="EmployeeName" name="name" placeholder="Tên người dùng" value="{{$user->name}}">
                    <span style="color:red">@error('TenNhanVien')
                        {{$message}}
                        @enderror
                </span>
                </div>
                <div class="form-group">
                    <label for="Email">Email<span class="required">*</span></label>
                    <input type="email" class="form-control" id="Email" name="email" placeholder="Email" value="{{$user->email}}">
                    <span style="color:red">@error('Email')
                        {{$message}}
                        @enderror
                </span>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu<span class="required">*</span></label><br>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu">
                    <span style="color:red">@error('password')
                        {{$message}}
                        @enderror
        </span>
                </div>
                <p>(<span class="required">*</span>) là những mục bắt buộc phải điền</p>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
    <script>
        $("input:checkbox").on('click', function() {
            var $box = $(this);
            if ($box.is(':checked')) {
                var group = "input:checkbox[name ='" + $box.attr("name") + "']";
                $(group).prop('checked', false);
                $box.prop('checked', true);
            } else {
                $box.prop('checked', false);
            }
        })
    </script>
@endsection
