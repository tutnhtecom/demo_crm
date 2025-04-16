<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý nhân viên')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý nhân viên</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Danh sách nhân viên</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Chỉnh sửa thông tin nhân viên</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->

        </div>
        <!--end::App Breadcrumb-->

        <!--begin::Content-->
        <div class="card">
            <!--begin::Toolbar-->
            <div class="card-header p-4">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                    <!--begin:back button-->
                    <a href="{{ route('crm.employee.detail', ['id' => $dataId['data']->id]) }}" class="btn btn-ghost btn-sm">
                        <img src="assets/crm/media//svg/crm/chevron-left.svg" width="24" height="24" />
                    </a>
                    <!--end:back button-->
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Thông tin tài khoản</h3>
                    <!--end::Title-->

                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <form id="edit-employee-form">
                <!--begin::Body-->
                <div class="card-body py-6 px-10">

                    <div class="row gx-3 pt-6">
                        <div class="col-2 mb-3 mb-md-6">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Hình đại diện</h3>
                            <input type="file" id="avatar" name="avatar" class="d-none edit_employee_avatar"
                                accept="image/png,image/jpeg,image/jpg" />
                            <a href="javascript:void(0);"
                                class="w-175px h-175px d-flex flex-center rounded border-0 bg-gray-300 position-relative"
                                data-file-trigger="avatar">
                                <img src="{{ $imageEmployee ? $imageEmployee : asset('assets/crm/media/svg/avatars/blank.svg') }}"                         
                                    class="w-175px h-175px object-cover rounded position-absolute" alt="preview" />
                                <div class="position-absolute translate-middle-y d-flex gap-2 justify-content-center"
                                    style="bottom: -60px;">
                                    <button type="button" data-file-trigger-id="avatar" data-action="edit"
                                        class="btn btn-ghost p-2 btn-sm"><i
                                            class="fas fa-edit text-gray-600 fs-4"></i></button>
                                    <button type="button" data-file-trigger-id="avatar" data-action="delete"
                                        class="btn btn-ghost p-2 btn-sm"><i
                                            class="fas fa-trash text-gray-600 fs-4"></i></button>
                                </div>
                            </a>
                        </div>

                        <div class="col-10 mb-3 mb-md-6">
                            <div class="col-12">
                                <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Thông tin chung</h3>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <div class="mb-6 edit_employee_fullName_wrapper">
                                        <label for="candidate_name" class="form-label">Họ và tên <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $dataId['data']->name }}" type="text" id="edit_employee_fullName" name="edit_employee_fullName" value="Nguyễn Văn A"
                                            aria-label="Nhập họ tên thí sinh" placeholder="Nhập họ tên thí sinh" class="form-control"
                                            required />
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="mb-6 edit_employee_phone_wrapper">
                                        <label for="candidate_phone" class="form-label">Số điện thoại <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $dataId['data']->phone }}" type="number"
                                            id="edit_employee_phone" name="edit_employee_phone" value="0123456789"
                                            onkeypress="return isNumber(event)"
                                            class="form-control" placeholder="Nhập số điện thoại" required />
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <div class="mb-6 edit_employee_email_wrapper">
                                        <label for="candidate_email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $dataId['data']->email }}" type="email" id="edit_employee_email" name="edit_employee_email" value="nva@gmail.com"
                                            aria-label="Nhập Email thí sinh" placeholder="Nhập Email thí sinh" class="form-control"
                                            required />
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="row">
                                        <div class="mb-6 edit_employee_dateOfBirth_wrapper  col-md-6">
                                            <label for="candidate_dob" class="form-label">Ngày sinh <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ $dataId['data']->date_of_birth }}" type="date" id="edit_employee_dateOfBirth" name="edit_employee_dateOfBirth" value="1994-02-15"
                                                class="form-control" required />
                                            <p class="error-input mt-1"></p>
                                        </div>
                                        <div class="mb-6 create_employee_line_id_voip_wrapper  col-md-6">
                                            <label for="line_id_voip" class="form-label">Cài đặt máy nhánh</label>
                                            @php
                                                $line_id = $dataId['data']->lineVoip->line_id ?? null;
                                            @endphp
                                            <select name="line_id_voip" id="line_id_voip" data-control="" data-hide-search="true"
                                                aria-label="Chọn máy nhánh" data-placeholder="Chọn máy nhánh" class="form-select">
                                                <option value="">Chọn máy nhánh</option>
                                                @foreach ($line_id_voip as $line)
                                                    <option value="{{ $line->line_id }}" {{$line->line_id == $line_id ? 'selected' : ''}}>{{ $line->line_id }}</option>
                                                @endforeach
                                            </select>
                                            <p class="error-input mt-1"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Phân quyền và mật khẩu</h3>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 edit_employee_role_wrapper">
                                        <label for="profile_role" class="form-label">Phân quyền <span
                                                class="text-danger">*</span></label>
                                        <select name="edit_employee_role" id="edit_employee_role" data-control="select2"
                                            data-hide-search="true" aria-label="Chọn phân quyền"
                                            data-placeholder="Chọn phân quyền" class="form-select">
                                            @foreach ($dataRole as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ (isset($dataId['data']->roles->id) && $dataId['data']->roles->id == $role->id) ? "selected" : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="error-input mt-1"></p>
                                        <p class="text-muted italic">* Quản trị viên Admin có quyền cao nhất, có
                                            thẻ sử dụng tất cả các chức năng quản lý của hệ thống quản trị.</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-6 edit_employee_password_wrapper">
                                        <label for="profile_password" class="form-label">Mật khẩu <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" id="edit_employee_password" name="edit_employee_password"
                                                value="" class="form-control border-right-0" placeholder="********">
                                            <button class="btn btn-ghost bg-transparent border border-start-0 border-gray-300"
                                                type="button" data-ti-password-toggle="true"><i class="fas fa-eye"></i></button>
                                        </div>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="my-4 col-md-6 col-12">
                                    <input type="checkbox" name="auto_send_mail" id="auto_send_mail" class="form-check-input" style="border-radius: 3px; width:20px;height: 20px;">
                                    <span style="font-size: 13px;" class="px-3"><strong>Tắt tự động gửi mail</strong></span>
                                </div>
                                <div class="mb-3 col-md-6 col-12">
                                    <label for="modal_thread" class="form-label">Chọn mẫu email</label>
                                    <select id="select_email_template" name="" class="form-select">
                                        <option value="" disabled="" selected="">Chọn mẫu email</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--end::Col-->

                    </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end gap-3">
                    <button id="edit_employee_btn_submit" type="submit" class="btn btn-primary" data-id="{{ $dataId['data']->id }}">Lưu thông tin</button>
                    <button type="button" class="btn btn-secondary">Hủy</button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Content-->
    </div>

    <script>
        TI_Util.on(document.body, '[data-file-trigger-id]', 'click', function (e) {
            e.stopPropagation();
            e.preventDefault();
            var button = e.target.closest('button');
            var action = button.getAttribute('data-action');
            var file_button_element_id = button.getAttribute('data-file-trigger-id');
            if (action === 'edit') {
                document.getElementById(file_button_element_id).value = '';
                document.getElementById(file_button_element_id).click();
            }
    
            if (action === 'delete') {
                document.getElementById(file_button_element_id).value = '';
                document.querySelector('[data-file-trigger="' + file_button_element_id + '"]').innerHTML = '<i class="fas fa-plus fs-1"></i>';
            }
    
            return false;
        });
        TI_Util.on(document.body, '[data-file-trigger]', 'click', function (e) {
        e.preventDefault();

        var file_elm_id = this.getAttribute('data-file-trigger');

        // document.getElementById(file_elm_id).click();
        // Add image preview after select
        document.getElementById(file_elm_id).onchange = function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-175px h-175px object-cover rounded position-absolute';
                img.alt = 'preview';
                document.querySelector('[data-file-trigger="' + file_elm_id + '"]').innerHTML = '';
                document.querySelector('[data-file-trigger="' + file_elm_id + '"]').appendChild(img);
                // Add actions wrapper next right the image
                var actions = document.createElement('div');
                actions.className = 'position-absolute translate-middle-y d-flex gap-2 justify-content-center';
                // actions.style.right = '-45px';
                actions.style.bottom = '-60px';

                // Add edit button
                var edit_btn = document.createElement('button');
                edit_btn.type = "button";
                edit_btn.setAttribute('data-file-trigger-id', file_elm_id);
                edit_btn.setAttribute('data-action', 'edit');
                edit_btn.className = 'btn btn-ghost p-2 btn-sm';
                edit_btn.innerHTML = '<i class="fas fa-edit text-gray-600 fs-4"></i>';
                actions.appendChild(edit_btn);
                // Add remove button
                var remove_btn = document.createElement('button');
                remove_btn.type = "button";
                remove_btn.setAttribute('data-file-trigger-id', file_elm_id);
                remove_btn.setAttribute('data-action', 'delete');
                remove_btn.className = 'btn btn-ghost p-2 btn-sm';
                remove_btn.innerHTML = '<i class="fas fa-trash text-gray-600 fs-4"></i>';
                actions.appendChild(remove_btn);
                document.querySelector('[data-file-trigger="' + file_elm_id + '"]').appendChild(actions);

            };
            reader.readAsDataURL(file);

        };
    });
    </script>
@endsection
<script>
    function isNumber(event) {
        const charCode = event.which ? event.which : event.keyCode;
        // Chỉ cho phép nhập số (0-9)
        if (charCode < 48 || charCode > 57) return false;
    return true;
}
</script>
