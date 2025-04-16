<!DOCTYPE html>
@extends('crm.layouts.layout')
@section('header', 'Quản lý thí sinh chính thức')

@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="/" class="text-gray-500">
                            <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý sinh viên</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Sinh viên</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Cập nhật</li>
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
                    <a href="{{route('crm.student.detail', ['id'=>$dataId->id])}}" class="btn btn-ghost btn-sm">
                        <img src="/assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                    </a>
                    <!--end:back button-->
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Chỉnh sửa thông tin sinh viên</h3>
                    <!--end::Title-->

                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <form id="edit-lead-form" data-attr="student">
                <!--begin::Body-->
                <div class="card-body py-6 px-10">

                    <div class="row gx-3 pt-6">
                        <!--begin::heading-->
                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Thông tin chung</h3>
                        </div>
                        <!--end::heading-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_fullName_wrapper">
                                <label for="candidate_name" class="form-label">Họ và tên <span
                                        class="text-danger">*</span></label>
                                <input value="{{ $dataId->full_name ?? null }}" type="text" id="edit_lead_fullName" name="candidate_name"
                                    aria-label="Nhập họ tên thí sinh" placeholder="Nhập họ tên thí sinh"
                                    class="form-control"/>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_phone_wrapper">
                                <label for="candidate_phone" class="form-label">Số điện thoại <span
                                        class="text-danger">*</span></label>
                                <input value="{{ $dataId->phone ?? null }}" type="tel" value="" id="edit_lead_phone" name="candidate_phone"
                                    class="form-control" placeholder="Nhập số điện thoại" required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_email_wrapper">
                                <label for="candidate_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input value="{{ $dataId->email ?? null }}" type="email" id="edit_lead_email" name="candidate_email"
                                    aria-label="Nhập Email thí sinh" placeholder="Nhập Email thí sinh" class="form-control"
                                    required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_gender_wrapper">
                                <label for="candidate_gender" class="form-label">Giới tính </label>
                                <select id="edit_lead_gender" name="candidate_gender" aria-label="Chọn giới tính"
                                    data-control="select2" data-hide-search="true" data-placeholder="Chọn giới tính"
                                    class="form-select" required>
                                    <option value="0" {{ $dataId->gender == 0 ? 'selected' : '' }}>Nữ</option>
                                    <option value="1" {{ $dataId->gender == 1 ? 'selected' : '' }}>Nam</option>
                                    <option value="2" {{ $dataId->gender == 2 ? 'selected' : '' }}>Khác</option>
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_dateOfBirth_wrapper">
                                <label for="candidate_dob" class="form-label">Ngày sinh </label>
                                <input value="{{ $dataId->date_of_birth ?? null }}" type="date" id="edit_lead_dateOfBirth" name="candidate_dob" class="form-control"/>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_identification_card_wrapper">
                                <label for="candidate_id_number" class="form-label">CMND/CCCD</label>
                                <div class="input-group">
                                    <input value="{{ $dataId->identification_card ?? null }}" type="text" id="edit_lead_identification_card" name="candidate_id_number"
                                        class="form-control" maxlength="12">
                                    {{-- <button class="btn btn-ghost bg-transparent border border-start-0 border-gray-300"
                                        type="button" data-ti-password-toggle="true"><i class="fas fa-eye"></i></button> --}}
                                </div>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_status_wrapper">
                                <label for="candidate_adv_status" class="form-label">Tình trạng tư vấn <span class="text-danger">*</span></label>
                                <select id="edit_lead_status" name="candidate_adv_status" aria-label="Chọn trạng thái"
                                    data-control="select2" data-hide-search="true" data-placeholder="Chọn trạng thái"
                                    class="form-select">
                                    <option value="">Tình trạng tư vấn</option>
                                    @foreach ($dataFilter['status'] as $status)
                                        <option value="{{ $status->id }}"
                                            {{ (isset($dataId->status) && $dataId->status->id == $status->id) ? "selected" : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_major_wrapper">
                                <label for="candidate_majors_of_interest" class="form-label">Ngành học quan tâm <span class="text-danger">*</span></label>
                                <select id="edit_lead_major" name="candidate_majors_of_interest"
                                    aria-label="Chọn ngành học" data-control="select2" data-hide-search="true"
                                    data-placeholder="Chọn ngành học" class="form-select">
                                    <option value="">Chọn ngành học</option>
                                    @foreach ($dataFilter['marjors'] as $marjors)
                                        <option value="{{ $marjors->id }}"
                                            {{ (isset($dataId->marjors) && $dataId->marjors->id == $marjors->id) ? "selected" : '' }}>
                                            {{ $marjors->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="mb-6 edit_lead_source_wrapper col-6 col-md-6">
                                    <label for="candidate_source" class="form-label">Nguồn <span class="text-danger">*</span></label>
                                    <select id="edit_lead_source" name="candidate_source" aria-label="Chọn nguồn"
                                        data-control="select2" data-hide-search="true" data-placeholder="Chọn nguồn"
                                        class="form-select">
                                        <option value="">Chọn nguồn</option>
                                        @foreach ($dataFilter['sources'] as $sources)
                                            <option value="{{ $sources->id }}"
                                                {{ (isset($dataId->sources) && $dataId->sources->id == $sources->id) ? "selected" : '' }}>
                                                {{ $sources->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-md-6 position-relative">
                                    <label class="form-label" for="">Gắn thẻ</label>
                                    <input value="{{ $dataId['tags_name'] ?? '' }}" type="text" name="" id="edit_lead_tag"
                                        class="form-control" placeholder="Chọn/Nhập thẻ" />
                                    <ul id="tag-dropdown" class="dropdown-list"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_employees_wrapper">
                                <label for="candidate_agent" class="form-label">Tư vấn viên phụ trách <span class="text-danger">*</span></label>
                                <select id="edit_lead_employees" name="candidate_agent" aria-label="Chọn Tư vấn viên"
                                    data-control="select2" data-hide-search="true" data-placeholder="Chọn tư vấn viên"
                                    class="form-select" disabled>
                                    <option value="">Chọn tư vấn viên</option>
                                    @foreach ($dataFilter['employees'] as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ (isset($dataId->employees) && $dataId->employees->id == $employee->id) ? "selected" : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Địa chỉ liên lạc</h3>
                        </div>
                        <!--end::heading-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_provinces_dcll_wrapper">
                                <label for="candidate_province" class="form-label">Tỉnh / Thành phố</label>
                                <select id="edit_lead_provinces_dcll" name="edit_lead_provinces_hktt"
                                        placeholder="Chọn Tỉnh / Thành phố" class="form-select"
                                        data-default-province="{{ $dataId->contacts[1]->provinces_name?? null }}"
                                        data-default-district="{{ $dataId->contacts[1]->districts_name?? null }}"
                                        data-default-ward="{{ $dataId->contacts[1]->wards_name ?? null}}">
                                    @if(isset($dataFilter['provinces']) && count($dataFilter['provinces']) > 0)
                                        @foreach ($dataFilter['provinces'] as $province)
                                            <option value="{{ $province['name'] ?? ''}}" {{ isset($dataId->contacts[1]->provinces_name) && $dataId->contacts[1]->provinces_name == $province['name'] ? 'selected' : '' }}>{{ $province['name'] }}</option>
                                        @endforeach
                                    @endif
                                    {{-- @foreach ($dataFilter['provinces'] as $province)
                                        <option value="{{ $province['name'] }}" {{ $dataId->contacts[1]->provinces_name == $province['name'] ? 'selected' : '' }}>{{ $province['name'] }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_districts_dcll_wrapper">
                                <label for="candidate_district" class="form-label">Quận / Huyện</label>
                                <select id="edit_lead_districts_dcll" name="candidate_district"
                                    aria-label="Chọn Quận / Huyện" data-placeholder="Chọn Quận / Huyện"
                                    class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_wards_dcll_wrapper">
                                <label for="candidate_ward" class="form-label">Phường / Xã</label>
                                <select id="edit_lead_wards_dcll" name="candidate_ward" aria-label="Chọn Phường / Xã"
                                    data-placeholder="Chọn Phường / Xã" class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_address_dcll_wrapper">
                                <label class="form-label" for="candidate_address">Địa chỉ</label>
                                <input value="{{ $dataId->contacts[1]->address ?? null}}" type="text" name="candidate_address" id="edit_lead_address_dcll"
                                    class="form-control" placeholder="Nhập địa chỉ" />
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Hộ khẩu thường trú</h3>
                        </div>
                        <!--end::heading-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_provinces_hktt_wrapper">
                                <label for="candidate_province" class="form-label">Tỉnh / Thành phố</label>
                                <select id="edit_lead_provinces_hktt" name="edit_lead_provinces_hktt"
                                        placeholder="Chọn Tỉnh / Thành phố" class="form-select"
                                        data-default-province="{{ $dataId->contacts[0]->provinces_name ?? null }}"
                                        data-default-district="{{ $dataId->contacts[0]->districts_name ?? null }}"
                                        data-default-ward="{{ $dataId->contacts[0]->wards_name ?? null }}">
                                    @if(isset($dataFilter['provinces']) && count($dataFilter['provinces']) > 0)
                                        @foreach ($dataFilter['provinces'] as $province)
                                            <option value="{{ $province['name'] ?? ''}}" {{ isset($dataId->contacts[0]->provinces_name) && $dataId->contacts[0]->provinces_name == $province['name'] ? 'selected' : '' }}>{{ $province['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_districts_hktt_wrapper">
                                <label for="candidate_district" class="form-label">Quận / Huyện</label>
                                <select id="edit_lead_districts_hktt" name="candidate_district" aria-label="Chọn"
                                    placeholder="Chọn" class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_wards_hktt_wrapper">
                                <label for="candidate_ward" class="form-label">Phường / Xã</label>
                                <select id="edit_lead_wards_hktt" name="candidate_ward" aria-label="Chọn"
                                    placeholder="Chọn" class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_address_hktt_wrapper">
                                <label class="form-label" for="candidate_address">Địa chỉ</label>
                                <input value="{{ $dataId->contacts[0]->address ?? '' }}" type="text" name="candidate_address" id="edit_lead_address_hktt"
                                    class="form-control" placeholder="Nhập địa chỉ" />
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Thông tin phụ huynh</h3>
                        </div>
                        <!--end::heading-->
                        <!--begin::Col-->
                        @php
                            $father = $dataId->family->firstWhere('type', 0);
                            $mother = $dataId->family->firstWhere('type', 1);
                        @endphp
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_name_father_wrapper">
                                <label for="candidate_father_name" class="form-label">Họ tên cha</label>
                                <input value="{{ $father->full_name ?? '' }}" type="text" id="edit_lead_name_father" name="candidate_father_name"
                                    aria-label="Nhập họ tên cha" placeholder="Nhập họ tên cha" class="form-control"/>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_phone_father_wrapper">
                                <label for="candidate_father_phone" class="form-label">Số điện thoại</label>
                                <input value="{{$father->phone_number ?? "" }}" type="text" value="" id="edit_lead_phone_father"
                                name="candidate_father_phone" class="form-control" placeholder="Nhập số điện thoại"/>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_name_mother_wrapper">
                                <label for="candidate_mother_name" class="form-label">Họ tên mẹ</label>
                                <input value="{{ $mother->full_name ?? "" }}" type="text" id="edit_lead_name_mother" name="candidate_mother_name"
                                aria-label="Nhập họ tên mẹ" placeholder="Nhập họ tên mẹ" class="form-control"/>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_phone_mother_wrapper">
                                <label for="candidate_mother_phone" class="form-label">Số điện thoại</label>
                                <input value="{{ $mother->phone_number ?? "" }}" type="text" value="" id="edit_lead_phone_mother"
                                name="candidate_mother_phone" class="form-control" placeholder="Nhập số điện thoại"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Body-->
                <div class="card-footer">
                    <div class="row gx-6">
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 edit_lead_note_wrapper">
                                <label for="candidate_note" class="form-label w-100 fw-bold">Ghi chú
                                    <textarea rows="2" id="edit_lead_note" name="candidate_note" class="form-control"
                                        placeholder="Nhập ghi chú"></textarea>
                                </label>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <!--begin::Actions-->
                            <div class=" p-4 d-flex align-items-center justify-content-end gap-3 h-100">
                                <button id="edit_lead_btn_submit" type="submit" class="btn btn-primary" data-id="{{$dataId->id}}">Đăng thông
                                    tin</button>
                                {{-- <button type="button" class="btn btn-secondary">Hủy</button> --}}
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
            </form>
        </div>
        <!--end::Content-->
    </div>
    <script type="module" src="{{ asset('assets/crm/js/htecomJs/editLead.js') }}" ></script>
@endsection
<script>
    var provincesDataPageEdit = <?= json_encode($dataFilter['provinces']) ?>;
</script>
