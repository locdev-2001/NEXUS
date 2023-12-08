@foreach($posts as $post)
    <tr>
        <td style="vertical-align:middle; text-align:center">
            <input type="checkbox" data-id="{{$post->id}}" class="checkBoxItem">
        </td>
        <td style="vertical-align:middle; text-align:center">{{$post->id}}</td>
        <td style="vertical-align:middle; text-align:center">{{$post->user->name}}</td>
        <td style="vertical-align:middle; text-align:center">{{$post->content_text}}</td>
        <?php
        $trangthai = "";
        if ($post->post_mode == 1) {
            $trangthai = "Công khai";
        } elseif($post->post_mode ==2) {
            $trangthai = "Bạn bè";
        }
        else{
            $trangthai= "Chỉ mình tôi";
        }
        ?>
        <td style="vertical-align:middle; text-align:center">{{$trangthai}}</td>
        <td style="vertical-align:middle; text-align:center">{{$post->created_at}}</td>
        <td style="vertical-align:middle; text-align:center">{{$post->updated_at}}</td>
        <td style="vertical-align:middle; text-align:center">
            <button type="button" class="btn btn-danger deleteEquipmentBtn" value="{{$post->id}}">Xoá</button>
        </td>
    </tr>
@endforeach
<script>
    $(document).ready(function() {
        $('.deleteEquipmentBtn').on('click', function(e) {
            e.preventDefault();
            var customer_id = $(this).val();
            var customer_name = $(this).data('customer_name');
            var customer_address = $(this).data('address');
            var customer_takeNote = $(this).data('take_note');
            $('#customer_name').html(customer_name);
            $('#customer_address').html(customer_address);
            $('#customer_takeNote').html(customer_takeNote);
            $('#confirm_delete').attr('href', 'delete_post/' + customer_id);
            $('#deleteCustomerModal').modal('show');
        })

        const checkAllCheckBox = $('#checkAll');
        const checkBoxItems = $('.checkBoxItem');
        checkAllCheckBox.on('change',function(){
            checkBoxItems.prop('checked',checkAllCheckBox.prop('checked'))
        })
        checkBoxItems.on('change', function() {
            // Uncheck the "Check All" checkbox if any of the checkBoxItems is unchecked
            if (!this.checked) {
                checkAllCheckBox.prop('checked', false);
            }
            // Check the "Check All" checkbox if all checkBoxItems are checked
            else if ($('.checkBoxItem:checked').length === checkBoxItems.length) {
                checkAllCheckBox.prop('checked', true);
            }
        });
        $('.addMail').on('click',function(e){
            e.preventDefault();
            const checkedCheckBox = $('.checkBoxItem:checked');
            const customerName = $('#customerName');
            if(checkedCheckBox.length == 0){
                customerName.empty();
                customerName.append(`<option class="select2-results__option" value="`+ $(this).val() +`">`+ $(this).data('customer_name') +`</option>`)
                $('#addMailCustomerModal').modal('show');
            }
            else{
                const userIds = checkedCheckBox.map(function(){
                    return $(this).data('id')
                }).get()
                $.ajax({
                    type:'get',
                    url:'/get-users-by-id',
                    data:{
                        user_ids:userIds
                    },
                    success:function(data){
                        console.log(data.users)
                        customerName.empty();
                        data.users.forEach(function(user){
                            customerName.append(`<option class="select2-results__option" value="`+ user.id +`">`+ user.customer_name +`</option>`)
                        })
                        $('#addMailCustomerModal').modal('show');
                    }
                })
            }

        })
    })
</script>
