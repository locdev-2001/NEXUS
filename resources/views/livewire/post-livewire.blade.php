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
                               onclick="confirm('Bạn có chắc chắn muốn xóa các bài viết này') || event.stopImmediatePropagation()"
                               wire:click="deleteRecords()">
                                Xóa
                            </a>
                            <a href="#" class="dropdown-item" type="button"
                               onclick="confirm('Bạn có chắc chắn muốn khóa các bài viết này') || event.stopImmediatePropagation()"
                               wire:click="lockPosts()">
                                Khóa bài viết
                            </a>
                            <a href="#" class="dropdown-item" type="button"
                               onclick="confirm('Bạn có chắc chắn muốn mở khóa các bài viết này') || event.stopImmediatePropagation()"
                               wire:click="unlockPosts()">
                                Mở khóa bài viết
                            </a>
                            <a href="#" class="dropdown-item" type="button"
                               onclick="confirm('Bạn có chắc chắn muốn duyệt các bài viết này') || event.stopImmediatePropagation()"
                               wire:click="activePosts()">
                                Duyệt bài viết
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class=" col-md-4">
            <input type="search" wire:model.debounce.500ms="search" class="form-control"
                   placeholder="Tìm theo nội dung...">
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
                    You have selected all <strong>{{ $posts->total() }}</strong> items.
                </div>
            @else
                <div>
                    You have selected <strong>{{ count($checked) }}</strong> items, Do you want to Select All
                    <strong>{{ $posts->total() }}</strong>?
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
                <th>Nội dung</th>
                <th>Chế độ</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>Xem</th>
                <th>Duyệt</th>
                <th>Khóa</th>
                <th>Xóa</th>
            </tr>
            @foreach($posts as $post)
                <tr class="@if ($this->isChecked($post->id))table-primary @endif">
                    <td><input type="checkbox" value="{{ $post->id }}" wire:model="checked"></td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{$post->content_text}}</td>
                    <td>@if($post->post_mode == 1) Công khai <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-asia-australia" viewBox="0 0 16 16">
                            <path d="m10.495 6.92 1.278-.619a.483.483 0 0 0 .126-.782c-.252-.244-.682-.139-.932.107-.23.226-.513.373-.816.53l-.102.054c-.338.178-.264.626.1.736a.476.476 0 0 0 .346-.027ZM7.741 9.808V9.78a.413.413 0 1 1 .783.183l-.22.443a.602.602 0 0 1-.12.167l-.193.185a.36.36 0 1 1-.5-.516l.112-.108a.453.453 0 0 0 .138-.326ZM5.672 12.5l.482.233A.386.386 0 1 0 6.32 12h-.416a.702.702 0 0 1-.419-.139l-.277-.206a.302.302 0 1 0-.298.52l.761.325Z"/>
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM1.612 10.867l.756-1.288a1 1 0 0 1 1.545-.225l1.074 1.005a.986.986 0 0 0 1.36-.011l.038-.037a.882.882 0 0 0 .26-.755c-.075-.548.37-1.033.92-1.099.728-.086 1.587-.324 1.728-.957.086-.386-.114-.83-.361-1.2-.207-.312 0-.8.374-.8.123 0 .24-.055.318-.15l.393-.474c.196-.237.491-.368.797-.403.554-.064 1.407-.277 1.583-.973.098-.391-.192-.634-.484-.88-.254-.212-.51-.426-.515-.741a6.998 6.998 0 0 1 3.425 7.692 1.015 1.015 0 0 0-.087-.063l-.316-.204a1 1 0 0 0-.977-.06l-.169.082a1 1 0 0 1-.741.051l-1.021-.329A1 1 0 0 0 11.205 9h-.165a1 1 0 0 0-.945.674l-.172.499a1 1 0 0 1-.404.514l-.802.518a1 1 0 0 0-.458.84v.455a1 1 0 0 0 1 1h.257a1 1 0 0 1 .542.16l.762.49a.998.998 0 0 0 .283.126 7.001 7.001 0 0 1-9.49-3.409Z"/>
                        </svg>  @elseif($post->post_mode == 2) Bạn bè <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                        </svg> @else Chỉ mình tôi <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-lock2-fill" viewBox="0 0 16 16">
                            <path d="M7 6a1 1 0 0 1 2 0v1H7V6z"/>
                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-2 6v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V8.3c0-.627.46-1.058 1-1.224V6a2 2 0 1 1 4 0z"/>
                        </svg> @endif</td>
                    <td>@if ($post->active == 1) Đã duyệt @elseif($post->active==2) Tạm khóa @else Đợi duyệt @endif</td>
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->updated_at }}</td>
{{--                    xem--}}
                    <td><button class="btn btn-secondary btn-sm" wire:click="reviewPost({{$post->id}})">Xem <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg></button></td>
                    <td>
                        @if($post->active == 0)
{{--                            duyệt single checked--}}
                        <button class="btn btn-primary btn-sm" wire:click="activeSinglePost({{$post->id}})"
                                onclick="confirm('Duyệt bài viết này') || event.stopImmediatePropagation()
                                ">Duyệt bài viết <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-square-fill" viewBox="0 0 16 16">
                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg></button>
                        @elseif($post->active==1 || $post->active==2)
{{--                            đã duyệt checked--}}
                            <button class="btn btn-light btn-sm" disabled>Đã duyệt <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
                                </svg></button>
                        @endif
                    </td>
                    <td>
                        @if($post->active == 1)
{{--                            Khóa --}}
                            <button wire:click="lockSinglePost({{$post->id}})" class="btn btn-outline-primary btn-sm"
                                    onclick="confirm('Bạn có chắc chắn muốn khóa bài viết này?') || event.stopImmediatePropagation()
                                "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
                                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"/>
                                </svg></button>
                        @elseif($post->active==2)
{{--                            mở khóa--}}
                            <button class="btn btn-primary btn-sm" wire:click="activeSinglePost({{$post->id}})"
                                    onclick="confirm('Bạn có muốn mở khóa bài viết này?') || event.stopImmediatePropagation()
                                "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                </svg></button>
                        @endif

                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                                onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này') || event.stopImmediatePropagation()"
                                wire:click="deleteSingleRecord({{ $post->id }})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="row mt-4">
        <div class="col-sm-6 offset-5">
            {{ $posts->links() }}
        </div>
    </div>
</div>

