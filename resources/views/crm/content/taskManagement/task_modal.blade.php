<div class="modal fade" id="ti_modal_job_assign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header pb-0 justify-content-between">
                <div class="modal-title">
                    <h3 class="fs-3 fw-bold">Giao việc</h3>
                </div>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 pt-0 pb-15">
                <form id="task_create_management" class="pt-5">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="fw-bold">Tổng quan công việc</h3>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_create_name_wrapper">
                                <label for="job_name" class="form-label">Tên công việc <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="task_create_name" name="task_name" aria-label="Nhập"
                                    data-placeholder="Nhập" placeholder="Nhập" class="form-control" required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_create_employee_wrapper">
                                <label for="job_assigned" class="form-label">Người được phân công <span
                                        class="text-danger">*</span></label>
                                <select id="task_create_employee" data-label="Chọn nhân viên"
                                    data-placeholder="Chọn nhân viên" name="task_employee" class="form-select"
                                    data-control="select2" required data-dropdown-parent="#ti_modal_job_assign">
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_create_priority_wrapper">
                                <label class="form-label" for="job_priority">Mức độ ưu tiên <span
                                        class="text-danger">*</span></label>
                                <select id="task_create_priority" name="task_priority" class="form-select" data-control="select2"
                                    aria-label="Chọn mức độ" data-placeholder="Chọn mức độ" required data-dropdown-parent="#ti_modal_job_assign">
                                    <option value="">Chọn mức độ</option>
                                    <option value="0">Thấp</option>
                                    <option value="1">Trung bình</option>
                                    <option value="2">Cao</option>
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_create_date_wrapper">
                                <label class="form-label" for="job_due_date_start">Ngày bắt đầu - Hạn chót <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex flex-stack">
                                    <input type="date" class="form-control" id="task_create_date_start" required />
                                    <i class="fas fa-arrow-right-arrow-left px-4"></i>
                                    <input type="date" class="form-control" id="task_create_date_end" required />
                                </div>
                                <p class="error-input mt-1 err_date_start"></p>
                                <p class="error-input mt-1 err_date_end"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-6 h-100 task_create_content_wrapper">
                                <label class="form-label" for="job_description">Mô tả công việc</label>
                                <textarea id="job_description_create" rows="3" class="form-control w-100 h-100 task_create_description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-end mt-15 gap-2">
                        <button type="submit" id="task_create_btn_submit" class="btn btn-primary w-150px">Giao
                            việc</button>
                        <button type="reset" id="ti_modal_users_search_reset" data-bs-dismiss="modal"
                            class="btn bg-gray-300 me-3 w-150px">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
