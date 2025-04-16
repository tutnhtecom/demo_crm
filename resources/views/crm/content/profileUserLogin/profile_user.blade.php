<!DOCTYPE html>
@extends('crm.layouts.layout')
@section('title', 'Tài khoản')
@section('header', 'Tài khoản')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dasboard</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Tài khoản</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->

        </div>
        <!--end::App Breadcrumb-->

        <!--begin::Card-->
        <form>
            <div class="card">
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::User Info-->
                    <div class="d-flex flex-stack">
                        <!--begin::Symbol-->
                        <div class="symbol rounded-full overflow-hidden symbol-90px me-5">
                            @if($data->user->id != 1)
                                @foreach ($data->files as $file)
                                    @if($file->types == 0 && $file->deleted_at == null)
                                        <img src="{{$file->image_url}}" class="h-90 align-self-center" alt="user">
                                    @endif
                                    @break
                                @endforeach
                            @else
                                <img src="assets/crm/media/avatars/300-2.jpg" class="h-90 align-self-center" alt="user">
                            @endif
                        </div>
                        <!--end::Symbol-->

                        <!--begin::Section-->
                        <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                            <!--begin:Author Tag-->
                            <span class="fs-8 text-danger bg-danger bg-opacity-20 rounded-full px-3 py-1" style="background-color: rgba(255, 86, 48, 0.15)!important;">
                                {{$data->roles->name ?? null}}
                            </span>
                            <!--end:Author Tag-->
                            <!--begin:Author-->
                            <div class="flex-grow-1 me-2">
                                <span class="text-primary text-hover-primary fs-6 fw-bold">{{$data->name ?? null}}</span>

                                <span class="text-muted fw-semibold d-block fs-7">Mã: {{$data->code ?? null}}</span>
                                <span class="text-success fw-semibold d-block fs-7">Đang hoạt động<span
                                        class="fs-3">•</span></span>
                            </div>
                            <!--end:Author-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::User Info-->
                    <!--begin::User Form-->

                    <div class="d-flex flex-column mt-6">
                        <ul class="nav nav-tabs nav-line-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="general_info_tab" data-bs-toggle="tab"
                                    data-bs-target="#general_info" type="button" role="tab"
                                    aria-controls="general_info" aria-selected="true">
                                    Thông tin tài khoản
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security"
                                    type="button" role="tab" aria-controls="security" aria-selected="true">
                                    Mật khẩu
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mt-6" id="profile_form">
                            <!--begin::General-->
                            <div class="tab-pane fade show active" id="general_info" role="tabpanel"
                                aria-labelledby="general_info_tab">
                                <h3 class="fw-bold">Thông tin chung</h3>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-6 profile_name_wrapper">
                                            <label for="profile_name" class="form-label">Họ và tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Nhập tên"
                                                id="profile_name" value="{{$data->name ?? null}}" required />
                                            <p class="error-input mt-1"></p>    
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-6 profile_phone_wrapper">
                                            <label for="profile_phone" class="form-label">Số điện thoại <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Nhập số điện thoại"
                                                id="profile_phone" value="{{$data->phone ?? null}}" required />
                                            <p class="error-input mt-1"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-6 profile_email_wrapper">
                                            <label for="profile_email" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" placeholder="Nhập Email"
                                                id="profile_email" value="{{$data->email ?? null}}" disabled/>
                                            <p class="error-input mt-1"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-6 profile_dob_wrapper">
                                            <label for="profile_dob" class="form-label">Ngày sinh <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Nhập Ngày sinh"
                                                id="profile_dob" value="{{$data->date_of_birth ?? null}}" required />
                                            <p class="error-input mt-1"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer p-0">
                                    <!--begin::Actions-->
                                    <div class="ms-auto p-0 py-3 d-flex align-items-center justify-content-end gap-3">
                                        <button id="save_info_account" data-id="{{$data->id ?? null}}" type="button" class="btn btn-primary">Lưu thay đổi</button>
                                        <button type="button" class="btn btn-secondary">Hủy</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </div>
                            <!--end::General-->
                            <!--begin::Security-->
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <h3 class="fw-bold">Thay đổi mật khẩu - Phân quyền</h3>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-6 profile_current_password_wrapper">
                                            <label for="profile_current_password" class="form-label">Mật khẩu hiện tại
                                                <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" id="profile_current_password"
                                                    name="profile_current_password" class="form-control border-right-0"
                                                    required="">
                                                <button
                                                    class="btn btn-ghost bg-transparent border border-start-0 border-gray-300"
                                                    type="button" data-ti-password-toggle="true"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="error-input mt-1"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-6 profile_new_password_wrapper">
                                            <label for="profile_new_password" class="form-label">Mật khẩu mới <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" id="profile_new_password"
                                                    name="profile_new_password" class="form-control border-right-0"
                                                    required="">
                                                <button
                                                    class="btn btn-ghost bg-transparent border border-start-0 border-gray-300"
                                                    type="button" data-ti-password-toggle="true"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="error-input mt-1"></p>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="profile_role" class="form-label">Phân quyền <span
                                                    class="text-danger">*</span></label>
                                            <select name="profile_role" id="profile_role" data-control="select2"
                                                data-hide-search="true" aria-label="Chọn phân quyền"
                                                data-placeholder="Chọn phân quyền" class="form-select">
                                                <option value=""></option>
                                                <option value="1">Chuyên viên</option>
                                                <option value="2">Admin</option>
                                            </select>
                                            <p class="text-muted italic">* Quản trị viên Admin có quyền cao nhất, có thẻ sử
                                                dụng tất cả các chức năng quản lý của hệ thống quản trị.</p>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="card-footer p-0">
                                    <!--begin::Actions-->
                                    <div class="ms-auto p-0 py-3 d-flex align-items-center justify-content-end gap-3">
                                        <button id="save_change_password" data-id="{{$data->id ?? null}}" type="button" class="btn btn-primary">Lưu thay đổi</button>
                                        <button type="button" class="btn btn-secondary">Hủy</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </div>
                            <!--end::Security-->
                        </div>

                    </div>
                    <!--end::User Form-->
                </div>
                <!--end::Card Body-->
                {{-- <div class="card-footer p-4">
                    <!--begin::Actions-->
                    <div class="ms-auto p-4 d-flex align-items-center justify-content-end gap-3">
                        <button id="11111" type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <button type="button" class="btn btn-secondary">Hủy</button>
                    </div>
                    <!--end::Actions-->
                </div> --}}
            </div>
            <!--end::Card-->
        </form>

    </div>
@endsection
