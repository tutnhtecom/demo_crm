<div class="modal fade" id="editStatusModal{{$status['id']}}" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-bottom justify-content-between">
                <!--begin::Title-->
                <h2 class="fw-bolder m-0">Sửa trạng thái</h2>
                <!--end::Title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary fs-2" data-bs-dismiss="modal">
                    &times;
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Form-->
            <form id="ti_form_edit_status{{$status['id']}}" novalidate="novalidate" class="text-start">
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label">Tên trạng thái</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input id="input_edit_status_name_{{$status['id']}}" type="text" value="{{$status['name']}}" class="form-control" name="status_name"
                            placeholder="Nhập tên trạng thái" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label">Màu sắc</label>
                        <!--end::Label-->
                        <div class="rounded border border-gray-300 p-1 d-flex flex-grow-1">
                            <!--begin::Input-->
                            <input type="hidden" name="status_color" />
                            <div class="d-flex align-items-center color_place w-100 px-3">
                                <input type="text" class="form-control border-0 py-0 px-0" placeholder="Chọn màu" />
                            </div>
                            <!--end::Input-->
                            <!--begin::Button-->
                            <button type="button" class="btn btn-primary input-group-text justify-self-end"
                                data-ti-menu-trigger="{default: 'click', lg: 'click'}" data-ti-menu-attach="parent"
                                data-ti-menu-placement="top-start">
                                Chọn màu
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M9.80786 12.2695L6.92671 8.81215C6.49249 8.29109 6.86302 7.5 7.54129 7.5H12.4586C13.1368 7.5 13.5073 8.29109 13.0731 8.81215L10.192 12.2695C10.092 12.3895 9.90781 12.3895 9.80786 12.2695Z"
                                        fill="white" />
                                </svg>
                            </button>
                            <!--end::Button-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px ti_menu_colors"
                                data-ti-menu="true" id="ti_menu_colors_x">
                                <!--begin::Heading-->
                                <div class="d-flex gap-2 flex-wrap rounded p-4">
                                    <div class="row gx-1 gy-1">
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(3, 78, 162)"
                                                style="background-color: #034EA2">
                                                <i class="fas fa-check text-white"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(30, 136, 229)"
                                                style="background-color: #1E88E5">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(56, 126, 193)"
                                                style="background-color: #387EC1">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(0, 150, 136)"
                                                style="background-color: #009688">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(30, 187, 121)"
                                                style="background-color: #1EBB79">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(229, 57, 53)"
                                                style="background-color: #E53935">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(255, 86, 48)"
                                                style="background-color: #FF5630">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(233, 30, 99)"
                                                style="background-color: #E91E63">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(142, 36, 170)"
                                                style="background-color: #8E24AA">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(94, 53, 177)"
                                                style="background-color: #5E35B1">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(255, 166, 0)"
                                                style="background-color: #FFA600">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn text-white w-100" data-color="rgba(126, 126, 126)"
                                                style="background-color: #7E7E7E">
                                                <i class="fas fa-check text-white invisible"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="card-footer d-flex gap-4 justify-content-center p-4">
                    <button type="button" class="btn btn-primary btn_edit_status" data-id="{{$status['id']}}">Lưu thay đổi</button>
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
