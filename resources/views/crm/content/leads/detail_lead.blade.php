@extends('crm.layouts.layout')

@section('header', 'Quản lý sinh viên tiềm năng mới')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thí sinh mới</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="{{ route('crm.leads.index') }}">Sinh viên tiềm năng</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Chi tiết thông tin thí sinh</li>
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
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <!--begin:back button-->
                        <a href="{{route('crm.leads.index')}}" class="btn btn-ghost btn-sm">
                            <img src="assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                        </a>
                        <!--end:back button-->
                        <!--begin::Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Chi tiết thông tin thí sinh</h3>
                        <!--end::Title-->
                    </div>
                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <!--begin:Action Buttons-->
                        <div class="d-flex align-items-center gy-2 gap-1 group_btn_detail_lead">
                            <button type="button" class="d-xl-none btn btn-sm btn-primary lh-0 d-flex flex-stack gap-1"
                                id="ti_candidate_details">
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
                            @php
                                $currentEmployeeId = auth()->user()->employees ? auth()->user()->employees->id : null;
                            @endphp

                            @if(auth()->user()->id != 1 && $currentEmployeeId == $dataId->employees->id)
                                <a href="javascript:void(0);" class="btn_connect_voip btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                                    <i class="fa fa-phone" style="width:18px;height:18px;"></i>
                                    <span class="d-none d-md-inline">Kết nối</span>
                                </a>
                            @endif
                            @php
                                $voipConfig = DB::table('config_voip')->orderBy('id')->first();
                            @endphp
                            <input id="voip_ip_sip" type="text" hidden value="{{  $voipConfig->voip_ip ?? '' }}">
                            <input id="voip_number_sip" type="text" hidden value="{{ $dataId->employees->lineVoip->line_id ?? NULL }}">
                            <input id="voip_password_sip" type="text" hidden value="{{ $dataId->employees->lineVoip->line_password ?? NULL }}">

                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ti_modal_new_ticket" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path opacity="0.3" d="M16.5 9C16.5 13.1421 13.1421 16.5 9 16.5C4.85786 16.5 1.5 13.1421 1.5 9C1.5 4.85786 4.85786 1.5 9 1.5C13.1421 1.5 16.5 4.85786 16.5 9Z" fill="white"></path>
                                    <path d="M9.5625 6.75C9.5625 6.43934 9.31066 6.1875 9 6.1875C8.68934 6.1875 8.4375 6.43934 8.4375 6.75L8.4375 8.43752H6.75C6.43934 8.43752 6.1875 8.68936 6.1875 9.00002C6.1875 9.31068 6.43934 9.56252 6.75 9.56252H8.4375V11.25C8.4375 11.5607 8.68934 11.8125 9 11.8125C9.31066 11.8125 9.5625 11.5607 9.5625 11.25L9.5625 9.56252H11.25C11.5607 9.56252 11.8125 9.31068 11.8125 9.00002C11.8125 8.68936 11.5607 8.43752 11.25 8.43752H9.5625V6.75Z" fill="white"></path>
                                </svg>
    
                                <span class="d-none d-md-inline">Yêu cầu mới</span>
                            </a>
                            @include('crm.content.leads.modal.modal_create_support_request')
                            
                            @if(auth()->user()->id == 1 || $currentEmployeeId == $dataId->employees->id || auth()->user()->employees->roles_id == 1)
                                <a href="{{ route('crm.lead.edit_lead', ['id' => $dataId->id]) }}"
                                    class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_lead_edit_lead">
                                    <svg width="18" height="18" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.89583 12.8334C1.89583 12.5917 2.0917 12.3959 2.33333 12.3959H11.6667C11.9083 12.3959 12.1042 12.5917 12.1042 12.8334C12.1042 13.075 11.9083 13.2709 11.6667 13.2709H2.33333C2.0917 13.2709 1.89583 13.075 1.89583 12.8334Z"
                                            fill="currentColor" />
                                        <path
                                            d="M6.72004 8.70851L6.72004 8.70851L10.1714 5.25711C9.70171 5.0616 9.14535 4.74045 8.61917 4.21428C8.09291 3.68802 7.77174 3.13156 7.57625 2.66178L4.12478 6.11325L4.12476 6.11326C3.85544 6.38259 3.72076 6.51726 3.60495 6.66575C3.46832 6.84091 3.35119 7.03044 3.25562 7.23097C3.1746 7.40097 3.11438 7.58165 2.99392 7.94301L2.35874 9.84857C2.29946 10.0264 2.34574 10.2225 2.47829 10.355C2.61084 10.4875 2.80689 10.5338 2.98472 10.4746L4.89028 9.83936C5.25163 9.71891 5.43232 9.65868 5.60232 9.57767C5.80285 9.4821 5.99238 9.36496 6.16754 9.22834C6.31602 9.11253 6.45071 8.97784 6.72004 8.70851Z"
                                            fill="currentColor" />
                                        <path
                                            d="M11.1292 4.29939C11.8458 3.58272 11.8458 2.42078 11.1292 1.70412C10.4125 0.98746 9.25056 0.98746 8.5339 1.70412L8.11995 2.11807C8.12562 2.13519 8.1315 2.15255 8.1376 2.17012C8.28933 2.60746 8.5756 3.18076 9.11414 3.7193C9.65268 4.25784 10.226 4.54412 10.6633 4.69585C10.6808 4.70192 10.6981 4.70777 10.7151 4.71342L11.1292 4.29939Z"
                                            fill="currentColor" />
                                    </svg>
                            
                                    <span>Sửa thông tin</span>
                                </a>
                            @endif
                            
                            {{-- <button type="button" class="btn btn-sm btn-secondary lh-0 d-flex align-items-center gap-1"
                                data-ti-button-action="lead-remove" data-ti-lead-confirm="true"
                                data-ti-lead-confirm-message="Xóa hồ sơ này" data-ti-lead-id="999" data-bs-toggle="modal" data-bs-target="#deleteItemModal">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.25 4.78948C2.25 4.42614 2.50904 4.13159 2.82857 4.13159L4.82675 4.13124C5.22377 4.1198 5.57401 3.83275 5.7091 3.40809C5.71266 3.39692 5.71674 3.38315 5.73139 3.33318L5.81749 3.03942C5.87018 2.8593 5.91608 2.70239 5.98031 2.56213C6.23407 2.00802 6.70356 1.62324 7.2461 1.52473C7.38343 1.49979 7.52886 1.4999 7.69579 1.50002H10.3043C10.4713 1.4999 10.6167 1.49979 10.754 1.52473C11.2966 1.62324 11.7661 2.00802 12.0198 2.56213C12.0841 2.70239 12.13 2.8593 12.1826 3.03942L12.2687 3.33318C12.2834 3.38315 12.2875 3.39692 12.291 3.40809C12.4261 3.83275 12.8458 4.12015 13.2429 4.13159H15.1714C15.491 4.13159 15.75 4.42614 15.75 4.78948C15.75 5.15282 15.491 5.44737 15.1714 5.44737H2.82857C2.50904 5.44737 2.25 5.15282 2.25 4.78948Z"
                                        fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.06907 8.61114C7.37819 8.5786 7.65384 8.816 7.68475 9.14139L8.05975 13.0888C8.09066 13.4141 7.86513 13.7043 7.55601 13.7368C7.24689 13.7694 6.97125 13.532 6.94033 13.2066L6.56533 9.25922C6.53442 8.93383 6.75995 8.64368 7.06907 8.61114Z"
                                        fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.931 8.61114C11.2401 8.64368 11.4657 8.93383 11.4348 9.25922L11.0598 13.2066C11.0288 13.532 10.7532 13.7694 10.4441 13.7368C10.135 13.7043 9.90942 13.4141 9.94033 13.0888L10.3153 9.14139C10.3462 8.816 10.6219 8.5786 10.931 8.61114Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M8.6967 16.5H9.3033C11.3903 16.5 12.4339 16.5 13.1123 15.8355C13.7908 15.1711 13.8602 14.0812 13.9991 11.9014L14.1991 8.76043C14.2744 7.57768 14.3121 6.98631 13.9717 6.61156C13.6313 6.23682 13.0565 6.23682 11.907 6.23682H6.09303C4.94345 6.23682 4.36866 6.23682 4.02829 6.61156C3.68792 6.98631 3.72558 7.57768 3.80091 8.76043L4.00094 11.9013C4.13977 14.0812 4.20919 15.1711 4.88767 15.8355C5.56615 16.5 6.60967 16.5 8.6967 16.5Z"
                                        fill="currentColor" />
                                </svg>

                                <span>Xóa</span>
                            </button> --}}
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Body-->
            <div class="card-body p-0">
                <div class="row gx-0">
                    <div class="col-12 col-xl-3 bg-gray-200 border border-gray-300">
                        <div class="row">
                            <div class="col-12 col-lg-7 col-xl-12">
                                <div
                                    class="d-flex flex-row flex-sm-row flex-wrap flex-md-column flex-lg-column flex-xxl-row flex-stack p-6 name_ava_lead_wrapper">
                                    <!--begin::Symbol-->
                                    <div class="symbol rounded-full overflow-hidden symbol-90px me-5 ava">
                                        <img src="{{$dataId->avatar ?? 'assets/crm/media/svg/avatars/blank.svg'}}" class="h-90 align-self-center"
                                            alt="">
                                    </div>
                                    <!--end::Symbol-->

                                    <!--begin::Section-->
                                    <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap name_lead">
                                        <!--begin:Candidate Name-->
                                        <div class="flex-grow-1 me-2">
                                            <h1 class="text-primary text-hover-primary fs-2 fs-xl-1 fw-bold">{{ $dataId->full_name ? $dataId->full_name : '' }}
                                            </h1>

                                            <span class="d-block fs-8">
                                                <span style="font-size: 14px;font-weight:700;">Trạng thái: </span>
                                                <span style="font-size: 14px;font-weight:600;" class="text-warning">
                                                    {{ $dataId->status ? $dataId->status->name : '' }}
                                            </span></span>
                                            <span class="d-flex gap-1 align-items-center d-block fs-6">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z"
                                                        fill="currentColor" />
                                                </svg>
                                                {{$dataId->address ? $dataId->address : ''}}
                                            </span>
                                            <span class="d-flex gap-1 align-items-center d-block fs-6">
                                                <i class="">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.52085 1.45837C4.52085 1.21675 4.32498 1.02087 4.08335 1.02087C3.84173 1.02087 3.64585 1.21675 3.64585 1.45837V2.37961C2.80624 2.44684 2.25505 2.61184 1.8501 3.01679C1.44516 3.42174 1.28015 3.97293 1.21292 4.81254H12.7871C12.7199 3.97293 12.5549 3.42174 12.1499 3.01679C11.745 2.61184 11.1938 2.44684 10.3542 2.37961V1.45837C10.3542 1.21675 10.1583 1.02087 9.91669 1.02087C9.67506 1.02087 9.47919 1.21675 9.47919 1.45837V2.3409C9.09112 2.33337 8.65612 2.33337 8.16669 2.33337H5.83335C5.34392 2.33337 4.90893 2.33337 4.52085 2.3409V1.45837Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M1.16669 7.00004C1.16669 6.5106 1.16669 6.07561 1.17421 5.68754H12.8258C12.8334 6.07561 12.8334 6.5106 12.8334 7.00004V8.16671C12.8334 10.3666 12.8334 11.4665 12.1499 12.15C11.4665 12.8334 10.3666 12.8334 8.16669 12.8334H5.83335C3.63347 12.8334 2.53352 12.8334 1.8501 12.15C1.16669 11.4665 1.16669 10.3666 1.16669 8.16671V7.00004ZM9.91669 8.16671C10.2389 8.16671 10.5 7.90554 10.5 7.58337C10.5 7.26121 10.2389 7.00004 9.91669 7.00004C9.59452 7.00004 9.33335 7.26121 9.33335 7.58337C9.33335 7.90554 9.59452 8.16671 9.91669 8.16671ZM9.91669 10.5C10.2389 10.5 10.5 10.2389 10.5 9.91671C10.5 9.59454 10.2389 9.33337 9.91669 9.33337C9.59452 9.33337 9.33335 9.59454 9.33335 9.91671C9.33335 10.2389 9.59452 10.5 9.91669 10.5ZM7.58335 7.58337C7.58335 7.90554 7.32219 8.16671 7.00002 8.16671C6.67785 8.16671 6.41669 7.90554 6.41669 7.58337C6.41669 7.26121 6.67785 7.00004 7.00002 7.00004C7.32219 7.00004 7.58335 7.26121 7.58335 7.58337ZM7.58335 9.91671C7.58335 10.2389 7.32219 10.5 7.00002 10.5C6.67785 10.5 6.41669 10.2389 6.41669 9.91671C6.41669 9.59454 6.67785 9.33337 7.00002 9.33337C7.32219 9.33337 7.58335 9.59454 7.58335 9.91671ZM4.08335 8.16671C4.40552 8.16671 4.66669 7.90554 4.66669 7.58337C4.66669 7.26121 4.40552 7.00004 4.08335 7.00004C3.76119 7.00004 3.50002 7.26121 3.50002 7.58337C3.50002 7.90554 3.76119 8.16671 4.08335 8.16671ZM4.08335 10.5C4.40552 10.5 4.66669 10.2389 4.66669 9.91671C4.66669 9.59454 4.40552 9.33337 4.08335 9.33337C3.76119 9.33337 3.50002 9.59454 3.50002 9.91671C3.50002 10.2389 3.76119 10.5 4.08335 10.5Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </i>


                                                Ngày tạo: {{ \Carbon\Carbon::parse($dataId->created_at)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                        <!--end:Candidate Name-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                            </div>
                            <div class="col-12 col-lg-5 col-xl-12 d-block d-xl-none">
                                <div
                                    class="d-flex flex-column flex-sm-row flex-md-column align-items-center justify-content-center h-100 gap-4 p-4">
                                    <div class="input-group min-w-150px">
                                        <span class="input-group-text border border-primary bg-primary text-white px-2"
                                            id="acc_phone">
                                            <svg width="18" height="18" viewBox="0 0 19 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_268_11637)">
                                                    <path
                                                        d="M12.6097 10.9108L12.2682 11.2704C12.2682 11.2704 11.4562 12.1252 9.23997 9.79192C7.02371 7.45863 7.83565 6.60381 7.83565 6.60381L8.05077 6.37733C8.58068 5.81943 8.63064 4.92372 8.16831 4.26983L7.22257 2.93221C6.65034 2.12287 5.5446 2.01596 4.88871 2.70648L3.71151 3.94585C3.3863 4.28824 3.16837 4.73209 3.19479 5.22445C3.2624 6.48409 3.80066 9.19429 6.80415 12.3564C9.98923 15.7097 12.9778 15.8429 14.1998 15.7223C14.5864 15.6842 14.9226 15.4757 15.1935 15.1905L16.2589 14.0688C16.978 13.3117 16.7753 12.0136 15.8551 11.484L14.4222 10.6592C13.8181 10.3115 13.082 10.4136 12.6097 10.9108Z"
                                                        fill="white" />
                                                    <path
                                                        d="M10.8872 1.41012C10.9369 1.10345 11.2268 0.895419 11.5335 0.945068C11.5524 0.948701 11.6135 0.960116 11.6455 0.967243C11.7095 0.981496 11.7988 1.00344 11.9101 1.03586C12.1327 1.10069 12.4436 1.20749 12.8168 1.3786C13.5641 1.72116 14.5584 2.32042 15.5903 3.35227C16.6221 4.38412 17.2214 5.37848 17.5639 6.12568C17.735 6.4989 17.8418 6.80985 17.9067 7.03243C17.9391 7.14374 17.961 7.23301 17.9753 7.297C17.9824 7.32901 17.9876 7.3547 17.9913 7.37368L17.9956 7.39708C18.0452 7.70375 17.8391 8.00564 17.5324 8.05528C17.2266 8.10479 16.9385 7.89776 16.8877 7.59254C16.8861 7.58434 16.8818 7.56232 16.8772 7.54156C16.8679 7.50002 16.8519 7.43415 16.8266 7.34704C16.7758 7.17279 16.6876 6.91379 16.5413 6.59453C16.2489 5.9568 15.7232 5.07616 14.7948 4.14776C13.8664 3.21936 12.9857 2.69362 12.348 2.40125C12.0287 2.25488 11.7697 2.16673 11.5955 2.11597C11.5084 2.0906 11.3989 2.06547 11.3573 2.05622C11.0521 2.00535 10.8377 1.71591 10.8872 1.41012Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.0569 3.99722C11.1423 3.69851 11.4536 3.52555 11.7523 3.61089L11.5978 4.15175C11.7523 3.61089 11.7523 3.61089 11.7523 3.61089L11.7534 3.6112L11.7545 3.61153L11.757 3.61226L11.7629 3.614L11.7777 3.61862C11.789 3.62224 11.8031 3.62695 11.82 3.63292C11.8537 3.64487 11.8982 3.66187 11.9528 3.68528C12.062 3.7321 12.2113 3.80442 12.3947 3.91295C12.7618 4.13021 13.263 4.4911 13.8517 5.07982C14.4404 5.66855 14.8013 6.16969 15.0186 6.53679C15.1271 6.72018 15.1994 6.86947 15.2462 6.97874C15.2696 7.03334 15.2866 7.07786 15.2986 7.11154C15.3046 7.12838 15.3093 7.1425 15.3129 7.15381L15.3175 7.16865L15.3193 7.17447L15.32 7.17697L15.3203 7.17812C15.3203 7.17812 15.3206 7.1792 14.7798 7.33373L15.3206 7.1792C15.406 7.4779 15.233 7.78924 14.9343 7.87458C14.6381 7.9592 14.3295 7.78988 14.2411 7.49584L14.2384 7.48775C14.2344 7.47649 14.2261 7.4543 14.2122 7.4219C14.1844 7.35714 14.1341 7.25122 14.0504 7.10978C13.8832 6.82722 13.5812 6.40028 13.0562 5.87532C12.5312 5.35036 12.1043 5.04833 11.8217 4.8811C11.6803 4.79739 11.5744 4.74706 11.5096 4.71931C11.4772 4.70543 11.455 4.69715 11.4438 4.69315L11.4357 4.69038C11.1416 4.60197 10.9723 4.29339 11.0569 3.99722Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_268_11637">
                                                        <rect width="18" height="18" fill="white"
                                                            transform="translate(0.942627)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                        </span>
                                        <button type="button"
                                            class="form-control btn btn-outline bg-primary bg-opacity-20 btn-outline-primary fs-7 px-1"
                                            aria-describedby="acc_phone" data-phone="{{ $dataId->phone ? $dataId->phone : '' }}">{{ $dataId->phone ? $dataId->phone : '' }}</button>
                                    </div>
                                    <div class="input-group min-w-150px">
                                        <span class="input-group-text border border-primary bg-primary text-white px-2"
                                            id="acc_email">
                                            <svg width="18" height="18" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <button type="button"
                                            class="form-control btn btn-outline bg-primary bg-opacity-20 btn-outline-primary fs-7 px-1"
                                            aria-describedby="acc_phone">{{ $dataId->email ? $dataId->email : '' }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-xl-9 border-bottom border-gray-300">
                        <div class="d-flex overflow-x-auto flex-stack h-100 gap-4 py-9 ">
                            {{-- <div class="d-flex flex-column align-items-start justify-content-start h-100 text-left px-6">
                                <span>Thẻ</span>
                                <span
                                    class="border border-gray-300 text-gray-500 rounded-full text-center px-4 py-1 fs-7 text-nowrap">Đăng
                                    ký tư vấn</span>
                            </div> --}}
                            <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                            <div class="d-flex flex-column align-items-start justify-content-start h-100 text-left">
                                <div class="fw-bold text-nowrap">Tư vấn viên phụ trách</div>
                                <div class="d-flex flex-stack py-2">
                                    <!--begin::Symbol-->
                                    <div class="symbol rounded-full overflow-hidden symbol-40px me-2">
                                        @php
                                            $latestFile = $dataId->employees->files
                                                ->where('types', 0)
                                                ->where('deleted_at', null)
                                                ->sortByDesc('updated_at')
                                                ->first();
                                        @endphp
                                    
                                        @if ($latestFile)
                                            <img src="{{ $latestFile->image_url }}" alt="img_employees">
                                        @endif
                                    </div>
                                    <!--end::Symbol-->

                                    <!--begin::Section-->
                                    <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap text-nowrap">
                                        <!--begin:Candidate Name-->
                                        <div class="flex-grow-1 me-2">
                                            <span class="fs-5 fw-bold"> {{$dataId->employees->name ?? 'Không có nhân viên tư vấn'}} </span>

                                            <span class="d-block text-muted fs-6">{{$dataId->employees->code ?? '-'}}</span>

                                        </div>
                                        <!--end:Candidate Name-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                            </div>
                            <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                            <div
                                class="d-flex flex-column align-items-center justify-content-start h-100 px-6  text-nowrap">
                                <span>Liên hệ qua điện thoại</span>
                                <span class="fs-1 text-primary total_data_call"></span>
                            </div>
                            <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                            {{-- <div
                                class="d-flex flex-column align-items-center justify-content-start h-100 px-6  text-nowrap">
                                <span>Liên hệ qua SMS</span>
                                <span class="fs-1 text-primary">12</span>
                            </div>
                            <div class="vr d-none d-md-block text-gray-400 mx-8"></div> --}}

                            {{-- <div
                                class="d-flex flex-column align-items-center justify-content-start h-100 ps-6 pe-14  text-nowrap">
                                <span>Liên hệ qua Mail</span>
                                <span class="fs-1 text-primary">0</span>
                            </div> --}}
                            {{-- <div class="vr d-none d-md-block text-gray-400 mx-8"></div> --}}
                        </div>
                    </div>
                </div>
                <div class="row gx-0">
                    <div class="col-3 d-none d-xl-block border-start border-end border-gray-300">
                        <div
                            class="box_name_email d-flex overflow-x-auto hover-scroll-overlay-x flex-column flex-md-column flex-lg-column flex-xl-column flex-xxl-row gap-2 justify-content-center align-items-center border-bottom bg-gray-200 border-gray-300 p-4">
                            <div class="input-group w-auto">
                                <span class="input-group-text border border-primary bg-primary text-white px-2"
                                    id="acc_phone">
                                    <svg width="18" height="18" viewBox="0 0 19 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_268_11637)">
                                            <path
                                                d="M12.6097 10.9108L12.2682 11.2704C12.2682 11.2704 11.4562 12.1252 9.23997 9.79192C7.02371 7.45863 7.83565 6.60381 7.83565 6.60381L8.05077 6.37733C8.58068 5.81943 8.63064 4.92372 8.16831 4.26983L7.22257 2.93221C6.65034 2.12287 5.5446 2.01596 4.88871 2.70648L3.71151 3.94585C3.3863 4.28824 3.16837 4.73209 3.19479 5.22445C3.2624 6.48409 3.80066 9.19429 6.80415 12.3564C9.98923 15.7097 12.9778 15.8429 14.1998 15.7223C14.5864 15.6842 14.9226 15.4757 15.1935 15.1905L16.2589 14.0688C16.978 13.3117 16.7753 12.0136 15.8551 11.484L14.4222 10.6592C13.8181 10.3115 13.082 10.4136 12.6097 10.9108Z"
                                                fill="white" />
                                            <path
                                                d="M10.8872 1.41012C10.9369 1.10345 11.2268 0.895419 11.5335 0.945068C11.5524 0.948701 11.6135 0.960116 11.6455 0.967243C11.7095 0.981496 11.7988 1.00344 11.9101 1.03586C12.1327 1.10069 12.4436 1.20749 12.8168 1.3786C13.5641 1.72116 14.5584 2.32042 15.5903 3.35227C16.6221 4.38412 17.2214 5.37848 17.5639 6.12568C17.735 6.4989 17.8418 6.80985 17.9067 7.03243C17.9391 7.14374 17.961 7.23301 17.9753 7.297C17.9824 7.32901 17.9876 7.3547 17.9913 7.37368L17.9956 7.39708C18.0452 7.70375 17.8391 8.00564 17.5324 8.05528C17.2266 8.10479 16.9385 7.89776 16.8877 7.59254C16.8861 7.58434 16.8818 7.56232 16.8772 7.54156C16.8679 7.50002 16.8519 7.43415 16.8266 7.34704C16.7758 7.17279 16.6876 6.91379 16.5413 6.59453C16.2489 5.9568 15.7232 5.07616 14.7948 4.14776C13.8664 3.21936 12.9857 2.69362 12.348 2.40125C12.0287 2.25488 11.7697 2.16673 11.5955 2.11597C11.5084 2.0906 11.3989 2.06547 11.3573 2.05622C11.0521 2.00535 10.8377 1.71591 10.8872 1.41012Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.0569 3.99722C11.1423 3.69851 11.4536 3.52555 11.7523 3.61089L11.5978 4.15175C11.7523 3.61089 11.7523 3.61089 11.7523 3.61089L11.7534 3.6112L11.7545 3.61153L11.757 3.61226L11.7629 3.614L11.7777 3.61862C11.789 3.62224 11.8031 3.62695 11.82 3.63292C11.8537 3.64487 11.8982 3.66187 11.9528 3.68528C12.062 3.7321 12.2113 3.80442 12.3947 3.91295C12.7618 4.13021 13.263 4.4911 13.8517 5.07982C14.4404 5.66855 14.8013 6.16969 15.0186 6.53679C15.1271 6.72018 15.1994 6.86947 15.2462 6.97874C15.2696 7.03334 15.2866 7.07786 15.2986 7.11154C15.3046 7.12838 15.3093 7.1425 15.3129 7.15381L15.3175 7.16865L15.3193 7.17447L15.32 7.17697L15.3203 7.17812C15.3203 7.17812 15.3206 7.1792 14.7798 7.33373L15.3206 7.1792C15.406 7.4779 15.233 7.78924 14.9343 7.87458C14.6381 7.9592 14.3295 7.78988 14.2411 7.49584L14.2384 7.48775C14.2344 7.47649 14.2261 7.4543 14.2122 7.4219C14.1844 7.35714 14.1341 7.25122 14.0504 7.10978C13.8832 6.82722 13.5812 6.40028 13.0562 5.87532C12.5312 5.35036 12.1043 5.04833 11.8217 4.8811C11.6803 4.79739 11.5744 4.74706 11.5096 4.71931C11.4772 4.70543 11.455 4.69715 11.4438 4.69315L11.4357 4.69038C11.1416 4.60197 10.9723 4.29339 11.0569 3.99722Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_268_11637">
                                                <rect width="18" height="18" fill="white"
                                                    transform="translate(0.942627)" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                </span>
                                @if(auth()->user()->id != 1 && $currentEmployeeId == $dataId->employees->id)
                                    <button type="button"
                                        class="form-control openDialer btn_call_voip btn btn-outline bg-opacity-20 btn-outline-primary fs-7 px-2"
                                        aria-describedby="acc_phone" data-phone="{{ $dataId->phone ? $dataId->phone : '' }}">{{ $dataId->phone ? $dataId->phone : '' }}</button>
                                @else
                                    <button type="button"
                                    class="form-control openDialer btn btn-outline bg-opacity-20 btn-outline-primary fs-7 px-2"
                                    aria-describedby="acc_phone" data-phone="{{ $dataId->phone ? $dataId->phone : '' }}" disabled>{{ $dataId->phone ? $dataId->phone : '' }}</button>
                                @endif
                            </div>
                            @include('crm.content.modalVoip.modal_voip_24h')
                            <div class="input-group w-auto min-w-150px">
                                <span class="input-group-text border border-primary bg-primary text-white px-2"
                                    id="acc_email">
                                    <svg width="18" height="18" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <button type="button"
                                    class="form-control btn btn-outline bg-opacity-20 btn-outline-primary fs-7 px-2"
                                    aria-describedby="acc_phone">{{ $dataId->email ? $dataId->email : '' }}</button>
                            </div>
                        </div>
                        <div class="d-flex flex-column ">
                            <div class="accordion accordion-borderless accordion-crm" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Thông tin chung
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne">
                                        <div class="accordion-body pt-1">
                                            <div class="rounded border border-gray-200 p-4">
                                                <div class="row gy-2">
                                                    <div class="col-6 text-gray-700"><i class="fas fa-user"></i> Họ và tên</div>
                                                    <div class="col-6">{{ $dataId->full_name ? $dataId->full_name : '' }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-user"></i> Mã số sinh viên </div>
                                                    <div class="col-6">{{ $dataId->leads_code ? $dataId->leads_code : '' }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-phone-volume"></i>
                                                        Số điện thoại</div>
                                                    <div class="col-6">{{ $dataId->phone ? $dataId->phone : '' }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-envelope"></i> Email
                                                    </div>
                                                    <div class="col-6">{{ $dataId->email ? $dataId->email : '' }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-calendar-days"></i>
                                                        Ngày sinh</div>
                                                    <div class="col-6">{{ $dataId->date_of_birth ? \Carbon\Carbon::parse($dataId->date_of_birth)->format('d/m/Y') : '' }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-mars-and-venus"></i>
                                                        Giới tính</div>
                                                    <div class="col-6">{{ $dataId->gender_name }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-address-card"></i>
                                                        CMND/CCCD</div>
                                                    @php
                                                        $number = $dataId->identification_card ? $dataId->identification_card : '';
                                                        if(strlen($number) > 0) {
                                                            $maskedNumber = substr($number, 0, 4) . str_repeat('*', strlen($number) - 7) . substr($number, -3);
                                                        } else  {
                                                            $maskedNumber = '' ;
                                                        }
                                                    @endphp
                                                    <div class="col-6">{{ $maskedNumber }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="true"
                                            aria-controls="collapseTwo">
                                            Thông tin khác
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse show"
                                        aria-labelledby="headingTwo">
                                        <div class="accordion-body pt-1">
                                            <div class="rounded border border-gray-200 p-4">
                                                <div class="row gy-2">
                                                    <div class="col-6 text-gray-700"><i class="fas fa-layer-group"></i>
                                                        Nguồn</div>
                                                    <div class="col-6">{{ $dataId->sources->name ?? ''}}</div>
                                                    @if(!empty($dataId['tags_name']))
                                                        <div class="col-6 text-gray-700"><i class="fas fa-tag"></i>
                                                            Gắn thẻ</div>
                                                        <div class="col-6">{{ $dataId['tags_name'] ?? ''}}</div>
                                                    @endif
                                                    <div class="col-6 text-gray-700"><i class="fas fa-calendar-days"></i>
                                                        Ngày tạo</div>
                                                    <div class="col-6">{{ \Carbon\Carbon::parse($dataId->created_at)->format('H:i') }} • {{ \Carbon\Carbon::parse($dataId->created_at)->format('d/m/Y') }}</div>
                                                    <div class="col-6 text-gray-700"><i
                                                            class="fas fa-graduation-cap"></i>Ngành học quan tâm</div>
                                                    <div class="col-6">{{ $dataId->marjors ? $dataId->marjors->name : ''}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="true"
                                            aria-controls="collapseThree">
                                            Thông tin phụ huynh
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse show"
                                        aria-labelledby="headingThree">
                                        <div class="accordion-body pt-1">
                                            <div class="rounded border border-gray-200 p-4">
                                                @foreach ($dataId->family as $family)
                                                    @if ($family->type == 0)
                                                        <div class="row gy-2">
                                                            <div class="col-6 text-gray-700"><i class="fas fa-user"></i> Họ tên
                                                                cha</div>
                                                            <div class="col-6">{{ $family->full_name ?? null }}</div>
                                                            <div class="col-6 text-gray-700"><i class="fas fa-phone-volume"></i>
                                                                Số điện thoại</div>
                                                            <div class="col-6">{{ $family->phone_number ?? null  }}</div>
                                                        </div>
                                                        <hr class="border-dashed border-gray-400" />
                                                    @elseif ($family->type == 1)
                                                        <div class="row gy-2">
                                                            <div class="col-6 text-gray-700"><i class="fas fa-user"></i> Họ tên mẹ</div>
                                                            <div class="col-6">{{ $family->full_name ?? null }}</div>
                                                            <div class="col-6 text-gray-700"><i class="fas fa-phone-volume"></i>
                                                                Số điện thoại</div>
                                                            <div class="col-6">{{ $family->phone_number ?? null  }}</div>
                                                        </div>
                                                        <hr class="border-dashed border-gray-400" />
                                                    @endif
                                                @endforeach
                                                {{-- <div class="row gy-2">
                                                    <div class="col-6 text-gray-700"><i class="fas fa-user"></i> Họ tên
                                                        mẹ</div>
                                                    <div class="col-6">Nguyễn Thị C</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-phone-volume"></i>
                                                        Số điện thoại</div>
                                                    <div class="col-6">0123.456.789</div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="true"
                                            aria-controls="collapseFour">
                                            Hộ khẩu thường trú
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse show"
                                        aria-labelledby="headingFour">
                                        <div class="accordion-body pt-1">
                                            <div class="rounded border border-gray-200 p-4">
                                                @foreach ($dataId->contacts as $contact)
                                                @if ($contact->type == 1)
                                                <div class="row gy-2">
                                                    <div class="col-6 text-gray-700"><i class="fas fa-location-dot"></i>
                                                        Tỉnh / Thành phố</div>
                                                    <div class="col-6">{{ $contact->provinces_name ?? null  }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-location-dot"></i>
                                                        Quận / Huyện</div>
                                                    <div class="col-6">{{ $contact->districts_name ?? null  }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-location-dot"></i>
                                                        Phường / Xã</div>
                                                    <div class="col-6">{{ $contact->wards_name ?? null  }}</div>
                                                    <div class="col-6 text-gray-700"><i class="fas fa-location-dot"></i>
                                                        Địa chỉ</div>
                                                    <div class="col-6">
                                                        {{ $contact->address ?? null  }}
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFive" aria-expanded="true"
                                            aria-controls="collapseFive">
                                            Phương thức xét tuyển
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse show"
                                        aria-labelledby="headingFive">
                                        <div class="accordion-body pt-1">
                                            <div class="rounded border border-gray-200 p-4">
                                                @foreach ($dataId->score as $score)
                                                    <div class="row gy-2">
                                                        <div class="col-12 text-gray-700 fw-bold">
                                                            {{$score->method_adminssions->name ?? ''}}
                                                        </div>

                                                        @if($score->point_gpa == null)
                                                            @php
                                                                $subjectText = $score->block_adminssion->subject;

                                                                if (strpos($subjectText, ':') !== false) {
                                                                    $subjectText = explode(': ', $subjectText)[1];
                                                                }

                                                                $subjectArray = explode(', ', $subjectText);

                                                                $scores = [$score->score1, $score->score2, $score->score3];
                                                                $combinedArray = [];
                                                                foreach ($subjectArray as $index => $subject) {
                                                                    $combinedArray[] = [
                                                                        'subject' => $subject,
                                                                        'score' => $scores[$index] ?? null
                                                                    ];
                                                                }
                                                            @endphp

                                                            @foreach ($combinedArray as $subject)
                                                                <div class="col-6 text-gray-700">
                                                                    {{$subject['subject']}}
                                                                </div>
                                                                <div class="col-6"> {{$subject['score']}} </div>
                                                            @endforeach
                                                        @elseif($score->block_adminssions_id == null)
                                                            <div class="col-6 text-gray-700">
                                                                Hệ số
                                                            </div>
                                                            <div class="col-6"> {{$score->point_gpa ?? ''}} </div>

                                                            <div class="col-6 text-gray-700">
                                                                Điểm trung bình
                                                            </div>
                                                            <div class="col-6">{{$score->score_avg ?? ''}}</div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="true"
                                            aria-controls="collapseSix">
                                            File được tải lên
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse show"
                                        aria-labelledby="headingSix">
                                        <div class="accordion-body pt-1">
                                            <div class="rounded border border-gray-200 p-4">
                                                @if($dataId->files)
                                                    @foreach ($dataId->files as $file)
                                                    <div class="row gy-2">
                                                        <div class="col-12 text-gray-700">
                                                            <a href="{{ url('/') }}/{{ltrim($file->image_url, '/')}}">
                                                                {{$file->title }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-9">
                        <div class="d-flex flex-column justify-content-start p-4">
                            <ul class="crm_tabs nav nav-tabs nav-small-tabs" role="tablist">
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
                                        <span>Lịch sử tương tác</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="custom-fields-tab" data-bs-toggle="tab"
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
                                        <span>Trường tùy chỉnh</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="learning-fee-tab" data-bs-toggle="tab" data-email-tmp="TYPE_PRICE_LISTS" data-email-tmp-id="3"
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
                                        <span>Học phí</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="transactions-tab" data-bs-toggle="tab"
                                        data-bs-target="#transactions" type="button" role="tab"
                                        aria-controls="transactions" aria-selected="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 18 18" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.3125 10.875C12.3805 10.875 11.625 11.6305 11.625 12.5625C11.625 13.4945 12.3805 14.25 13.3125 14.25C14.2445 14.25 15 13.4945 15 12.5625C15 11.6305 14.2445 10.875 13.3125 10.875ZM10.5 12.5625C10.5 11.0092 11.7592 9.75 13.3125 9.75C14.8658 9.75 16.125 11.0092 16.125 12.5625C16.125 13.1357 15.9535 13.6689 15.659 14.1135L16.3352 14.7898C16.5549 15.0094 16.5549 15.3656 16.3352 15.5852C16.1156 15.8049 15.7594 15.8049 15.5398 15.5852L14.8635 14.909C14.4189 15.2035 13.8857 15.375 13.3125 15.375C11.7592 15.375 10.5 14.1158 10.5 12.5625Z"
                                                fill="currentColor" />
                                            <path
                                                d="M7.5 3H10.5C13.3284 3 14.7426 3 15.6213 3.87868C16.254 4.51134 16.4311 5.42162 16.4807 6.9375H1.51929C1.56889 5.42162 1.74602 4.51134 2.37868 3.87868C3.25736 3 4.67157 3 7.5 3Z"
                                                fill="currentColor" />
                                            <path
                                                d="M7.5 15H10.22C9.6908 14.3296 9.375 13.4829 9.375 12.5625C9.375 10.3879 11.1379 8.625 13.3125 8.625C14.621 8.625 15.7805 9.2633 16.4965 10.2455C16.5 9.86375 16.5 9.44975 16.5 9C16.5 8.66855 16.5 8.35652 16.4986 8.0625H1.50141C1.5 8.35652 1.5 8.66855 1.5 9C1.5 11.8284 1.5 13.2426 2.37868 14.1213C3.25736 15 4.67157 15 7.5 15Z"
                                                fill="currentColor" />
                                            <path
                                                d="M3.9375 12C3.9375 11.6893 4.18934 11.4375 4.5 11.4375H7.5C7.81066 11.4375 8.0625 11.6893 8.0625 12C8.0625 12.3107 7.81066 12.5625 7.5 12.5625H4.5C4.18934 12.5625 3.9375 12.3107 3.9375 12Z"
                                                fill="currentColor" />
                                        </svg>
                                        <span>Giao dịch</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content mt-2" id="myTabContent">
                                <!--begin::Lịch sử tương tác-->
                                @include('crm.content.leads.interact_tabs')
                                <!--end::Lịch sử tương tác-->
                                <!--begin::Trường tùy chỉnh-->
                                @include('crm.content.leads.options_tab')
                                <!--end::Trường tùy chỉnh-->
                                <!--begin::Học phí-->
                                @include('crm.content.leads.price_list_tab')
                                <!--end::Học phí-->
                                <!--begin::Giao dịch-->
                                @include('crm.content.leads.transaction_tab')
                                <!--end::Giao dịch-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Content-->
    </div>

    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
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
                        <button id="btn_delete_item" data-type="lead" type="button" class="btn btn-primary" data-id="{{$dataId->id}}">Xác nhận</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@include('crm.content.leads.modal.modal_price_list')

@endsection
