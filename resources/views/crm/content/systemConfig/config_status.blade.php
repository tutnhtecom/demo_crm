{{-- <!DOCTYPE html> --}}
@extends('crm.layouts.layout')

@section('header', 'Cấu hình')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Cấu hình hệ thống</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Trạng thái</li>
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
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Trạng thái quản lý thí sinh mới, sinh viên chính thức
                    </h3>
                    <!--end::Title-->

                    <!--begin::Search & Sort-->
                    <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-2 mb-3 mb-md-0">
                        <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                        <form class="w-100 position-relative mb-lg-0" autocomplete="off">
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
                            <input id="search_input_status" type="text"
                                class="search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13"
                                name="search" value="" placeholder="Tìm kiếm..." />
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
                        <div class="vr d-none d-md-block text-gray-400 mx-4"></div>
                        {{-- <div class="d-flex align-items-center justify-content-start">
                            <select class="lead_ordering_select w-auto form-select">
                                <option value="date-desc">Mới nhất</option>
                                <option value="date-asc">Cũ nhất</option>
                            </select>
                        </div> --}}

                    </div>
                    <!--begin::Search & Sort-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">

                        <!--begin:Action Buttons-->
                        <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ti_modal_add_status"
                                class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 18 18"
                                    fill="none">
                                    <path opacity="0.3"
                                        d="M16.5 9C16.5 13.1421 13.1421 16.5 9 16.5C4.85786 16.5 1.5 13.1421 1.5 9C1.5 4.85786 4.85786 1.5 9 1.5C13.1421 1.5 16.5 4.85786 16.5 9Z"
                                        fill="white" />
                                    <path
                                        d="M9.5625 6.75C9.5625 6.43934 9.31066 6.1875 9 6.1875C8.68934 6.1875 8.4375 6.43934 8.4375 6.75L8.4375 8.43752H6.75C6.43934 8.43752 6.1875 8.68936 6.1875 9.00002C6.1875 9.31068 6.43934 9.56252 6.75 9.56252H8.4375V11.25C8.4375 11.5607 8.68934 11.8125 9 11.8125C9.31066 11.8125 9.5625 11.5607 9.5625 11.25L9.5625 9.56252H11.25C11.5607 9.56252 11.8125 9.31068 11.8125 9.00002C11.8125 8.68936 11.5607 8.43752 11.25 8.43752H9.5625V6.75Z"
                                        fill="white" />
                                </svg>

                                <span class="d-none d-md-inline">Thêm mới</span>
                            </a>
                            {{-- <button type="button" class="btn btn-sm btn-secondary lh-0 d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 18 18"
                                    fill="none">
                                    <path
                                        d="M2.25 4.78948C2.25 4.42614 2.50904 4.13159 2.82857 4.13159L4.82675 4.13124C5.22377 4.1198 5.57401 3.83275 5.7091 3.40809C5.71266 3.39692 5.71674 3.38315 5.73139 3.33318L5.81749 3.03942C5.87018 2.8593 5.91608 2.70239 5.98031 2.56213C6.23407 2.00802 6.70356 1.62324 7.2461 1.52473C7.38343 1.49979 7.52886 1.4999 7.69579 1.50002H10.3043C10.4713 1.4999 10.6167 1.49979 10.754 1.52473C11.2966 1.62324 11.7661 2.00802 12.0198 2.56213C12.0841 2.70239 12.13 2.8593 12.1826 3.03942L12.2687 3.33318C12.2834 3.38315 12.2875 3.39692 12.291 3.40809C12.4261 3.83275 12.8458 4.12015 13.2429 4.13159H15.1714C15.491 4.13159 15.75 4.42614 15.75 4.78948C15.75 5.15282 15.491 5.44737 15.1714 5.44737H2.82857C2.50904 5.44737 2.25 5.15282 2.25 4.78948Z"
                                        fill="#333333" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.06907 8.61138C7.37819 8.57884 7.65384 8.81624 7.68475 9.14163L8.05975 13.089C8.09066 13.4144 7.86513 13.7045 7.55601 13.7371C7.24689 13.7696 6.97125 13.5322 6.94033 13.2068L6.56533 9.25946C6.53442 8.93408 6.75995 8.64392 7.06907 8.61138Z"
                                        fill="#333333" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.931 8.61138C11.2401 8.64392 11.4657 8.93408 11.4348 9.25946L11.0598 13.2068C11.0288 13.5322 10.7532 13.7696 10.4441 13.7371C10.135 13.7045 9.90942 13.4144 9.94033 13.089L10.3153 9.14163C10.3462 8.81624 10.6219 8.57884 10.931 8.61138Z"
                                        fill="#333333" />
                                    <path opacity="0.3"
                                        d="M8.6967 16.5H9.3033C11.3903 16.5 12.4339 16.5 13.1123 15.8355C13.7908 15.1711 13.8602 14.0812 13.9991 11.9014L14.1991 8.76043C14.2744 7.57768 14.3121 6.98631 13.9717 6.61156C13.6313 6.23682 13.0565 6.23682 11.907 6.23682H6.09303C4.94345 6.23682 4.36866 6.23682 4.02829 6.61156C3.68792 6.98631 3.72558 7.57768 3.80091 8.76043L4.00094 11.9013C4.13977 14.0812 4.20919 15.1711 4.88767 15.8355C5.56615 16.5 6.60967 16.5 8.6967 16.5Z"
                                        fill="#333333" />
                                </svg>

                                <span class="d-none d-md-inline">Xóa</span>
                            </button> --}}
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->

            </div>
            <!--end::Toolbar-->
            <!--begin::Card Body-->
            <div class="card-body p-4 overflow-x-auto">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <!--begin::Table-->
                    <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100"
                        id="table_status">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-nowrap align-middle fs-5 text-start px-4">Tên trạng thái</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Màu sắc</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Ngày tạo</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Người tạo</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!isset($data['message']))
                                @foreach ($data['data'] as $status)
                                    <tr>
                                        <td class="align-middle px-2 px-md-4 py-4 text-primary"> {{$status['name']}} </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="rounded px-3 py-2" style="color:{{$status['color']}};border:1px solid {{$status['border_color']}};background-color:{{$status['bg_color']}};">
                                                {{ $status['name'] }}
                                            </span>
                                        </td>
                                        <td class="align-middle px-2 px-md-4 py-4 text-center">
                                            {{ $status['created_at'] ? \Carbon\Carbon::parse($status['created_at'])->format('d/m/Y') : '-'  }}
                                        </td>
                                        <td class="align-middle px-2 px-md-4 py-4 text-center">
                                            @if ($status['created_by'] == 1 && $status['created_by'] != null)
                                                Admin
                                            @elseif ($status['created_by'] != null)
                                                Nhân viên
                                            @endif
                                            {{-- {{ $status['created_by'] ?? '-' }} --}}
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($status['is_default'] == 1)
                                                <p></p>
                                            @else
                                                <button type="button" class="btn btn-ghost p-1"
                                                    onClick="setStatus('{{ $status['name'] }}', '{{$status['color']}}', 'ti_form_edit_status{{$status['id']}}')"
                                                    data-bs-toggle="modal" data-bs-target="#editStatusModal{{$status['id']}}" data-name-status="{{ $status['name'] }}" data-color-status="{{$status['color']}}">
                                                    <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                                        height="18" />
                                                </button>
                                                @include('crm.content.systemConfig.modal_edit_status')

                                                <button type="button" class="btn btn-ghost p-1"
                                                    data-ti-row-confirm-message="Xóa hồ sơ này?" data-ti-button-action="row-remove"
                                                    data-ti-row-confirm="true" data-bs-toggle="modal" data-bs-target="#deleteStatusModal{{$status['id']}}">
                                                    <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                                        height="18" />
                                                </button>
                                                @include('crm.content.systemConfig.modal_delete_status')
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <div class="status_description">*<i>Trạng thái mặc định</i> ảnh hướng đến hiển thị tiến độ ở trang đăng ký hồ sơ của thí sinh nên không thể sửa/ xoá.</div>
                <!--begin::Pagination-->
                {{-- <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-check form-check-sm cursor-pointer">
                            <input class="form-check-input" type="checkbox" value="" name="select_all"
                                id="select_all" data-select-all="true" data-target="table">
                            <label class="form-check-label text-gray-900" for="select_all">
                                Chọn tất cả
                            </label>
                        </div>
                    </div>
                    <div class="col-9 data-color=</di">
                        <!--placeholder-->
                    </div>

                </div> --}}
                <!--end::Pagination-->
            </div>
            <!--end::Card Body-->
        </div>
        <!--end::Content-->
    </div>

    @include('crm.content.systemConfig.modal_add_status')

    <script type="application/javascript">
        function setStatus(status, color, parent_id) {
            var $parent = $('#' + parent_id)
            $parent.find('input[name="status_name"]').val(status);
            // Add color to edit form
            if (color) {
                $parent.find('.color_place').html('<span class="d-flex gap-2 badge badge-light badge-full text-white" style="background-color: '+color+'">'+status+' <button type="button" class="btn btn-ghost btn-xs text-gray-200 fs-4 p-0 remove_color">&times;</button></span>');
            }
        }
        $(document).ready(function() {
            $(document).on('click', '.ti_menu_colors button', function (e) {
                e.preventDefault();

                var $parent = $(this).closest('form').parent();
                var status_name = $parent.find('input[name="status_name"]').val();

                if (!status_name || status_name.trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng chọn trạng thái trước khi chọn màu',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }

                var selected_color = $(this).data('color');
                $parent.find('button i').addClass('invisible');
                $(this).find('i').removeClass('invisible');
                $parent.find('.ti_menu_colors').removeClass('show').removeAttr('style');
                $parent.find('[data-ti-menu-trigger]').removeClass('show').removeClass('menu-dropdown');

                var $input = $parent.find('.color_place input');
                $input.hide();

                $parent.find('.color_place').html('<span class="d-flex gap-2 badge badge-light badge-full text-white" style="background-color: '+selected_color+'">'+status_name+' <button type="button" class="btn btn-ghost btn-xs text-gray-200 fs-4 p-0 remove_color">&times;</button></span>');
            });
            // Set remove color in color_place
            $(document).on('click', '.color_place .remove_color', function (e) {
                e.preventDefault();
                var $parent = $(this).closest('.color_place');
                $parent.html('<input type="text" class="form-control border-0 py-0 px-0" placeholder="Chọn màu"/>');
            });
        });
    </script>
@endsection

