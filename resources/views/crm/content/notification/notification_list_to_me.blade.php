@extends('crm.layouts.layout')

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
                    <li class="breadcrumb-item text-primary">Thông báo</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->
        </div>
        <!--end::App Breadcrumb-->
        <!--begin::Content-->
        <div class="card bg-transparent">
            <!--begin::Toolbar-->
            <div class="card-header pt-4 px-0">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Thông báo</h3>
                    <!--end::Title-->
                    <!--begin::Search & Sort-->
                    <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-0 mb-3 mb-md-0">
                        <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                        <form class="w-100 position-relative mb-lg-0" autocomplete="off" action="{{ route('crm.notification.list') }}" method="GET">
                            <!--begin::Hidden input(Added to disable form autocomplete)-->
                            <input type="hidden" />
                            <!--end::Hidden input-->
                            <!--begin::Icon-->
                            <i
                                class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <!--end::Icon-->
                            <!--begin::Input-->
                            <input type="text" name="search" value="{{ request()->get('search') }}" placeholder="Tìm kiếm..." class="search-input form-control form-control-sm border border-gray-300 rounded h-lg-40px ps-13">
                            <!--end::Input-->
                            <!--begin::Spinner-->
                            <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
                                <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                            </span>
                            <!--end::Spinner-->
                            <!--begin::Reset-->
                            <span
                                class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4">
                                <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <!--end::Reset-->
                        </form>
                        <!--end::Form-->
                        {{-- <div class="vr d-none d-md-block text-gray-400 mx-4"></div>
                        <div class="d-flex align-items-center justify-content-start">
                            <select class="lead_ordering_select w-auto form-select form-select-sm">
                                <option value="date-desc">Mới nhất</option>
                                <option value="date-asc">Cũ nhất</option>
                            </select>
                        </div> --}}
                    </div>
                    <!--begin::Search & Sort-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Body-->
            <div class="card-body py-0 px-0">
                <div class="d-flex flex-column gap-4" id="notifications_table">
                    <!--begin::Blog Item-->

                    @if (empty($data))
                        <div class="d-flex flex-nowrap gap-2 border border-gray-200 bg-white shadow-sm rounded-3 p-2">
                            <p class="p-5">Không có thông báo nào</p>
                        </div>
                    @else
                        @foreach ($data as $notification)
                        @if($notification != null)
                            <div class="d-flex flex-nowrap gap-2 border border-gray-200 bg-white shadow-sm rounded-3 p-2">
                                <div class="vr d-none d-md-block text-gray-400"></div>
                                <div class="symbol symbol-100px rounded noti_img">
                                    @php
                                        preg_match('/<img[^>]+>/i', $notification->content, $imgTag);
                                    @endphp
                                    @if (!empty($imgTag))
                                        {!! $imgTag[0] !!}
                                    @else
                                        <img src="assets/image/logo-favicon.ico" class="w-100px h-100px"/>
                                    @endif
                                </div>
                                <div class="d-flex flex-column flex-grow-1 align-items-start">
                                    <span class="d-flex align-items-center gap-1 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path
                                                d="M6.99984 3.5V7L9.33317 8.16666M12.8332 7C12.8332 10.2217 10.2215 12.8333 6.99984 12.8333C3.77818 12.8333 1.1665 10.2217 1.1665 7C1.1665 3.77834 3.77818 1.16666 6.99984 1.16666C10.2215 1.16666 12.8332 3.77834 12.8332 7Z"
                                                stroke="#7E7E7E" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($notification->created_at)->format('H:i') }} • {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y') }}
                                    </span>
                                    <a href="{{ route('crm.notification.detail', ['id' => $notification->id]) }}">
                                        <h3 class="mb-2 text_link_title_noti">{!! $notification->title !!}</h3>
                                    </a>
                                    <p class="text-base">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($notification->content), 400) !!}
                                    </p>
                                </div>
                                <div class="vr d-none d-md-block text-gray-400"></div>
                                <div class="align-self-center btn_delete_noti_wrapper">
                                    <button type="button" class="btn btn-ghost crm_notification_delete" data-bs-toggle="modal" data-bs-target="#deleteNotiModal{{$notification->id}}">
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

                                    <!-- Modal Delete Noti-->
                                    <div class="modal fade modal_delete" id="deleteNotiModal{{$notification->id}}" tabindex="-1" aria-labelledby="deleteNotiModal{{$notification->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog" style="margin-top:160px;">
                                            <div class="modal-content" style="max-width: 444px">
                                                <div class="">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <img src="assets/crm/media/svg/crm/danger-triange.svg" alt="">
                                                    </div>
                                                    <div class="d-flex justify-content-center align-items-center" style="font-size:24px;font-weight:600;margin-bottom:15px;"> Xóa mục này? </div>
                                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                                        <button id="" type="button" class="btn btn-primary btn_delete_noti" data-id="{{$notification->id}}">Xác nhận</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    </div>
                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Modal Delete Noti-->
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-nowrap gap-2 border border-gray-200 bg-white shadow-sm rounded-3 p-2">
                                <p class="p-5">Không có thông báo nào</p>
                            </div> 
                        @endif
                        @endforeach
                    @endif

                    <!--end::Blog Item-->

                    <!--begin::Pagination-->
                    <div class="row px-6">
                        <div class="col-3 d-flex align-items-center">
                            {{-- <div class="form-check form-check-sm cursor-pointer">
                                <input class="form-check-input" type="checkbox" value="" id="select_all"
                                    data-select-all="true" data-target="notifications_table">
                                <label class="form-check-label text-gray-900" for="select_all">
                                    Chọn tất cả
                                </label>
                            </div> --}}
                        </div>
                        @if ($data->isEmpty())
                            <p>- Bạn không có thông báo nào -</p>
                        @else
                            <div class="col-6 py-5">
                                <nav aria-label="Pagination">
                                    <ul class="pagination">
                                        @if ($data->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Trang trước</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $data->previousPageUrl() . '&search=' . request()->get('search') }}" tabindex="-1">Trang trước</a>
                                            </li>
                                        @endif

                                        @for ($i = 1; $i <= $data->lastPage(); $i++)
                                            <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $data->url($i) . '&search=' . request()->get('search') }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if ($data->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $data->nextPageUrl() . '&search=' . request()->get('search') }}">Trang tiếp</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Trang tiếp</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @endif

                        <div class="col-3"><!--placeholder--></div>
                    </div>
                    <!--end::Pagination-->
                </div>

            </div>
            <!--end::Body-->
        </div>
        <!--end::Content-->
    </div>
@endsection
