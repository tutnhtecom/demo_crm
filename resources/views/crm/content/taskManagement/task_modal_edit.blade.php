<div class="modal fade" id="ti_modal_job_edit_{{$task->employees->id}}" tabindex="-1" aria-hidden="true">
    {{-- {{dd($task)}} --}}
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
                        <div class="col-12 text-start">
                            <h3 class="fw-bold">Tổng quan công việc</h3>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_edit_name_wrapper text-start">
                                <label for="job_name" class="form-label">Tên công việc <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="task_edit_name_{{$task->id}}" name="task_name" aria-label="Nhập"
                                    data-placeholder="Nhập" placeholder="Nhập" value="{{$task->name}}" class="form-control" required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_edit_employee_wrapper text-start">
                                <label for="job_assigned" class="form-label">Người được phân công <span
                                        class="text-danger">*</span></label>
                                <select id="task_edit_employee_{{$task->id}}" data-label="Chọn nhân viên"
                                    data-placeholder="Chọn nhân viên" name="task_employee" class="form-select"
                                    data-control="select2" required data-dropdown-parent="#ti_modal_job_assign">
                                    <option value="{{$task->employees->id}}" selected>{{$task->employees->name}}</option>
                                    {{-- @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach --}}
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_edit_priority_wrapper text-start">
                                <label class="form-label" for="job_priority">Mức độ ưu tiên <span
                                        class="text-danger">*</span></label>
                                <select id="task_edit_priority_{{$task->id}}" name="task_priority" class="form-select" data-control="select2"
                                    aria-label="Chọn mức độ" data-placeholder="Chọn mức độ" required data-dropdown-parent="#ti_modal_job_assign">
                                    <option value="">Chọn mức độ</option>
                                    <option value="0" {{$task->priority == 0 ? 'selected' : ''}}>Thấp</option>
                                    <option value="1" {{$task->priority == 1 ? 'selected' : ''}}>Trung bình</option>
                                    <option value="2" {{$task->priority == 2 ? 'selected' : ''}}>Cao</option>
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_edit_date_wrapper text-start">
                                <label class="form-label" for="job_due_date_start">Ngày bắt đầu - Hạn chót <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex flex-stack">
                                    <input type="date" class="form-control" id="task_eidt_date_start_{{$task->id}}" value="{{$task->from_date}}" required />
                                    <i class="fas fa-arrow-right-arrow-left px-4"></i>
                                    <input type="date" class="form-control" id="task_eidt_date_end_{{$task->id}}" value="{{$task->to_date}}" required />
                                </div>
                                <p class="error-input mt-1 err_date_start"></p>
                                <p class="error-input mt-1 err_date_end"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 h-100 task_edit_content_wrapper text-start">
                                <label class="form-label" for="job_description">Mô tả công việc</label>
                                <script>
                                    var contentTask{{$task->id}} = `{!! $task->description !!}`;
                                </script>
                                <textarea id="task_edit_description_{{$task->id}}" rows="3" class="form-control w-100 h-100 task_edit_description"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 task_edit_status_wrapper text-start">
                                <label for="job_assigned" class="form-label">Trạng thái công việc <span
                                        class="text-danger">*</span></label>
                                <select id="task_edit_status_{{$task->id}}" name="task_employee" class="form-select" required>
                                    <option value="">Chọn trạng thái</option>
                                    <option value="0" {{$task->status == 0 ? 'selected' : ''}}>Chưa bắt đầu</option>
                                    <option value="1" {{$task->status == 1 ? 'selected' : ''}}>Đang diễn ra</option>
                                    <option value="2" {{$task->status == 2 ? 'selected' : ''}}>Hoàn thành</option>
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-end mt-15 gap-2">
                        <button type="submit" id="" class="btn btn-primary w-150px btn_task_edit" data-id="{{$task->id}}">
                            Lưu
                        </button>
                        <button type="reset" id="ti_modal_users_search_reset" data-bs-dismiss="modal"
                            class="btn bg-gray-300 me-3 w-150px">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
