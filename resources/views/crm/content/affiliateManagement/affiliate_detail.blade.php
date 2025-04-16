@extends('crm.layouts.layout')
@section('header', 'Chi tiết đơn vị liên kết')
@section('title', 'Chi tiết đơn vị liên kết')
@section('content')
<div class="px-6">
    <div class="app_breadcrumb d-flex align-items-center justify-content-between">
        <div class="x-3 py-4">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý đơn vị liên kết</li>
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <li class="breadcrumb-item text-primary">Chi tiết đơn vị liên kết</li>
            </ul>
        </div>

    </div>

    <div class="card">
        <div class="card-header p-4">
            <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                <div class="d-flex align-items-center">
                    <a href="{{ route('crm.affiliate.sources') }}" class="btn btn-ghost btn-sm">    
                        <img src="assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                    </a>
                    <h3 class="card-title text-dark fw-bolder m-md-0">Chi tiết thông tin đơn vị liên kết</h3>
                </div> 
                <div class="d-flex align-items-center"></div>
                <div class="d-flex align-items-center"></div>
                <div class="d-flex align-items-center"></div>
                <!-- <div class="d-flex align-items-end">
                    <button id="btn_export_details" type="button" class="btn btn-primary lh-0 d-flex align-items-center gap-1" data-id="{{$data['id']}}">
                        <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                        <span class="d-none d-md-block">Xuất chi tiết</span>
                    </button>
                </div>                -->
                <div class="d-flex justify-content-end">
                    <div class="d-flex align-items-center gy-2 gap-1">
                        <button type="button" class="d-xl-none btn btn-sm btn-primary lh-0 d-flex flex-stack gap-1" id="ti_candidate_details">
                            <i class="ki-duotone ki-burger-menu-2 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                                <span class="path7"></span>
                                <span class="path8"></span>
                                <span class="path9"></span>
                                <span class="path10"></span>
                            </i>
                            Xem thông tin
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="row gx-0">
                <!-- Thông tin Đơn vị đối tác -->
                <div class="col-12 bg-gray-200 border border-gray-300" style="height:max-content">
                    <div class="row gx-0">
                        <div class="col-12">
                            <div class="p-6">
                                <div class="">
                                    <div class="row gx-0">
                                        <!-- Cột trái -->
                                        <!--------------------------------------------------------------------------->
                                        <div class="col-6 p-2">
                                            <!-- Dòng tiêu đề -->
                                            <div class="row mb-2">
                                                <div class="col-lg-6 col-md-6">
                                                    <h3 class="text-primary text-hover-primary fs-2 fs-xl-1 fw-bold">
                                                        {{ $data['name'] }}
                                                    </h3>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="d-flex align-items-center gy-2 gap-1 justify-content-end">
                                                        <a href="/candidate/add-new.html" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1"
                                                            data-bs-toggle="modal" data-bs-target="#affiliateEditModal">
                                                            <span class="d-none d-md-block py-2 px-1">Sửa</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Phân loại -->
                                            <div class="row gx-0 mb-3 border-and-color py-1">
                                                <div class="col-4 fw-bold">Phân loại:</div>
                                                <div class="col-8"><span class="">{{ $data['sources_types'] }}</span></div>
                                            </div>
                                            <!-- Mã ĐVLK -->
                                            <div class="row gx-0 mb-3 border-and-color pb-1">
                                                <div class="col-4 fw-bold">Mã ĐVLK:</div>
                                                <div class="col-8">
                                                    <span class="">{{ $data['code'] }}</span>
                                                </div>
                                            </div>
                                            <!-- Địa phương -->
                                            <div class="row gx-0 mb-3 border-and-color py-1">
                                                <div class="col-4 fw-bold">Địa phương:</div>
                                                <div class="col-8"><span class="">{{ $data['location_name'] }}</span></div>
                                            </div>
                                            <!-- Thông tin lãnh đạo -->
                                            <div class="row gx-0 mb-3 border-and-color pb-1">
                                                <div class="col-12 fw-bold ">Lãnh đạo:</div>
                                                <div class="col-12">
                                                    @php
                                                        $managers = json_decode($data['sources_manager_name'], true);
                                                    @endphp
                                                    @foreach ($managers as $manager)
                                                    <div class="row gx-0 mb-3 border-and-color py-2">
                                                        <div class="col-4">Họ và tên: </div>
                                                        <div class="col-8"> {{$manager['name']}} </div>
                                                    </div>
                                                    <div class="row gx-0 mb-3 border-and-color pb-2">
                                                        <div class="col-4">Chức vụ: </div>
                                                        <div class="col-8"> {{$manager['positions']}} </div>
                                                    </div>
                                                    <div class="row gx-0 mb-3 border-and-color pb-2">
                                                        <div class="col-4">Email: </div>
                                                        <div class="col-8"> {{$manager['email']}} </div>
                                                    </div>
                                                    <div class="row gx-0 mb-3">
                                                        <div class="col-4">Số điện thoại: </div>
                                                        <div class="col-8"> {{$manager['phone']}} </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!--------------------------------------------------------------------------->
                                        <!-- Cột phải -->
                                        <div class="col-6 p-3">
                                            <div class="row mb-3 border-and-color pb-1">
                                                <div class="col-12 fw-bold">
                                                    <h6 class="text-dark text-hover-primary fs-4">Nhân sự đầu mối:</h6>
                                                </div>
                                                <div class="col-12 my-3">
                                                    @php
                                                    $employees = json_decode($data['sources_employees_name'], true);                                                    
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($employees as $employee)
                                                        <div class="mb-3">
                                                            <p class="mb-4 style_font_text_employees"> Nhân sự {{$count++}} </p>
                                                            <div class="row mb-3 border-and-color pb-1">
                                                                <div class="col-4">Họ và tên: </div>
                                                                <div class="col-8"> {{$employee['name']}} </div>
                                                            </div>
                                                            <div class="row mb-3 border-and-color pb-1">
                                                                <div class="col-4">Chức vụ: </div>
                                                                <div class="col-8"> {{$employee['positions']}} </div>
                                                            </div>
                                                            <div class="row mb-3 border-and-color pb-1">
                                                                <div class="col-4">Email: </div>
                                                                <div class="col-8"> {{$employee['email']}} </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-4">Số điện thoại: </div>
                                                                <div class="col-8"> {{$employee['phone']}} </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!--------------------------------------------------------------------------->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Thông tin hợp đồng, danh sách sinh viên, thông tin hoa hồng, tab 4 -->
                <div class="col-12 border-bottom border-gray-300">
                    <div class="d-flex flex-column justify-content-start p-4">
                        <ul class="crm_tabs nav nav-tabs nav-small-tabs" role="tablist">
                            <!-- Tab hợp đồng -->
                            <li class="nav-item">
                                <button class="nav-link active" id="activities-history-tab" data-bs-toggle="tab"
                                    data-bs-target="#activities-history" type="button" role="tab"
                                    aria-controls="activities-history" aria-selected="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 14 14" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.253 9C9.53438 9 8.95181 9.57563 8.95181 10.2857C8.95181 10.9958 9.53438 11.5714 10.253 11.5714C10.9716 11.5714 11.5542 10.9958 11.5542 10.2857C11.5542 9.57563 10.9716 9 10.253 9ZM8.08434 10.2857C8.08434 9.10225 9.05529 8.14286 10.253 8.14286C11.4507 8.14286 12.4217 9.10225 12.4217 10.2857C12.4217 10.7225 12.2895 11.1287 12.0624 11.4675L12.873 12.2684C13.0423 12.4358 13.0423 12.7071 12.873 12.8745C12.7036 13.0418 12.429 13.0418 12.2596 12.8745L11.449 12.0735C11.1061 12.2979 10.695 12.4286 10.253 12.4286C9.05529 12.4286 8.08434 11.4692 8.08434 10.2857Z"
                                            fill="currentColor" />
                                        <path
                                            d="M4.3253 1.42857C4.3253 1.19188 4.13111 1 3.89157 1C3.65202 1 3.45783 1.19188 3.45783 1.42857V2.331C2.62545 2.39686 2.079 2.5585 1.67754 2.95518C1.27607 3.35187 1.11249 3.89181 1.04584 4.71429H12.5204C12.4538 3.89181 12.2902 3.35187 11.8887 2.95518C11.4873 2.5585 10.9408 2.39686 10.1084 2.331V1.42857C10.1084 1.19188 9.91424 1 9.6747 1C9.43515 1 9.24096 1.19188 9.24096 1.42857V2.29309C8.85623 2.28571 8.42498 2.28571 7.93976 2.28571H5.62651C5.14128 2.28571 4.71003 2.28571 4.3253 2.29309V1.42857Z"
                                            fill="currentColor" />
                                        <path
                                            d="M12.5663 6.85714V8C12.5663 8.1173 12.5663 8.23141 12.5662 8.34243C12.0093 7.69585 11.1796 7.28571 10.253 7.28571C8.5762 7.28571 7.21687 8.62886 7.21687 10.2857C7.21687 11.2013 7.63195 12.021 8.28631 12.5713C8.17395 12.5714 8.05847 12.5714 7.93976 12.5714H5.62651C3.44555 12.5714 2.35507 12.5714 1.67754 11.902C1 11.2325 1 10.155 1 8V6.85714C1 6.37769 1 5.95158 1.00746 5.57143H12.5588C12.5663 5.95158 12.5663 6.37769 12.5663 6.85714Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span>Hợp đồng</span>
                                </button>
                            </li>
                            <!-- Danh sách sinh viên -->
                            <li class="nav-item">
                                <button class="nav-link" id="leads_by_sources" data-bs-toggle="tab"
                                    data-id={{$data['id']}}
                                    data-bs-target="#custom-fields" type="button" role="tab"
                                    aria-controls="custom-fields" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 18 18" fill="none">
                                        <path
                                            d="M6.55692 2H11.443C11.6057 1.99996 11.7305 1.99993 11.8396 2.0106C12.615 2.08646 13.2498 2.55271 13.5189 3.18074H4.481C4.75016 2.55271 5.38488 2.08646 6.16036 2.0106C6.26942 1.99993 6.39419 1.99996 6.55692 2Z"
                                            fill="currentColor" />
                                        <path
                                            d="M5.01736 3.90618C4.04393 3.90618 3.24574 4.49401 2.97937 5.27384C2.97382 5.29009 2.96849 5.30643 2.96341 5.32285C3.24211 5.23845 3.53216 5.18332 3.82579 5.14567C4.58205 5.04872 5.53779 5.04877 6.64801 5.04883L6.73092 5.04883L11.4725 5.04883C12.5827 5.04877 13.5384 5.04872 14.2947 5.14567C14.5883 5.18332 14.8784 5.23845 15.1571 5.32285C15.152 5.30643 15.1467 5.29009 15.1411 5.27384C14.8748 4.49401 14.0766 3.90618 13.1031 3.90618H5.01736Z"
                                            fill="currentColor" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.67068 5.87943H11.3293C13.6917 5.87943 14.8729 5.87943 15.5364 6.57021C16.1999 7.26099 16.0438 8.32822 15.7315 10.4627L15.4355 12.4868C15.1906 14.1607 15.0682 14.9976 14.4402 15.4988C13.8121 16 12.8858 16 11.0332 16H6.96675C5.11416 16 4.18787 16 3.55984 15.4988C2.9318 14.9976 2.80938 14.1607 2.56454 12.4868L2.26846 10.4627C1.95624 8.32822 1.80013 7.26099 2.46362 6.57021C3.12712 5.87943 4.3083 5.87943 6.67068 5.87943ZM6.2 13.2001C6.2 12.9102 6.46117 12.6751 6.78333 12.6751H11.2167C11.5388 12.6751 11.8 12.9102 11.8 13.2001C11.8 13.4901 11.5388 13.7251 11.2167 13.7251H6.78333C6.46117 13.7251 6.2 13.4901 6.2 13.2001Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span>Danh sách Sinh viên</span>
                                </button>
                            </li>
                            <!-- Thông tin hoa hồng -->
                            <li class="nav-item">
                                <button class="nav-link" id="learning_fee_tab" data-bs-toggle="tab" data-id={{$data['id']}}
                                    data-bs-target="#learning-fee" type="button" role="tab"
                                    aria-controls="learning-fee" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 18 18" fill="none">
                                        <path
                                            d="M15.706 6.1416C16.1411 6.57155 16.3283 7.11289 16.4158 7.75583C16.5 8.3751 16.5 9.16248 16.5 10.1393V10.2177C16.5 11.1946 16.5 11.982 16.4158 12.6012C16.3283 13.2442 16.1411 13.7855 15.706 14.2155C15.2709 14.6454 14.7231 14.8303 14.0724 14.9168C13.4457 15 12.6488 15 11.6602 15H7.9665C6.9779 15 6.18106 15 5.55435 14.9168C4.90368 14.8303 4.35583 14.6454 3.92071 14.2155C3.65674 13.9546 3.48402 13.6528 3.36945 13.3121C4.02305 13.393 4.83165 13.393 5.7659 13.3929H9.52304C10.4843 13.393 11.3125 13.393 11.9757 13.3049C12.6865 13.2105 13.3679 12.9976 13.9205 12.4515C14.4731 11.9054 14.6886 11.2322 14.7842 10.5298C14.8734 9.87448 14.8733 9.05611 14.8733 8.10629V7.96522C14.8733 7.04184 14.8734 6.24267 14.7914 5.59676C15.1363 5.70996 15.4419 5.88066 15.706 6.1416Z"
                                            fill="currentColor" />
                                        <path
                                            d="M7.64447 6.78574C6.94581 6.78574 6.37943 7.34539 6.37943 8.03575C6.37943 8.72611 6.94581 9.28576 7.64447 9.28576C8.34313 9.28576 8.90951 8.72611 8.90951 8.03575C8.90951 7.34539 8.34313 6.78574 7.64447 6.78574Z"
                                            fill="currentColor" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.13518 4.37763C1.5 5.00527 1.5 6.01543 1.5 8.03575C1.5 10.0561 1.5 11.0662 2.13518 11.6939C2.77036 12.3215 3.79266 12.3215 5.83727 12.3215H9.45167C11.4963 12.3215 12.5186 12.3215 13.1538 11.6939C13.7889 11.0662 13.7889 10.0561 13.7889 8.03575C13.7889 6.01543 13.7889 5.00527 13.1538 4.37763C12.5186 3.75 11.4963 3.75 9.45167 3.75H5.83727C3.79266 3.75 2.77036 3.75 2.13518 4.37763ZM5.29511 8.03575C5.29511 6.75365 6.34696 5.7143 7.64447 5.7143C8.94199 5.7143 9.99383 6.75365 9.99383 8.03575C9.99383 9.31785 8.94199 10.3572 7.64447 10.3572C6.34696 10.3572 5.29511 9.31785 5.29511 8.03575ZM11.6203 10.0001C11.3209 10.0001 11.0781 9.7602 11.0781 9.46433V6.60717C11.0781 6.3113 11.3209 6.07145 11.6203 6.07145C11.9197 6.07145 12.1625 6.3113 12.1625 6.60717V9.46433C12.1625 9.7602 11.9197 10.0001 11.6203 10.0001ZM3.12648 9.46433C3.12648 9.7602 3.36921 10.0001 3.66864 10.0001C3.96806 10.0001 4.2108 9.7602 4.2108 9.46433L4.2108 6.60717C4.2108 6.3113 3.96806 6.07145 3.66864 6.07145C3.36921 6.07145 3.12648 6.3113 3.12648 6.60717L3.12648 9.46433Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span>Thông tin Hoa hồng</span>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content mt-2" id="myTabContent">
                            <!-- Hợp đồng -->
                            @include('crm.content.affiliateManagement.component.affiliate_contract')
                            <!--Danh sách sinh viên-->
                            @include('crm.content.affiliateManagement.component.affiliate_list_students')
                            <!-- Thông tin hoa hồng -->
                            @include('crm.content.affiliateManagement.component.affiliate_learning_fee')
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-0">
            </div>
        </div>
    </div>
</div>
@include('crm.content.affiliateManagement.affiliate_modal_delete_sources_rate')
@include('crm.content.affiliateManagement.affiliate_modal_create_sources_rate')
@include('crm.content.affiliateManagement.affiliate_modal_edit_sources_rate')
@include('crm.content.affiliateManagement.affiliate_modal_edit_contract')
@include('crm.content.affiliateManagement.affiliate_modal_edit_sources_rate')
@include('crm.content.affiliateManagement.component.affiliate_modal_edit')


<script type="module" src="/assets/crm/js/htecomJs/addNewContract.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/editContract.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/affiliateSource.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/learningFee.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/deleteAffiliateSourceDocument.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/editSourcesRate.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/export_overview_affiliate.js"></script>
@endsection