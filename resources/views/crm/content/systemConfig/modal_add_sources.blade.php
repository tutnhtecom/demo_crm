<div class="modal fade" id="ti_modal_add_sources" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-bottom justify-content-between">
                <!--begin::Title-->
                <h2 class="fw-bolder m-0">Thêm mới</h2>
                <!--end::Title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary fs-2" data-bs-dismiss="modal">
                    &times;
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Form-->
            <form id="ti_form_add_sources" novalidate="novalidate">
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label">Tên Nguồn tiếp cận</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input id="input_sources_name" type="text" class="form-control" name="status_name"
                            placeholder="Nhập tên Nguồn tiếp cận" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="card-footer d-flex gap-4 justify-content-center p-4">
                    <button id="btn_add_new_sources" type="button" class="btn btn-primary">Thêm mới</button>
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
