<div class="modal fade" id="modalChangeMultiEmployee" tabindex="-1" aria-labelledby="employeesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeesModalChangeLabel">Chọn tư vấn viên hỗ trợ <span
                        class="item_full_name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" data-ti-menu="true" id="ti_menu_supporter">
                    <div class="d-flex flex-column bg-white bgi-no-repeat rounded p-4">
                        <form class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                            <input type="hidden">
                            <i
                                class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input id="search_employee_on_table_2" type="text"
                                class="search-input form-control form-control border border-gray-200 rounded h-lg-40px ps-13"
                                name="search" value="" placeholder="Tìm kiếm...">
                        </form>
                        <div class="d-flex flex-column gap-1 pt-4 overflow-y-auto mh-250px">
                            @foreach ($employees as $employee)
                            <div class="d-flex flex-stack border-bottom mb-2 py-2">
                                <div class="symbol rounded-full overflow-hidden symbol-50px me-5">
                                    @if (!empty($employee->files) && is_countable($employee->files) && count($employee->files) > 0)
                                    @php
                                    $imageShown = false;
                                    $files = $employee->files->toArray();
                                    @endphp
                                    @foreach ($files as $file)
                                    @if ($file['types'] == 0 && $file != null)
                                    @php
                                    $employeeAvatar = $file['image_url'];
                                    $imageShown = true;
                                    @endphp
                                    @endif
                                    @endforeach
                                    @if (!$imageShown)
                                    <img src="assets/crm/media/svg/avatars/blank.svg"
                                        class="h-40 align-self-center" alt="">
                                    @else
                                    <img src="{{ $employeeAvatar }}" class="h-40 align-self-center"
                                        alt="">
                                    @endif
                                    @else
                                    <img src="assets/crm/media/svg/avatars/blank.svg"
                                        class="h-40 align-self-center" alt="">
                                    @endif
                                </div>
                                <div
                                    class="d-flex  align-items-between align-items-center flex-row-fluid flex-wrap">
                                    <div class="d-flex flex-column flex-grow-0 me-2">
                                        <span class="badge badge-outline rounded-full badge-primary fs-8 fw-bold"
                                            style="width:max-content;"> {{ $employee->roles->name }} </span>

                                        <span
                                            class="text-gray-800 text-nowrap text-hover-primary fs-6 fw-bold">{{ $employee->name }}</span>
                                        <span
                                            class="text-muted fw-semibold d-block fs-7">{{ $employee->code }}</span>
                                    </div>
                                    <input data-id="{{ $item->id ?? '' }}" type="radio"
                                        class="ms-auto form-check-input employee-radio-2" name="supporter"
                                        value="{{ $employee->id }}" data-name="{{ $employee->name }}"
                                        data-code="{{ $employee->code }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_success_change_employee" type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 ">
                    <span class="d-none d-md-block" style="padding:10px;">Xác nhận</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('change', '.employee-radio-2', function () {
        var employeeId = $(this).val(); // Lấy ID từ value của radio
        $('#btn_success_change_employee').attr('data-employee-id', employeeId);
    });
</script>