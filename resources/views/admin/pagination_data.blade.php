@foreach($users as $user)
    <tr>
        <td style="vertical-align:middle; text-align:center">{{$user->id}}</td>
        <td style="vertical-align:middle; text-align:center">{{$user->name}}</td>
        <td style="display:flex;justify-content:center;align-items:center;">
            <img style="width:5rem;" src="{{asset($user->profile->avatar)}}" alt="">
        </td>
        <td style="vertical-align:middle; text-align:center">{{$user->email}}</td>
        <td style="vertical-align:middle; text-align:center">{{$user->created_at}}</td>
        <td style="vertical-align:middle; text-align:center">{{$user->updated_at}}</td>
        <td style="vertical-align:middle; text-align:center"><a href="edit_user/{{$user->id}}" class="btn btn-success">Chỉnh sửa</a></td>
        <td style="vertical-align:middle; text-align:center">
            <button type="button" class="btn btn-danger deleteEmployeeBtn" value="{{$user->id}}" data-name_employee="{{$user->name}}">Xóa</button>
        </td>
    </tr>
@endforeach
<tr>
    {!! $users->links() !!}
</tr>
<script>
    $(document).ready(function() {
        $('.deleteEmployeeBtn').click(function(e) {
            e.preventDefault();
            var employee_id = $(this).val();
            var employee_name = $(this).data('name_employee');
            $('#employee_id').val(employee_id);
            $('#confirm_delete').attr('href', 'delete/' + employee_id);
            $('#name_employee').html(employee_name);
            $('#deleteEmployeeModal').modal('show');
        })
    })
</script>
