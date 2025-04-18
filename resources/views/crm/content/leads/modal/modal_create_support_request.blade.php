<div class="modal fade" id="ti_modal_new_ticket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header pb-0 justify-content-between">
                <div class="d-flex flex-stack">
                    <div class="modal-title me-10">
                        <h3 class="fs-3 fw-bold mb-0">Tạo yêu cầu</h3>
                    </div>
                    <ul class="nav navbar nav-pills">
                        <li class="nav-item">
                            <a class="nav-link rounded-full active" data-bs-toggle="tab"
                                href="#ti_modal_new_ticket_tab_2">Ticket đến liên hệ</a>
                        </li>
                    </ul>
                </div>

                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 pt-0 pb-15">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="ti_modal_new_ticket_tab_2">
                        <form id="ticket_have_contact_form" class="pt-5">
                            <div class="row">

                                <div class="col-12 col-md-6">
                                    <div class="mb-6 subject_have_contact_wrapper">
                                        <label for="title" class="form-label">Chủ đề <span
                                                class="text-danger">*</span></label>
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
                                                <option value="{{ $tag['id'] }}"> {{ $tag['name'] }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mb-6 name_have_contact_wrapper"
                                        id="name_have_contact_wrapper">
                                        <label for="contact" class="form-label">Liên hệ <span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$dataId->full_name}}" class="form-control" name="notify_to_2"
                                                id="name_have_contact" placeholder="" disabled />
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mb-6 send_cc_have_contact_wrapper select_user_send_to_wrapper">
                                        <label for="contact" class="form-label">Chỉ định yêu cầu</label>
                                        
                                        <input type="text" value="{{$dataId->employees->name ?? null}}" data-email="{{$dataId->employees->email ?? null}}" class="form-control" name="notify_to_2"
                                                id="send_cc_have_contact" placeholder="" disabled />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="contact" class="form-label">Số điện thoại</label>
                                        <input type="text" value="{{$dataId->phone ?? null}}" class="form-control" name="notify_to_2"
                                                id="select_lead_have_contact" placeholder="" disabled />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="contact" class="form-label">Email nhận thông báo</label>
                                        <input type="text" value="{{$dataId->email ?? null}}" class="form-control" name="notify_to_2"
                                                id="send_to_have_contact" placeholder="" disabled />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-6 content_have_contact_wrapper">
                                        <label for="content" class="form-label">Nội dung yêu cầu <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="content_have_contact" rows="3" placeholder="Nhập mô tả"></textarea>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="d-flex flex-end border-top py-6 gap-2">
                                        <button type="submit" id="btn_submit_ticket_have_contact"
                                            class="btn btn-primary w-150px">Tạo</button>
                                        <button type="reset" id="ti_modal_new_ticket_reset_2"
                                            data-bs-dismiss="modal" class="btn bg-gray-300 me-3 w-150px">Hủy</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module" src="/assets/crm/js/htecomJs/send_request_support.js"></script>

