@extends('admin.layout')
@section('title', 'Employees')

@section('employees')

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <div class="container-fluid">
        <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Xóa người dùng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="employee_delete_id" id="employee_id">
                        <h5>Bạn có chắc chắn muốn xóa người dùng <span id="name_employee"></span> ?</h5>
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
{{--            <div class="col-md-3">--}}
{{--                <input type="text" name="search" id="search" class="form-control" placeholder="Search name" />--}}
{{--            </div>--}}
            <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <style>
                    .pagination {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                </style>
                <thead>
                <tr>
                    <th class="th-sm sorting" data-sorting_type="desc" data-column_name="id" style="cursor:pointer">ID
                        <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                    </th>
                    <th class="th-sm sorting" style="cursor:pointer" data-sorting_type="asc" data-column_name="tennhanvien">Tên người dùng

                        <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                    </th>
                    <th class="th-sm">Avatar</th>
                    <th class="th-sm">Email
                    </th>
                    <th class="th-sm sorting" style="cursor:pointer" data-sorting_type="desc" data-column_name="created_at">Created At
                        <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                    </th>
                    <th class="th-sm sorting" style="cursor:pointer" data-sorting_type="asc" data-column_name="updated_at">Updated At
                        <span style="color:#3498DB; float:right;"><i class="fa fa-sort" aria-hidden="true"></i></span>
                    </th>
                    <th class="th-sm">Chỉnh sửa
                    </th>
                    <th class="th-sm">Xóa
                    </th>
                </tr>
                </thead>
                <tbody>
                @include('admin.pagination_data')
                </tbody>
            </table>
            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
            <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="created_at" />
            <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
        </div>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').remove();
            }, 3000);

            function fetch_data(page, sort_type, sort_by, query) {
                $.ajax({
                    url: "/users/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query,
                    success: function(data) {
                        $('tbody').html('');
                        $('tbody').html(data);
                    }
                })
            }
            $(document).on('keyup', '#search', function() {
                var query = $('#search').val();
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var page = $('#hidden_page').val();
                fetch_data(page, sort_type, column_name, query);
            })
            $(document).on('click', '.sorting', function() {
                var column_name = $(this).data('column_name');
                var order_type = $(this).data('sorting_type');
                var reverse_order = '';
                if (order_type == 'asc') {
                    $(this).data('sorting_type', 'desc');
                    reverse_order = 'desc';
                }
                if (order_type == 'desc') {
                    $(this).data('sorting_type', 'asc');
                    reverse_order = 'asc';
                }
                $('#hidden_column_name').val(column_name);
                $('#hidden_sort_type').val(reverse_order);
                var page = $('#hidden_page').val();
                var query = $('#search').val();
                fetch_data(page, reverse_order, column_name, query);
            });
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var query = $('#search').val();
                $('.page-item').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, sort_type, column_name, query);
            });
            $(document).on('click', '.pagination span', function(event) {
                event.preventDefault();
                var page = $(this).val();
                $('#hidden_page').val(page);
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var query = $('#search').val();
                $('.page-item').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, sort_type, column_name, query);
            })
        })
    </script>
@endsection
