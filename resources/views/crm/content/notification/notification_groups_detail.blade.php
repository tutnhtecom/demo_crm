<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý nhóm')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thông báo</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold">Quản lý nhóm</li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <li class="breadcrumb-item text-primary">Chi tiết nhóm</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->
        </div>
        <!--end::App Breadcrumb-->
        <div class="row gx-3">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header p-4">
                        <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                            <div class="card-title text-dark fw-bolder m-md-0">
                                {{ $data['data']['name'] }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title" class="form-label" style="color:#034EA2;">Tên nhóm <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name_group" name="title"
                                    placeholder="Nhập tên nhóm" value="{{ $data['data']['name'] }}" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title" class="form-label" style="color:#034EA2;">Thêm thành viên <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div style="width:100%">
                                        <input type="text" class="form-control" id="input_add_email" name="title"
                                            placeholder="Nhập email " />
                                        <p id="nameDisplay" class="mb-0"></p>
                                    </div>
                                    <button type="button" class="btn btn-primary min-w-150px btn_add_info_group" style="height:max-content;">
                                        Thêm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-row">
                            <div class="form-group">
                                @php
                                    switch($data['data']['types']){
                                        case 1:
                                            $groupName = "Nhóm Sinh viên chính thức";
                                            break;
                                        case 2:
                                            $groupName = "Nhóm Nhân viên";
                                            break;
                                        default:
                                            $groupName = "Nhóm Sinh viên tiềm năng";
                                            break;
                                    }
                                @endphp
                                <h5 style="font-size:14px;font-weight:500;color:#034EA2;">Danh sách thành viên trong {{$groupName}}</h5>
                                <div class="row list_member_in_group" data-types="{{$data['data']['types']}}">
                                    @foreach($data['detail'] as $name)
                                    @php
                                        switch($data['data']['types']){
                                            case 1:
                                                $detailUrl = route('crm.student.detail', ['id' => $name['id']]);
                                                break;
                                            case 2:
                                                $detailUrl = route('crm.employee.detail', ['id' => $name['id']]);
                                                break;
                                            default:
                                                $detailUrl = route('crm.lead.detail', ['id' => $name['id']]);
                                                break;
                                        }
                                    @endphp
                                        <div class="email-item d-flex align-items-center justify-content-between col-md-4 mb-3">
                                            <div class="d-flex align-items-center justify-content-between" style="border:1px solid #ccc;border-radius:10px;width:100%;padding: 0 10px;">
                                                <span class="name_member_group" data-id="{{ $name['id'] ?? null }}">{{ isset($name['full_name']) ? $name['full_name'] : ($name['name'] ?? null) }}</span>
                                                <div>
                                                    <a href="{{ $detailUrl }}" class="btn btn-ghost p-1">
                                                        <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18" height="18">
                                                    </a>
                                                    <button type="button" class="btn btn-ghost btn_delete_member" style="padding:10px 5px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                                            fill="none">
                                                            <path opacity="0.3"
                                                                d="M3.07457 14.6309L2.57129 7.58495H15.4284L14.9252 14.6309C14.8427 15.7852 14.0005 16.7541 12.8535 16.9074C10.2811 17.2512 7.71863 17.2512 5.14624 16.9074C3.99919 16.7541 3.15702 15.7852 3.07457 14.6309Z"
                                                                fill="#FF5630" />
                                                            <path
                                                                d="M2.57129 7.58495L3.07457 14.6309C3.15702 15.7852 3.99919 16.7541 5.14624 16.9074C7.71863 17.2512 10.2811 17.2512 12.8535 16.9074C14.0005 16.7541 14.8427 15.7852 14.9252 14.6309L15.4284 7.58495"
                                                                stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M0.963867 4.46799H17.0353" stroke="#FF5630" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path
                                                                d="M5.78516 4.37067L6.4118 2.64741C6.80748 1.5593 7.8416 0.834961 8.99944 0.834961C10.1573 0.834961 11.1914 1.5593 11.5871 2.64741L12.2137 4.37067"
                                                                stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M9 8.65566V13.8732" stroke="#FF5630" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path
                                                                d="M11.4692 11.0651C10.6233 10.0725 10.1003 9.52244 9.1471 8.71707C9.05314 8.63767 8.91594 8.63491 8.81914 8.71082C7.87442 9.45174 7.34105 10.0055 6.47363 11.0651"
                                                                stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-start align-items-center p-4">
                        <button id="btn_edit_group_detail" data-id="{{ $data['data']['id'] }}" type="button" class="btn btn-primary min-w-150px btn_save_info_group">
                            Cập nhật
                        </button>
                    </div>
                    <!--end::Actions-->
                </div>
            </div>
        </div>

    </div>


    <script>
        var userEmployees = <?php echo json_encode($userData['employees']); ?>;
        var userLeads = <?php echo json_encode($userData['leads']); ?>;
        var userStudents = <?php echo json_encode($userData['students']); ?>;
    </script>
    <script type="module" src="/assets/crm/js/htecomJs/editGroup.js"></script>
@endsection
