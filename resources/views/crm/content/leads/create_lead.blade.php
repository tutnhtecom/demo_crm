<!DOCTYPE html>
@extends('crm.layouts.layout')
@section('header', 'Quản lý thi sinh mới')

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
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thí sinh mới</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Thí sinh tiềm năng</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Thêm mới</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->

        </div>
        <!--end::App Breadcrumb-->

        <!--begin::Content-->
        <div class="card mb-4">
            <!--begin::Toolbar-->
            <div class="card-header p-4">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                    <!--begin:back button-->
                    <a href="{{route('crm.leads.index')}}" class="btn btn-ghost btn-sm">
                        <img src="/assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                    </a>
                    <!--end:back button-->
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Tạo thí sinh mới</h3>
                    <!--end::Title-->

                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <form id="create-lead-form">
                <!--begin::Body-->
                <div class="card-body py-0 px-10">
                    <div class="row gx-3 pt-6">
                        <!--begin::heading-->
                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Thông tin chung</h3>
                        </div>
                        
                        <!-- Mã số sinh viên -->
                        <div class="col-6">
                            <div class="mb-6 create_lead_code_wrapper">
                                <label for="candidate_phone" class="form-label">Mã số sinh viên</label>
                                <input type="tel" value="" id="create_lead_code" name="candidate_code" class="form-control" placeholder="Nhập Mã số sinh viên" />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!-- Button đăng thông tin phía trên -->
                        <div class="col-6 d-flex align-items-center justify-content-end gap-3 h-100">    
                            <div class="mb-6 create_lead_phone_wrapper">
                                <br>
                                <button id="create_lead_btn_submit" type="submit" class="btn btn-primary">Đăng thông tin</button>                            
                            </div>
                        </div>
                        
                        <!-- Họ tên -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_fullName_wrapper">
                                <label for="candidate_name" class="form-label">Họ và tên 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="create_lead_fullName" name="candidate_name"
                                aria-label="Nhập họ tên thí sinh" placeholder="Nhập họ tên thí sinh"  class="form-control" />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->

                        <!-- Số điện thoại -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_phone_wrapper">
                                <label for="candidate_phone" class="form-label">Số điện thoại 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="tel" value="" id="create_lead_phone" name="candidate_phone"
                                       class="form-control" placeholder="Nhập số điện thoại" maxlength="10"/>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                                                
                        <!-- Email -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_email_wrapper">
                                <label for="candidate_email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" id="create_lead_email" name="candidate_email"
                                    aria-label="Nhập Email thí sinh" placeholder="Nhập Email thí sinh" class="form-control"/>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>                        

                        <!--begin::Col-->
                        <!-- Giới tính -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_gender_wrapper">
                                <label for="candidate_gender" class="form-label">Giới tính 
                                    <!-- <span class="text-danger">*</span> -->
                                </label>
                                <select id="create_lead_gender" name="candidate_gender" aria-label="Chọn giới tính"
                                    data-control="select2" data-hide-search="true" data-placeholder="Chọn giới tính" class="form-select">
                                    <option value="0">Nữ</option>
                                    <option value="1">Nam</option>
                                    <option value="2">Khác</option>
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <!-- Ngày sinh -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_dateOfBirth_wrapper">
                                <label for="candidate_dob" class="form-label">Ngày sinh 
                                    <!-- <span class="text-danger">*</span> -->
                                </label>
                                <input type="date" id="create_lead_dateOfBirth" name="candidate_dob" class="form-control" />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <!-- Căn cước công dân -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_identification_card_wrapper">
                                <label for="candidate_id_number" class="form-label">CMND/CCCD 
                                    <!-- <span class="text-danger">*</span> -->
                                </label>
                                <div class="input-group">
                                    <input type="text" id="create_lead_identification_card" name="candidate_id_number" class="form-control" placeholder="Nhập CMND/CCCD" maxlength="12">                                    
                                </div>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!-- Tình trạng tư vấn -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_status_wrapper">
                                <label for="candidate_adv_status" class="form-label">Tình trạng tư vấn
                                     <span class="text-danger">*</span>
                                </label>
                                <select id="create_lead_status" name="candidate_adv_status" 
                                    aria-label="Chọn trạng thái" data-control="select2" data-hide-search="true"
                                    data-placeholder="Chọn trạng thái" class="form-select">
                                    <option value="">Tình trạng tư vấn</option>
                                    @foreach ($dataFilter['status'] as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input mt-2"></p>
                            </div>
                        </div>
                        <!-- Chọn ngành học -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_major_wrapper">
                                <label for="candidate_majors_of_interest" class="form-label">Ngành học quan tâm
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="create_lead_major" name="candidate_majors_of_interest"
                                    aria-label="Chọn ngành học" data-control="select2" data-hide-search="true"
                                    data-placeholder="Chọn ngành học" class="form-select">
                                    <option value="">Chọn ngành học</option>
                                    @foreach ($dataFilter['marjors'] as $marjors)
                                        <option value="{{ $marjors->id }}">{{ $marjors->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>                           
                        </div>
                        <!-- Chọn nguồn tiệp cần, ĐVLK -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_source_wrapper">
                                <label for="candidate_source" class="form-label">Nguồn
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="create_lead_source" name="candidate_source" aria-label="Chọn nguồn"
                                    data-control="select2" data-hide-search="true" data-placeholder="Chọn nguồn"
                                    class="form-select">
                                    <option value="">Chọn nguồn</option>
                                    @foreach ($dataFilter['sources'] as $sources)
                                        <option value="{{ $sources->id }}">{{ $sources->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!-- Chọn tư vấn viên phụ trách -->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_employees_wrapper">
                                <label for="candidate_agent" class="form-label">Tư vấn viên phụ trách
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="create_lead_employees" name="candidate_agent" aria-label="Chọn Tư vấn viên"
                                    data-control="select2" data-hide-search="true" data-placeholder="Chọn tư vấn viên"
                                    class="form-select">
                                    <option value="">Chọn tư vấn viên</option>
                                    @foreach ($dataFilter['employees'] as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Địa chỉ liên lạc</h3>
                        </div>
                        <!--end::heading-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_provinces_dcll_wrapper">
                                <label for="candidate_province" class="form-label">Tỉnh / Thành phố</label>
                                <select id="create_lead_provinces_dcll" name="create_lead_provinces_dcll" placeholder="Chọn Tỉnh / Thành phố"
                                    class="form-select">
                                    <option value="">Chọn Tỉnh / Thành phố</option>
                                    @foreach ($dataFilter['provinces'] as $province)
                                        <option value="{{ $province['name'] }}">{{ $province['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_districts_dcll_wrapper">
                                <label for="candidate_district" class="form-label">Quận / Huyện</label>
                                <select id="create_lead_districts_dcll" name="candidate_district" aria-label="Chọn Quận / Huyện"
                                    data-placeholder="Chọn Quận / Huyện" class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_wards_dcll_wrapper">
                                <label for="candidate_ward" class="form-label">Phường / Xã</label>
                                <select id="create_lead_wards_dcll" name="candidate_ward" aria-label="Chọn Phường / Xã"
                                    data-placeholder="Chọn Phường / Xã" class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_address_dcll_wrapper">
                                <label class="form-label" for="candidate_address">Địa chỉ</label>
                                <input type="text" name="candidate_address" id="create_lead_address_dcll"
                                    class="form-control" placeholder="Nhập địa chỉ" />
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Hộ khẩu thường trú</h3>
                        </div>
                        <!--end::heading-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_provinces_hktt_wrapper">
                                <label for="candidate_province" class="form-label">Tỉnh / Thành phố</label>
                                <select id="create_lead_provinces_hktt" name="create_lead_provinces_hktt" placeholder="Chọn Tỉnh / Thành phố"
                                    class="form-select">
                                    <option value="">Chọn Tỉnh / Thành phố</option>
                                    @foreach ($dataFilter['provinces'] as $province)
                                        <option value="{{ $province['name'] }}">{{ $province['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_districts_hktt_wrapper">
                                <label for="candidate_district" class="form-label">Quận / Huyện</label>
                                <select id="create_lead_districts_hktt" name="candidate_district" aria-label="Chọn"
                                    placeholder="Chọn" class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_wards_hktt_wrapper">
                                <label for="candidate_ward" class="form-label">Phường / Xã</label>
                                <select id="create_lead_wards_hktt" name="candidate_ward" aria-label="Chọn"
                                    placeholder="Chọn" class="form-select">
                                    <option value="">Chọn</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_address_hktt_wrapper">
                                <label class="form-label" for="candidate_address">Địa chỉ</label>
                                <input type="text" name="candidate_address" id="create_lead_address_hktt"
                                    class="form-control" placeholder="Nhập địa chỉ" />
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Thông tin phụ huynh</h3>
                        </div>
                        <!--end::heading-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_name_father_wrapper">
                                <label for="candidate_father_name" class="form-label">Họ tên cha</label>
                                <input type="text" id="create_lead_name_father" name="candidate_father_name"
                                    aria-label="Nhập họ tên cha" placeholder="Nhập họ tên cha" class="form-control" />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_phone_father_wrapper">
                                <label for="candidate_father_phone" class="form-label">Số điện thoại</label>
                                <input type="text" value="" id="create_lead_phone_father"
                                    name="candidate_father_phone" class="form-control" placeholder="Nhập số điện thoại" />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_name_mother_wrapper">
                                <label for="candidate_mother_name" class="form-label">Họ tên mẹ</label>
                                <input type="text" id="create_lead_name_mother" name="candidate_mother_name"
                                    aria-label="Nhập họ tên mẹ" placeholder="Nhập họ tên mẹ" class="form-control"/>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_phone_mother_wrapper">
                                <label for="candidate_mother_phone" class="form-label">Số điện thoại</label>
                                <input type="text" value="" id="create_lead_phone_mother"
                                    name="candidate_mother_phone" class="form-control" placeholder="Nhập số điện thoại"/>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::heading-->
                        <div class="col-12 col-md-12">
                            <div class="mb-6 create_lead_note_wrapper">
                                <label for="candidate_note" class="mb-2 form-label w-100 fw-bold">Ghi chú</label>
                                <textarea rows="2" id="create_lead_note" name="candidate_note" class="form-control" placeholder="Nhập ghi chú"></textarea>
                            </div>
                        </div>

                        
                    </div>
                </div>
                <!--end::Body-->
                <div class="card-footer my-0 py-0">
                    <div class="row gx-6">
                        <!--begin::Col-->
                        <!-- <div class="col-12 col-md-6">
                            <div class="mb-6 create_lead_note_wrapper">
                                <label for="candidate_note" class="form-label w-100 fw-bold">Ghi chú
                                    <textarea rows="2" id="create_lead_note" name="candidate_note" class="form-control" placeholder="Nhập ghi chú"></textarea>
                                </label>
                            </div>
                        </div> -->
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-12">
                            <!--begin::Actions-->
                            <div class=" p-4 d-flex align-items-center justify-content-end gap-3 h-100">
                                <button id="create_lead_btn_submit" type="submit" class="btn btn-primary">Đăng thông tin</button>
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
    <script type="module" src="{{ asset('assets/crm/js/htecomJs/createLead.js') }}" ></script>
@endsection
<script> var provincesData = <?= json_encode($dataFilter['provinces']); ?>; </script>
