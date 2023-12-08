<div>
    <div class="d-flex justify-content-between align-content-center mb-2">
        <div class="d-flex">
            <div>
                <div class="d-flex align-items-center ml-4">
                    <label for="paginate" class="text-nowrap mr-2 mb-0">Số hàng</label>
                    <select wire:model="paginate" name="paginates" id="paginates" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>
            <div>
{{--                <div class="d-flex align-items-center ml-4">--}}
{{--                    <label for="paginate" class="text-nowrap mr-2 mb-0">FilterBy Class</label>--}}
{{--                    <select class="form-control form-control-sm" >--}}
{{--                        <option value="">All Class</option>--}}
{{--                        @foreach ($classes as $item)--}}
{{--                            <option value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                            <option value="">something</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
            </div>

{{--            @if ($selectedClass != 0 && !is_null($selectedClass))--}}
{{--                <div>--}}
{{--                    <div class="d-flex align-items-center ml-4">--}}
{{--                        <label for="paginate" class="text-nowrap mr-2 mb-0">Section</label>--}}
{{--                        <select class="form-control form-control-sm" wire:model="selectedSection">--}}
{{--                            <option value="">Select a Section</option>--}}
{{--                            @foreach ($sections as $item)--}}
{{--                                <option value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
            <div>
                @if ($checked)
                    <div class="dropdown ml-4">
                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Đã Check ({{ count($checked) }})</button>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item" type="button"
                               onclick="confirm('Bạn có chắc chắn muốn xóa các người dùng này?') || event.stopImmediatePropagation()"
                               wire:click="deleteRecords()">
                                Xóa
                            </a>
                            <a href="#" class="dropdown-item" type="button"
                               onclick="confirm('Bạn có chắc chắn muốn khóa tài khoản các người dùng này?') || event.stopImmediatePropagation()"
                               wire:click="deActiveUsers()">
                                Khóa tài khoản
                            </a>
                            <a href="#" class="dropdown-item" type="button"
                               onclick="confirm('Bạn có chắc chắn muốn mở khóa tài khoản các người dùng này?') || event.stopImmediatePropagation()"
                               wire:click="activeUsers()">
                                Mở khóa tài khoản
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class=" col-md-4">
            <input type="search" wire:model.debounce.500ms="search" class="form-control"
                   placeholder="Tìm tên hoặc địa chỉ email...">
        </div>
    </div>
    <div class="col-md-10 mt-3">
        @include('admin.flash_message')
    </div>
    <br>
    @if ($selectPage)
        <div class="col-md-10 mb-2">
            @if ($selectAll)
                <div>
                    You have selected all <strong>{{ $users->total() }}</strong> items.
                </div>
            @else
                <div>
                    You have selected <strong>{{ count($checked) }}</strong> items, Do you want to Select All
                    <strong>{{ $users->total() }}</strong>?
                    <a href="#" class="ml-2" wire:click="selectAll">Select All</a>
                </div>
            @endif

        </div>
    @endif


    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <tbody>
            <tr>
                <th><input type="checkbox" wire:model="selectPage"></th>
                <th>Tên người dùng</th>
                <th>Ảnh đại diện</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>Cảnh báo</th>
                <th>Tạm Khóa</th>
                <th>Chỉnh sửa</th>
                <th>Xóa</th>
            </tr>
            @foreach($users as $user)
                <tr class="@if ($this->isChecked($user->id))table-primary @endif">
                    <td><input type="checkbox" value="{{ $user->id }}" wire:model="checked"></td>
                    <td>{{ $user->name }}</td>
                    <td><img width="60px" src="{{ asset($user->profile->avatar) }}" alt=""></td>
                    <td>{{ $user->email }}</td>
                    <td>@if ($user->active == 1) Đang kích hoạt @else Tạm khóa @endif</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()
                                "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-square-fill" viewBox="0 0 16 16">
                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg></button>
                    </td>
                    <td>
                        @if($user->active == 1)
                            <button wire:click="deActiveSingleUser({{$user->id}})" class="btn btn-outline-primary btn-sm"
                                    onclick="confirm('Bạn có chắc chắn muốn khóa người dùng này?') || event.stopImmediatePropagation()
                                "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
                                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"/>
                                </svg></button>
                        @else
                            <button class="btn btn-primary btn-sm" wire:click="activeSingleUser({{$user->id}})"
                                    onclick="confirm('Bạn có muốn mở khóa người dùng này?') || event.stopImmediatePropagation()
                                "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                </svg></button>
                        @endif

                    </td>
                    <td>
                        <button class="btn btn-success btn-sm" wire:click="editUser({{$user->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg></button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                                onclick="confirm('Bạn có chắc chắn muốn xóa {{$user->name}}') || event.stopImmediatePropagation()"
                                wire:click="deleteSingleRecord({{ $user->id }})"><i class="fa fa-trash"
                                                                                       aria-hidden="true"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="row mt-4">
        <div class="col-sm-6 offset-5">
            {{ $users->links() }}
        </div>
    </div>
</div>
