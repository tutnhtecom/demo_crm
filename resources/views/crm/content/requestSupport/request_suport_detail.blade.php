@extends('crm.layouts.layout')
@section('title', 'Yêu cầu hỗ trợ')
@section('header', 'Hỗ trợ')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Support ticket</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Yêu cầu hỗ trợ</li>
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
                    <a href="{{route('crm.request.support')}}" class="btn btn-ghost btn-sm">
                        <img src="assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                    </a>
                    <!--end:back button-->
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Chi tiết yêu cầu</h3>
                    <!--end::Title-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Body-->
            <div class="card-body py-6 px-10">
                <div class="d-flex flex-stack mb-6">
                    <h3>Thông tin yêu cầu dịch vụ</h3>
                    <div class="d-flex flex-stack">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label fw-bold text-nowrap mb-0">Trạng thái</label>
                            <select class="ticket_status_select w-auto form-select form-select-sm" data-ticket-id={{$data['data']['id']}}>
                                <option value="">__Chọn trạng thái__</option>
                                @if(isset($data_support_status) && count($data_support_status))
                                    @foreach($data_support_status as $k => $status)
                                        <option @if($data['data']["sp_status_id"] == $status['id']) selected @endif value="{{$status['id']}}"
                                            data-color="{{$status['color']}}"
                                            data-bg-color="{{$status['bg_color']}}"
                                            data-border-color="{{$status['border_color']}}"
                                        >
                                            {{$status['name']}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="vr d-none d-md-block text-gray-400 mx-4"></div>
                        <span>
                            <strong>Ngày tạo:</strong>
                                {{\Carbon\Carbon::parse($data['data']['created_at'])->setTimezone(env('APP_TIMEZONE'))->format('H:i')}}
                                {{\Carbon\Carbon::parse($data['data']['created_at'])->format('d/m/Y')}}
                        </span>
                        <div class="vr d-none d-md-block text-gray-400 mx-4"></div>
                        <span>
                            <strong>Cập nhật:</strong>
                            {{\Carbon\Carbon::parse($data['data']['updated_at'])->setTimezone(env('APP_TIMEZONE'))->format('H:i')}}
                            {{\Carbon\Carbon::parse($data['data']['updated_at'])->format('d/m/Y')}}
                        </span>
                    </div>
                </div>
                <div class="row gx-3">
                    <div class="col-12 col-md-3">
                        <div class="border rounded p-3">
                            <h4>Thông tin người gửi</h4>
                            <div class="d-flex align-items-center mt-2 mb-5">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px symbol-circle me-4">
                                    <img src="assets/crm/media/avatars/300-6.jpg" alt="" />
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Title-->
                                <div class="d-flex flex-column justify-content-start fw-semibold">
                                    <span class="fs-6 fw-semibold text-primary">
                                        <!-- @if(isset($data['data']['leads']))                                        
                                            {{$data['data']['leads']['full_name']}}
                                        @else
                                            {{$data['data']['full_name']}}
                                        @endif -->     
                                        
                                        {{isset($data['data']['full_name']) && strlen($data['data']['full_name']) > 0 ? $data['data']['full_name'] : 'Sinh viên tiềm năng mới'}}
                                    </span>
                                    <span class="fs-7 fw-semibold text-muted">
                                        @if(isset($data['data']['leads_code']))
                                            {{$data['data']['leads']['leads_code']}}
                                        @endif
                                    </span>
                                </div>
                                <!--end::Title-->
                            </div>
                            <div class="box_name_email flex-wrap d-flex text-sm gap-1 justify-content-center align-items-center">
                                <div class="input-group">
                                    <span class="input-group-text p-2 border border-primary bg-primary text-white"
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
                                        class="form-control btn btn-outline bg-primary bg-opacity-20 btn-outline-primary fs-8 px-1 py-1"
                                        aria-describedby="acc_phone" style="background:rgba(3, 78, 162, 0.15)!important;">
                                            <!-- @if(isset($data['data']['leads']))
                                                {{$data['data']['leads']['phone']}}
                                            @else
                                                {{$data['data']['phone']}}
                                            @endif -->

                                            {{isset($data['data']['phone']) && strlen($data['data']['phone']) > 0 ? $data['data']['phone'] : 'Chưa có'}}
                                    </button>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text p-2 border border-primary bg-primary text-white"
                                        id="acc_email">
                                        <svg width="18" height="18" viewBox="0 0 14 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <button type="button"
                                        class="form-control btn btn-outline bg-primary bg-opacity-20 btn-outline-primary fs-8 px-1 py-1"
                                        aria-describedby="acc_phone" style="background:rgba(3, 78, 162, 0.15)!important;">
                                            <!-- @if(isset($data['data']['leads']))
                                                {{$data['data']['leads']['email']}}
                                            @else
                                                {{$data['data']['email']}}
                                            @endif -->
                                            {{isset($data['data']['email']) && strlen($data['data']['email']) > 0 ? $data['data']['email'] : 'Chưa có'}}
                                    </button>
                                </div>
                            </div>
                            <div class="border-bottom border-gray-200 pt-6 mb-6 mx-n3"></div>
                            {{-- <div class="d-flex flex-column gap-3">
                                <div class="w-full d-flex align-items-center justify-content-between">
                                    <span class="text-muted">Trạng thái</span>
                                    <a href="javascript:void(0);" class="text-success">Mở</a>
                                </div>
                                <div class="w-full d-flex align-items-center justify-content-between">
                                    <span class="text-muted">Thời gian mở</span>
                                    <span>10 Tháng 4 • 17:49</span>
                                </div>
                                <div class="w-full d-flex align-items-center justify-content-between">
                                    <span class="text-muted">Thẻ</span>
                                    <span class="rounded-full border border-gray-300 text-gray-500 px-2">Hướng dẫn sử
                                        dụng</span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="d-flex flex-column gap-3 border rounded p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                                    fill="none">
                                    <path
                                        d="M21.25 25.625H8.75C5 25.625 2.5 23.75 2.5 19.375V10.625C2.5 6.25 5 4.375 8.75 4.375H21.25C25 4.375 27.5 6.25 27.5 10.625V19.375C27.5 23.75 25 25.625 21.25 25.625Z"
                                        stroke="#333333" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M21.25 11.25L17.3375 14.375C16.05 15.4 13.9375 15.4 12.65 14.375L8.75 11.25"
                                        stroke="#333333" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <h2 class="m-0 fs-2"> {{$data['data']['subject']}} </h2>
                            </div>
                            {{-- <div class="d-flex text-muted fs-7 gap-6 mt-2">
                                <span>#101 • Lan Anh</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 14 14" fill="none">
                                        <path
                                            d="M5.17749 7.63926L2.74205 4.59497C2.59045 4.40546 2.51464 4.3107 2.46074 4.20519C2.41292 4.11158 2.37796 4.01194 2.35683 3.90896C2.33301 3.7929 2.33301 3.67155 2.33301 3.42887V3.03366C2.33301 2.38026 2.33301 2.05357 2.46017 1.804C2.57202 1.58448 2.7505 1.406 2.97002 1.29415C3.21958 1.16699 3.54628 1.16699 4.19967 1.16699H9.79968C10.4531 1.16699 10.7798 1.16699 11.0293 1.29415C11.2489 1.406 11.4273 1.58448 11.5392 1.804C11.6663 2.05357 11.6663 2.38026 11.6663 3.03366V3.42887C11.6663 3.67155 11.6663 3.7929 11.6425 3.90896C11.6214 4.01194 11.5864 4.11158 11.5386 4.20519C11.4847 4.3107 11.4089 4.40546 11.2573 4.59496L8.82186 7.63926M2.91637 1.75032L6.99971 7.00032L11.083 1.75032M9.06207 7.8546C10.2011 8.99362 10.2011 10.8404 9.06207 11.9794C7.92305 13.1184 6.07631 13.1184 4.93728 11.9794C3.79825 10.8404 3.79825 8.99363 4.93728 7.8546C6.0763 6.71557 7.92304 6.71557 9.06207 7.8546Z"
                                            stroke="#7E7E7E" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    06/04/2024, 17:50
                                </span>
                            </div> --}}
                            <div class="border-bottom border-gray-200 pt-6 mb-6 mx-n3"></div>
                            <div class="rounded border borer-gray-200 bg-gray-100i p-6">
                                <div class="d-flex align-items-center mt-2 mb-5">
                                    <!--begin::Symbol-->
                                    <div class="position-relative symbol symbol-50px symbol-circle me-4">
                                        <img src="assets/crm/media/avatars/300-6.jpg" alt="" />
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge badge-outline rounded-pill border border-success text-success bg-white p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                viewBox="0 0 8 8" fill="none">
                                                <path d="M4 1.33301V6.66634M4 6.66634L6 4.66634M4 6.66634L2 4.66634"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Title-->
                                    <div class="d-flex flex-column justify-content-start fw-semibold">
                                        <span class="fs-5 fw-semibold">
                                            <!-- @if(isset($data['data']['leads']))
                                                {{$data['data']['leads']['full_name']}}
                                            @else
                                                {{$data['data']['full_name']}}
                                            @endif -->
                                            {{isset($data['data']['full_name']) && strlen($data['data']['full_name']) > 0 ? $data['data']['full_name'] : 'Sinh viên tiềm năng mới'}}
                                        </span>
                                        <span class="fs-6 fw-semibold text-muted">
                                            {{\Carbon\Carbon::parse($data['data']['created_at'])->format('d/m/Y')}}
                                        </span>
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <p>
                                    {{$data['data']['descriptions'] ?? null}}
                                </p>
                                <div>
                                    <h4>File được tải lên</h4>
                                    <div>      
                                        @if(!empty($data['data']['file_url']))
                                            <a href="{{ $data['data']['file_url'] ?? '' }}" target="_blank">File</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline btn-sm rounded-full btn-color-muted bg-white py-2 px-6" data-bs-toggle="modal" data-bs-target="#answer_suport_modal">
                                        Trả lời
                                    </button>
                                    @include('crm.content.requestSupport.modal_answer')
                                </div>
                            </div>
                            <div class="rounded border borer-gray-200 bg-white p-6">
                                <div class="d-flex align-items-center mt-2 mb-5">
                                    <!--begin::Symbol-->
                                    <div class="position-relative symbol symbol-50px symbol-circle me-4">
                                        <img src="assets/crm/media/svg/avatars/blank.svg" alt="" />
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge badge-outline rounded-pill border border-success text-success bg-white p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                viewBox="0 0 8 8" fill="none">
                                                <path d="M4 6.66699V1.33366M4 1.33366L6 3.33366M4 1.33366L2 3.33366"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Title-->
                                    <div class="d-flex flex-column justify-content-start fw-semibold">
                                        <span class="fs-5 fw-semibold"> {{$data['data']['employees'] ? $data['data']['employees']['name'] : 'Admin'}} </span>
                                        {{-- <span class="fs-6 fw-semibold text-muted">04 Tháng 4, 15:50 ( 1 phút trước )</span> --}}
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <p>
                                    {{$data['data']['answers'] ? $data['data']['answers'] : 'Chưa có câu trả lời.'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Content-->
    </div>
<script type="module" src="/assets/crm/js/htecomJs/supports.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/answerSuport.js"></script>
@endsection
