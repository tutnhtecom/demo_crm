<div class="modal fade" id="editStatusModal{{$status['id']}}" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-bottom justify-content-between">
                <!--begin::Title-->
                <h2 class="fw-bolder m-0">Sửa Nguồn tiếp cận</h2>
                <!--end::Title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary fs-2" data-bs-dismiss="modal">
                    &times;
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Form-->
            <form id="ti_form_edit_sources{{$status['id']}}" novalidate="novalidate" class="text-start">
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label">Tên Nguồn tiếp cận</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input id="input_edit_sources_name_{{$status['id']}}" type="text" value="{{$status['name']}}" class="form-control" name="status_name"
                            placeholder="Nhập tên Nguồn tiếp cận" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="card-footer d-flex gap-4 justify-content-center p-4">
                    <button type="button" class="btn btn-primary btn_edit_sources" data-id="{{$status['id']}}">Lưu thay đổi</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-light">Hủy</button>
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
