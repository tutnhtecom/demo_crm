<div class="modal fade" id="ti_modal_new_ticket" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-950px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 justify-content-between">
                <div class="d-flex flex-stack">
                    <!--begin::Modal title-->
                    <div class="modal-title me-10">
                        <h3 class="fs-3 fw-bold mb-0">Tạo yêu cầu</h3>
                    </div>
                    <!--end::Modal title-->
                    <ul class="nav navbar nav-pills">
                        <li class="nav-item">
                            <a class="nav-link rounded-full active" data-bs-toggle="tab"
                                href="#ti_modal_new_ticket_tab_1">Ticket không có liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link rounded-full" data-bs-toggle="tab"
                                href="#ti_modal_new_ticket_tab_2">Ticket đến liên hệ</a>
                        </li>
                    </ul>
                </div>

                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 pt-0 pb-15">
                <div class="tab-content">
                    <!--begin::Tab pane-->
                    <div class="tab-pane fade show active" id="ti_modal_new_ticket_tab_1">
                        <form id="ticket_no_contact_form" class="pt-5">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 subject_no_contact_wrapper">
                                        <label for="title" class="form-label">Chủ đề <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subject_no_contact"
                                            placeholder="Nhập chủ đề" />
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 tags_no_contact_wrapper">
                                        <label for="tag" class="form-label">Thẻ</label>
                                        <select class="form-select" data-control="select2" id="tags_no_contact"
                                            aria-label="Chọn thẻ" data-placeholder="Chọn thẻ"
                                            data-dropdown-parent="#ti_modal_new_ticket">
                                            <option></option>
                                            @foreach ($tags as $tag)
                                                <option value="{{$tag['id']}}"> {{$tag['name']}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 send_to_no_contact_wrapper">
                                        <label for="contact" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                        <input type="text" name="new_full_name" class="form-control" id="new_full_name" placeholder="Nhập Họ tên" required>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 send_to_no_contact_wrapper">
                                        <label for="contact" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="new_phone" class="form-control" id="new_phone" placeholder="Nhập Số điện thoại" required>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 send_to_no_contact_wrapper">
                                        <label for="contact" class="form-label">Email nhận thông báo <span class="text-danger">*</span></label>
                                        <input type="text" name="new_email" class="form-control" id="send_to_no_contact" placeholder="Nhập Email" required>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                {{-- <div class="col-12 col-md-6">
                                    <div class="mb-6 send_cc_no_contact_wrapper select_user_send_to_wrapper">
                                        <label for="contact" class="form-label">Chỉ định yêu cầu</label>
                                        <select data-result-template="data-result-template-1"
                                            data-label="Chọn người dùng" data-control="select2"
                                            class="form-select form-select-sm select_user_send_to" id="send_cc_no_contact" data-dropdown-parent="#ticket_no_contact_form">
                                            @foreach ($employees as $employee)
                                                <option
                                                    data-item-data='@json([
                                                        "avatar" => "assets/crm/media/svg/avatars/blank.svg",
                                                        "tag" => $employee['roles_name'],
                                                        "code" => $employee['code']
                                                    ])'
                                                    value="{{$employee['email']}}">
                                                    {{$employee['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="mb-6 content_no_contact_wrapper">
                                        <label for="content" class="form-label">Nội dung yêu cầu <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="content_no_contact" rows="3" placeholder="Nhập mô tả"></textarea>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <!--begin::Actions-->
                                    <div class="d-flex flex-end border-top py-6 gap-2">
                                        <button type="submit" id="btn_submit_ticket_no_contact"
                                            class="btn btn-primary w-150px">Tạo</button>
                                        <button type="reset" id="ti_modal_new_ticket_reset" data-bs-dismiss="modal"
                                            class="btn bg-gray-300 me-3 w-150px">Hủy</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Tab pane-->
                    <!--begin::Tab pane-->
                    <div class="tab-pane fade" id="ti_modal_new_ticket_tab_2">
                        <form id="ticket_have_contact_form" class="pt-5">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 subject_have_contact_wrapper">
                                        <label for="title" class="form-label">Chủ đề <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subject_have_contact"
                                            placeholder="Nhập chủ đề" />
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 tags_have_contact_wrapper">
                                        <label for="tag" class="form-label">Thẻ</label>
                                        <select class="form-select" data-control="select2" id="tags_have_contact"
                                            aria-label="Chọn thẻ" data-placeholder="Chọn thẻ"
                                            data-dropdown-parent="#ti_modal_new_ticket">
                                            <option></option>
                                            @foreach ($tags as $tag)
                                                <option value="{{$tag['id']}}"> {{$tag['name']}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 select_lead_have_contact_wrapper" id="select_lead_have_contact_wrapper">
                                        <label for="contact" class="form-label">Liên hệ <span class="text-danger">*</span></label>
                                        {{-- <select name="contact" id="select_lead_have_contact" class="form-select"
                                            data-control="select2" data-hide-search="true" aria-label="Chọn liên hệ"
                                            data-placeholder="Chọn liên hệ">
                                            <option value=""></option>
                                            @foreach ($dataLeads as $lead)
                                                <option value="{{$lead->email}}" data-name="{{$lead->full_name}}" data-phone="{{$lead->phone}}">{{$lead->full_name}}</option>
                                            @endforeach
                                        </select> --}}
                                        <select id="select_lead_have_contact" data-control="select2" style="width: 200px;"
                                                data-multi-checkboxes="true" data-select-all="true" class="form-select"
                                                data-placeholder="Chọn liên hệ" data-label="Chọn liên hệ" data-dropdown-parent="#select_lead_have_contact_wrapper">
                                            <option value=""></option>
                                            @foreach ($dataLeads as $lead)
                                                <option value="{{$lead->email}}" data-name="{{$lead->full_name}}" data-phone="{{$lead->phone}}">{{$lead->full_name}} - {{$lead->phone}}</option>
                                            @endforeach
                                        </select> 
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 send_cc_have_contact_wrapper select_user_send_to_wrapper">
                                        <label for="contact" class="form-label">Chỉ định yêu cầu</label>
                                        <select data-result-template="data-result-template-1" id="send_cc_have_contact"
                                            data-label="Chọn người dùng" data-control="select2"
                                            class="form-select form-select-sm" data-placeholder="Chọn">
                                            <option value=""></option>
                                            @if (isset($employees))
                                                @foreach ($employees as $employee)
                                                    <option
                                                        data-item-data='@json([
                                                            "avatar" => "assets/crm/media/svg/avatars/blank.svg",
                                                            "tag" => $employee['roles_name'],
                                                            "code" => $employee['code']
                                                        ])'
                                                        value="{{$employee['email']}}" data-id="{{$employee['id']}}">
                                                        {{$employee['name']}}
                                                    </option>
                                                @endforeach                                                
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="contact" class="form-label">Tên người nhận thông báo</label>
                                        <input type="text" class="form-control" name="notify_to_2"
                                            id="name_have_contact" placeholder="" disabled />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="contact" class="form-label">Email nhận thông báo</label>
                                        <input type="email" class="form-control" name="notify_to_2"
                                            id="send_to_have_contact" placeholder="" disabled />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-6 content_have_contact_wrapper">
                                        <label for="content" class="form-label">Nội dung yêu cầu <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="content_have_contact" rows="3" placeholder="Nhập mô tả"></textarea>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <!--begin::Actions-->
                                    <div class="d-flex flex-end border-top py-6 gap-2">
                                        <button type="submit" id="btn_submit_ticket_have_contact"
                                            class="btn btn-primary w-150px">Tạo</button>
                                        <button type="reset" id="ti_modal_new_ticket_reset_2"
                                            data-bs-dismiss="modal" class="btn bg-gray-300 me-3 w-150px">Hủy</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Tab pane-->
                </div>
                <script id="data-result-template-1" type="script/template">
                    <div class="d-flex flex-stack">
                        <!--begin::Symbol-->
                        <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                            <img src="@{{avatar}}" class="h-50 align-self-center" alt="">
                        </div>
                        <!--end::Symbol-->

                        <!--begin::Section-->
                        <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                            <!--begin:Author Tag-->
                            <span class="fs-8 text-primary text-nowrap bg-primary bg-opacity-20 rounded-full px-3 py-1" style="background-color: rgba(3, 78, 162, 0.15) !important;">@{{tag}}</span>
                            <!--end:Author Tag-->
                            <!--begin:Author-->
                            <div class="flex-grow-1 me-2">
                                <span class="text-gray-800 text-hover-primary fs-6 fw-bold">@{{item.text}}</span>

                                <span class="text-muted text-nowrap fw-semibold d-block fs-7">@{{code}}</span>
                            </div>
                            <!--end:Author-->
                        </div>
                        <!--end::Section-->
                    </div>
                </script>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
