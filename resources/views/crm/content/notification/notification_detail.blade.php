@extends('crm.layouts.layout')
@section('title', 'Quản lý thông báo')
@section('header', 'Quản lý thông báo')
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
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Thông báo</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Chi tiết thông báo</li>
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
                    <a href="{{route('crm.notification.list')}}" class="btn btn-ghost btn-sm">
                        <img src="/assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                    </a>
                    <!--end:back button-->
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Chi tiết thông báo</h3>
                    <!--end::Title-->

                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Body-->
            <div class="card-body py-6 px-10">
                <div class="d-flex flex-column align-items-start">
                    <span class="d-flex align-items-center gap-1 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                            fill="none">
                            <g clip-path="url(#clip0_289_16512)">
                                <path
                                    d="M6.99984 3.5V7L9.33317 8.16666M12.8332 7C12.8332 10.2217 10.2215 12.8333 6.99984 12.8333C3.77818 12.8333 1.1665 10.2217 1.1665 7C1.1665 3.77834 3.77818 1.16666 6.99984 1.16666C10.2215 1.16666 12.8332 3.77834 12.8332 7Z"
                                    stroke="#7E7E7E" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_289_16512">
                                    <rect width="14" height="14" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        {{ \Carbon\Carbon::parse($data->original['data']['created_at'])->format('H:i') }} • {{ \Carbon\Carbon::parse($data->original['data']['created_at'])->format('d/m/Y') }}
                    </span>
                    <h1 class="my-4">{!!$data->original['data']['title']!!}</h1>
                    <div id="content" class="content text-gray-600">
                       {!! $data->original['data']['content'] !!}
                    </div>

                </div>

            </div>
            <!--end::Body-->
        </div>
        <!--end::Content-->
    </div>
@endsection
