<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý phân quyền')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Tài khoản</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Quản lý phân quyền</li>
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
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Quản lý phân quyền</h3>
                    <!--end::Title-->

                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Body-->
            <div class="card-body py-6 px-10">
                <div class="row">
                    <div class="col-12 col-md-3 border-end">
                        <h3 class="my-6">Thiết lập nhóm người dùng</h3>
                        <div class="d-flex flex-column gap-3">
                            <ul class="p-0 nav nav-tabs" style="list-style-type:none;" role="tablist">
                                @foreach ($data['data'] as $role)
                                <li class="mb-3" style="width:100%;">
                                    <a href="#role_{{$role['id']}}"
                                        class="role_tab_link d-flex justify-content-between align-items-center rounded rounded-3 border border-primary border-opacity-50 bg-opacity-15 cursor-pointer px-6 py-4 {{ $loop->first ? 'bg-primary' : '' }}"
                                        id="tab-{{$role['id']}}" data-bs-toggle="tab" role="tab" aria-controls="role_{{$role['id']}}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"> {{-- bg-primary --}}
                                        <span class="text-dark lh-0">
                                            {{ $role['name'] }}
                                        </span>
                                        <span class="ms-auto">
                                            @if($role['id'] == 1)
                                                <div></div>
                                            @else
                                                <button id="btn_edit_role_{{$role['id']}}" type="button" class="btn btn-sm btn-ghost px-1 py-0" title="Sửa tên" data-bs-toggle="modal" data-bs-target="#editRoleModal{{$role['id']}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 18 18" fill="none">
                                                        <path opacity="0.3"
                                                            d="M1.2889 14.3326C1.42677 15.5669 2.41338 16.553 3.64703 16.6957C5.04103 16.857 6.48148 17.016 7.95528 17.016C9.42908 17.016 10.8695 16.857 12.2635 16.6957C13.4972 16.553 14.4837 15.5669 14.6217 14.3326C14.7766 12.9453 14.9262 11.5118 14.9262 10.0451C14.9262 8.57848 14.7766 7.14497 14.6217 5.75758C14.4837 4.52337 13.4972 3.53724 12.2635 3.39454C10.8695 3.23329 9.42908 3.07422 7.95528 3.07422C6.48148 3.07422 5.04103 3.23329 3.64703 3.39454C2.41338 3.53724 1.42677 4.52337 1.2889 5.75758C1.13392 7.14497 0.984375 8.57848 0.984375 10.0451C0.984375 11.5118 1.13392 12.9453 1.2889 14.3326Z"
                                                            fill="#034EA2" />
                                                        <path
                                                            d="M6.92992 3.09863C5.81225 3.14897 4.71599 3.27134 3.64705 3.39499C2.41338 3.53769 1.42677 4.52382 1.2889 5.75803C1.13392 7.14542 0.984375 8.57893 0.984375 10.0456C0.984375 11.5122 1.13392 12.9457 1.2889 14.3331C1.42677 15.5673 2.41338 16.5534 3.64703 16.6961C5.04103 16.8574 6.48148 17.0165 7.95528 17.0165C9.42908 17.0165 10.8695 16.8574 12.2635 16.6961C13.4972 16.5534 14.4837 15.5674 14.6217 14.3331C14.7332 13.3352 14.8418 12.3133 14.894 11.2724"
                                                            stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M12.9966 1.6746L8.25894 7.05037L7.60989 10.1031C7.50545 10.5943 8.01746 11.059 8.49695 10.9083L11.5348 9.95326L16.4285 4.80409C17.2412 3.94887 17.0993 2.51846 16.1155 1.64828C15.1548 0.798474 13.7584 0.810258 12.9966 1.6746Z"
                                                            fill="white" />
                                                        <path
                                                            d="M12.9966 1.6746L8.25894 7.05037L7.60989 10.1031C7.50545 10.5943 8.01746 11.059 8.49695 10.9083L11.5348 9.95326L16.4285 4.80409C17.2412 3.94887 17.0993 2.51846 16.1155 1.64828C15.1548 0.798474 13.7584 0.810258 12.9966 1.6746Z"
                                                            stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                            @endif

                                            <!-- Modal Edit Role-->
                                            <div class="modal fade" id="editRoleModal{{$role['id']}}" tabindex="-1" aria-labelledby="editRole{{$role['id']}}Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa ({{$role['name']}})</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body input_edit_role_wrapper_{{$role['id']}}">
                                                            <input class="style_input_role" id="input_edit_role_{{$role['id']}}" type="text" placeholder="Chỉnh sửa..." value="{{ e($role['name']) }}">
                                                            <p class="error-input mt-1"></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="btn_edit_role" data-id="{{$role['id']}}" type="button" class="btn btn-primary btn_edit_role">Lưu</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Modal Edit Role-->

                                            @if($role['id'] == 1)
                                                <div class="btn btn-sm btn-ghost px-1 py-0"></div>
                                            @else
                                                <button type="button" class="btn btn-sm btn-ghost px-1 py-0" title="Xóa" data-bs-toggle="modal" data-bs-target="#deleteRoleModal{{$role['id']}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 18 18" fill="none">
                                                        <path opacity="0.3"
                                                            d="M3.07481 14.6309L2.57153 7.58496H15.4287L14.9254 14.6309C14.8429 15.7852 14.0008 16.7541 12.8537 16.9074C10.2813 17.2512 7.71888 17.2512 5.14648 16.9074C3.99943 16.7541 3.15727 15.7852 3.07481 14.6309Z"
                                                            fill="#FF5630" />
                                                        <path
                                                            d="M2.57153 7.58496L3.07481 14.6309C3.15727 15.7852 3.99943 16.7541 5.14648 16.9074C7.71888 17.2512 10.2813 17.2512 12.8537 16.9074C14.0008 16.7541 14.8429 15.7852 14.9254 14.6309L15.4287 7.58496"
                                                            stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M0.964355 4.46777H17.0358" stroke="#FF5630" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M5.78589 4.37067L6.41253 2.64741C6.80821 1.5593 7.84234 0.834961 9.00017 0.834961C10.158 0.834961 11.1921 1.5593 11.5878 2.64741L12.2145 4.37067"
                                                            stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9 8.65527V13.8729" stroke="#FF5630" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M11.4699 11.0647C10.624 10.0721 10.1011 9.52206 9.14783 8.71668C9.05387 8.63729 8.91667 8.63453 8.81987 8.71044C7.87515 9.45135 7.34179 10.0051 6.47437 11.0647"
                                                            stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                            @endif

                                            <!-- Modal Delete Role-->
                                            <div class="modal fade modal_delete" id="deleteRoleModal{{$role['id']}}" tabindex="-1" aria-labelledby="deleteRoleModal{{$role['id']}}Label" aria-hidden="true">
                                                <div class="modal-dialog" style="margin-top:160px;">
                                                    <div class="modal-content" style="max-width: 444px">
                                                        <div class="">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <img src="assets/crm/media/svg/crm/danger-triange.svg" alt="">
                                                            </div>
                                                            <div class="d-flex justify-content-center align-items-center" style="font-size:24px;font-weight:600;margin-bottom:15px;"> Xóa hồ sơ này? </div>
                                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                                <button id="btn_delete_role" type="button" class="btn btn-primary btn_delete_role" data-id="{{$role['id']}}">Xác nhận</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            </div>
                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Modal Delete Role-->
                                        </span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            
                            <a id="btn_create_role_wrapper"
                                class="d-flex justify-content-between align-items-center rounded rounded-3 border border-gray-300 cursor-pointer px-6 py-4 ">
                                <span class="text-dark lh-0">
                                    Thêm nhóm người dùng
                                </span>
                                <span class="ms-auto">
                                    <button type="button" class="btn btn-sm btn-ghost px-1 py-0" title="Thêm nhóm mới" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22" fill="none">
                                            <path opacity="0.3"
                                                d="M20.1666 10.9997C20.1666 16.0623 16.0625 20.1663 10.9999 20.1663C5.93731 20.1663 1.83325 16.0623 1.83325 10.9997C1.83325 5.93706 5.93731 1.83301 10.9999 1.83301C16.0625 1.83301 20.1666 5.93706 20.1666 10.9997Z"
                                                fill="#7E7E7E" />
                                            <path
                                                d="M20.1666 10.9997C20.1666 16.0623 16.0625 20.1663 10.9999 20.1663C5.93731 20.1663 1.83325 16.0623 1.83325 10.9997C1.83325 5.93706 5.93731 1.83301 10.9999 1.83301C16.0625 1.83301 20.1666 5.93706 20.1666 10.9997Z"
                                                stroke="#7E7E7E" stroke-linecap="round" />
                                            <path
                                                d="M11.6875 8.25C11.6875 7.8703 11.3797 7.5625 11 7.5625C10.6203 7.5625 10.3125 7.8703 10.3125 8.25L10.3125 10.3125H8.25C7.8703 10.3125 7.5625 10.6203 7.5625 11C7.5625 11.3797 7.8703 11.6875 8.25 11.6875H10.3125V13.75C10.3125 14.1297 10.6203 14.4375 11 14.4375C11.3797 14.4375 11.6875 14.1297 11.6875 13.75L11.6875 11.6875H13.75C14.1297 11.6875 14.4375 11.3797 14.4375 11C14.4375 10.6203 14.1297 10.3125 13.75 10.3125H11.6875V8.25Z"
                                                fill="#7E7E7E" />
                                        </svg>
                                    </button>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="tab-content">
                            @foreach ($data['data'] as $role)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="role_{{$role['id']}}" role="tabpanel"
                                aria-labelledby="tab-{{$role['id']}}">
                                <form id="role_form_{{$role['id']}}" data-form-id="{{$role['id']}}">
                                    <div class="d-flex flex-stack my-6">
                                        <h3 class="">Phân quyền ({{$role['name']}})</h3>
                                        <span class="fs-6 fw-bold">Khả năng</span>
                                    </div>
                                    <div class="d-flex flex-stack my-1 justify-content-end">
                                        <div class="d-flex gap-2">
                                            <button type="button" data-id-form="{{$role['id']}}" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 p-5 permission_check_all">
                                                Chọn tất cả
                                            </button>
                                            <button type="button" data-id-form="{{$role['id']}}" class="btn btn-sm btn-secondary lh-0 d-flex align-items-center gap-1 p-5 permission_uncheck">
                                                Bỏ chọn tất cả
                                            </button>
                                        </div>
                                    </div>
                                    @php
                                        // Lấy danh sách các permissions_id của role hiện tại
                                        $rolePermissions = array_column($role['role_permissions'], 'permissions_id');
                                    @endphp
                                    @foreach ($dataPermission['permissions'] as $permission)
                                        @if ($permission->parent_id === null)
                                            <div class="d-flex flex-column gap-3">
                                                <h4 class="fw-bold border-top py-4">{{$permission->name}}</h4>
                                            </div>
                                        @elseif ($permission->parent_id !== null)
                                            <div class="d-flex flex-column gap-3">
                                                <div class="form-check d-flex flex-stack ps-4 py-3 px-2">
                                                    <label class="form-check-label text-dark cursor-pointer"
                                                    for="manage_candidate--view-own">{{$permission->name}}</label>
                                                    <input data-id="{{$permission->id}}" class="form-check-input permission_check" type="checkbox" value="{{$permission->id}}" id="" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end gap-3 mt-6 py-6 border-top">
                                        <button data-id="{{$role['id']}}" type="submit" class="btn btn-primary btn_save_roles">Lưu</button>
                                        <button type="button" class="btn btn-secondary">Hủy</button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Content-->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm Vai Trò Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body input_role_wrapper">
                    <input class="style_input_role" id="input_role" type="text" placeholder="Thêm vai trò...">
                    <p class="error-input mt-1"></p>
                </div>
                <div class="modal-footer">
                    <button id="btn_create_role" type="button" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection
