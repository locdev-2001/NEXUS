@extends('admin.layout')
@section('title','Bài viết')
@section('customer')
    <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Xóa bài viết</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="employee_delete_id" id="employee_id">
                    <h5>Bạn có chắc chắn muốn xóa bài viết này
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <a href="" class="btn btn-danger" id="confirm_delete">Xóa</a>
                </div>
            </div>
        </div>
    </div>
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session()->get('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
{{--        <div class="col-md-3">--}}
{{--            <input type="text" name="search" id="search" class="form-control" placeholder="Search name, model, description">--}}
{{--        </div>--}}
        <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm" style="cursor:pointer">All
                    <input type="checkbox" id="checkAll">
                </th>
                <th class="th-sm sorting" data-column_name='id' data-sort_type='desc' style="cursor:pointer">ID
                    <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                </th>
                <th class="th-sm sorting" data-column_name='customer_name' data-sort_type='asc' style="cursor:pointer">Người đăng
                    <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                </th>
                <th class="th-sm">Nội dung</th>
                <th class="th-sm">Chế độ</th>
                <th class="th-sm sorting" data-column_name='created_at' data-sort_type='desc' style="cursor:pointer">Created At
                    <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                </th>
                <th class="th-sm sorting" data-column_name='updated_at' data-sort_type='asc' style="cursor:pointer">Updated At
                    <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                </th>
                <th class="th-sm">Xóa</th>
            </tr>
            </thead>
            <tbody>
            @include('admin.postPagination_data')
            </tbody>
        </table>
        <input type="hidden" name="hidden-column_name" id="hidden-column_name" value='created_at'>
        <input type="hidden" name="hidden-sort_type" id="hidden-sort_type" value='desc'>
        <input type="hidden" name='hidden-page' id='hidden-page' value='1'>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').remove();
            }, 3000);

            function fetch_data(page, sort_by, sort_type, query) {
                $.ajax({
                    url: "/customer/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query,
                    success: function(data) {
                        $('tbody').html('');
                        $('tbody').html(data);
                    }
                })
            }
            $(document).on('keyup', '#search', function() {
                var query = $('#search').val();
                var page = $('#hidden-page').val();
                var column_name = $('#hidden-column_name').val();
                var sort_type = $('#hidden-sort_type').val();
                fetch_data(page, column_name, sort_type, query);
            })
            $(document).on('click', '.sorting', function() {
                var column_name = $(this).data('column_name');
                var sort_type = $(this).data('sort_type');
                var reverse_sort_type = '';
                if (sort_type == 'asc') {
                    $(this).data('sort_type', 'desc');
                    reverse_sort_type = 'desc';
                }
                if (sort_type == 'desc') {
                    $(this).data('sort_type', 'asc');
                    reverse_sort_type = 'asc';
                }
                $('#hidden-column_name').val(column_name);
                $('#hidden-sort_type').val(reverse_sort_type);
                var page = $('#hidden-page').val();
                var query = $('#search').val();
                fetch_data(page, column_name, reverse_sort_type, query);
            })
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden-page').val(page);
                var column_name = $('#hidden-column_name').val();
                var sort_type = $('#hidden-sort_type').val();
                var query = $('#search').val();
                $('.page-item').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, column_name, sort_type, query);
            })
            $(document).on('click', '.pagination span', function(event) {
                event.preventDefault();
                var page = $(this).val();
                $('#hidden-page').val(page);
                var column_name = $('#hidden-column_name').val();
                var sort_type = $('#hidden-sort_type').val();
                var query = $('#search').val();
                $('.page-item').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, column_name, sort_type, query);
            })
            $('#addMailConfirm').on('click',function (e){
                e.preventDefault();
                const user_id = $('#customerName').val();
                const mail = $('#newMail').val();
                let csrfToken = jQuery('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type:"POST",
                    url:'/newMail',
                    headers:{
                        'X-CSRF-TOKEN':csrfToken
                    },
                    data:{
                        user_id:user_id,
                        mail:mail
                    },
                    success:function(res){
                        $('td[data-id="'+res.Customer_id+'"]').empty()
                        $('td[data-id="'+res.Customer_id+'"]').append(res.Mail)
                    }
                })
            })
        });
    </script>
@endsection
