<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý nhân viên')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý nhân viên</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Quản lý lịch và giao việc</li>
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
                        <!--begin::Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách công việc</h3>
                        <!--end::Title-->
                    </div>

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">

                        <!--begin:Action Buttons-->
                        <div class="d-flex align-items-center gy-2 gap-1">
                            {{-- <select class="lead_ordering_select w-auto form-select">
                                <option value="date-desc">Mới nhất</option>
                                <option value="date-asc">Cũ nhất</option>
                            </select> --}}
                            <button type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_task_target_create"
                                data-bs-toggle="modal" data-bs-target="#ti_modal_job_assign">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 18 18"
                                    fill="none">
                                    <path opacity="0.3"
                                        d="M7.92051 1.6875C7.83538 1.68749 7.76912 1.68748 7.70643 1.69128C6.9111 1.73944 6.21466 2.24141 5.91746 2.98069C5.89351 3.04027 5.87222 3.10397 5.84375 3.18938C5.78124 3.35763 5.63779 3.54899 5.43691 3.70189C5.41454 3.71892 5.39209 3.73499 5.36963 3.75013L6.82613 3.75C6.84777 3.70533 6.86773 3.65991 6.88585 3.61381L6.887 3.61119L6.89013 3.60376L6.89379 3.59467L6.89723 3.5857L6.89995 3.57824L6.90129 3.57448L6.90447 3.5653L6.90734 3.55683L6.90891 3.55213L6.91096 3.54587L6.91264 3.5406L6.91398 3.53626C6.9431 3.44904 6.95261 3.42185 6.96127 3.40032C7.09636 3.06428 7.41292 2.83611 7.77444 2.81422C7.79863 2.81275 7.82829 2.8125 7.93582 2.8125H10.0641C10.1717 2.8125 10.2013 2.81275 10.2255 2.81422C10.587 2.83611 10.9036 3.06428 11.0387 3.40032C11.0472 3.42153 11.0563 3.44773 11.0858 3.53624L11.0871 3.54053L11.0888 3.54584L11.0909 3.5521L11.0924 3.5568L11.0953 3.56525L11.0985 3.57441L11.0998 3.57817L11.1025 3.58561L11.1059 3.59453L11.1096 3.60354L11.1126 3.61087L11.1138 3.61358C11.132 3.65976 11.152 3.70525 11.1736 3.75L12.63 3.75013C12.6076 3.735 12.5852 3.71893 12.5628 3.70192C12.362 3.54904 12.2186 3.35769 12.156 3.18941L12.1538 3.1826C12.1269 3.10185 12.1059 3.03895 12.0825 2.98069C11.7853 2.24141 11.0888 1.73944 10.2935 1.69128C10.2308 1.68748 10.1646 1.68749 10.0794 1.6875H7.92051Z"
                                        fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.8943 3.75H5.10574C3.84021 3.75 3.20744 3.75 2.72451 3.99729C2.30432 4.21244 1.96244 4.55432 1.74729 4.97451C1.5 5.45744 1.5 6.09021 1.5 7.35574C1.5 7.67747 1.5 7.83833 1.55502 7.97395C1.60307 8.09238 1.68059 8.19657 1.78022 8.27662C1.89431 8.36829 2.04839 8.41452 2.35655 8.50696L6.375 9.7125V10.622C6.375 11.1962 6.71954 11.7256 7.26512 11.9472L7.68519 12.1179C8.52891 12.4607 9.47109 12.4607 10.3148 12.1179L10.7349 11.9472C11.2805 11.7256 11.625 11.1962 11.625 10.622V9.7125L15.6435 8.50696C15.9516 8.41452 16.1057 8.36829 16.2198 8.27662C16.3194 8.19657 16.3969 8.09238 16.445 7.97395C16.5 7.83833 16.5 7.67747 16.5 7.35574C16.5 6.09021 16.5 5.45744 16.2527 4.97451C16.0376 4.55432 15.6957 4.21244 15.2755 3.99729C14.7926 3.75 14.1598 3.75 12.8943 3.75ZM10.2 9H7.8C7.63431 9 7.5 9.13643 7.5 9.30472V10.622C7.5 10.7466 7.57469 10.8587 7.68858 10.905L8.10866 11.0756C8.68085 11.3081 9.31915 11.3081 9.89134 11.0756L10.3114 10.905C10.4253 10.8587 10.5 10.7466 10.5 10.622V9.30472C10.5 9.13643 10.3657 9 10.2 9Z"
                                        fill="white" />
                                    <path opacity="0.3"
                                        d="M2.25 8.47461C2.28334 8.48472 2.31879 8.49535 2.35655 8.50668L6.375 9.71221V10.6217C6.375 11.1959 6.71954 11.7253 7.26512 11.9469L7.68519 12.1176C8.52891 12.4604 9.47109 12.4604 10.3148 12.1176L10.7349 11.9469C11.2805 11.7253 11.625 11.1959 11.625 10.6217V9.71222L15.6435 8.50668C15.6812 8.49536 15.7166 8.48473 15.75 8.47462V9.22466C15.7493 11.9811 15.7238 14.7657 14.7615 15.6211C13.773 16.4998 12.182 16.4998 8.99998 16.4998C5.818 16.4998 4.22701 16.4998 3.2385 15.6211C2.27617 14.7657 2.25068 11.9811 2.25 9.22466V8.47461Z"
                                        fill="white" />
                                </svg>

                                <span class="d-none d-md-inline">Giao việc</span>
                            </button>
                            {{-- <a href="/hrm/hrm-add.html" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
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
                            </a> --}}
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Card Body-->
            <div class="card-body p-4">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <!--begin::Table-->
                    <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0"
                        id="table_task_of_employees">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="bg-primary text-white">
                                {{-- <th class="w-40px"></th> --}}
                                <th class="text-nowrap align-middle fs-5 text-center w-350px">Tài khoản</th>
                                <th class="text-nowrap align-middle fs-5 text-center">Vị trí</th>
                                <th class="text-nowrap align-middle fs-5 text-start w-350px">Công việc</th>
                                <th class="text-nowrap align-middle fs-5 text-start">Thời gian</th>
                                <th class="text-nowrap align-middle fs-5 text-start">Trạng thái</th>
                                <th class="text-nowrap align-middle fs-5 text-center">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($data->data))
                            @foreach ($data->data as $task)
                                @if (isset(auth()->user()->employees) && auth()->user()->employees->id == $task->employees_id)
                                    <tr>
                                        <td class="align-middle px-2 px-md-4 py-4">
                                            <div class="d-flex flex-stack">
                                                <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                                    @php
                                                        $hasImage = false;
                                                    @endphp
                            
                                                    @foreach($task->employees->files as $file)
                                                        @if($file->types == 0)
                                                            <img src="{{ $file->image_url }}" class="h-40 align-self-center" alt="">
                                                            @php
                                                                $hasImage = true;
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                            
                                                    @if(!$hasImage)
                                                        <img src="assets/image/employee_default.png" class="h-40 align-self-center" alt="">
                                                    @endif
                                                </div>
                            
                                                <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                                                    <div class="flex-grow-1 me-2">
                                                        <span class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                            {{ $task->employees->name }}
                                                        </span>
                                                        <span class="text-muted fw-semibold d-block fs-6">{{ $task->employees->code }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center px-2 px-md-4 py-4">
                                            <span class="fs-7 text-primary bg-primary bg-opacity-20 rounded-full px-3 py-1" style="background-color:rgba(3, 78, 162, 0.15)!important;">
                                                {{ $task->employees->roles->name }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-start px-2 px-md-4 py-4">
                                            {{ $task->name }}
                                        </td>
                                        <td class="align-middle text-left px-2 px-md-4 py-4">
                                            {{ \Carbon\Carbon::parse($task->from_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($task->to_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="align-middle text-left px-2 px-md-4 py-4">
                                            @if ($task->status == 0)
                                                <span class="text-danger">Chưa bắt đầu</span>
                                            @elseif($task->status == 1)
                                                <span class="text-primary">Đang diễn ra</span>
                                            @else
                                                <span class="text-success">Hoàn thành</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                            <button type="button" data-id="{{$task->id}}" class="btn btn-ghost p-1 edit_task_employee crm_task_target_edit" data-bs-toggle="modal" data-bs-target="#ti_modal_job_edit_{{$task->employees->id}}">
                                                <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                            </button>
                                            @include('crm.content.taskManagement.task_modal_edit')
                            
                                            <button type="button" class="btn btn-ghost p-1 crm_task_target_delete" data-id="{{$task->id}}" data-bs-toggle="modal" data-bs-target="#ti_modal_job_delete_{{$task->employees->id}}">
                                                <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                                            </button>
                                            @include('crm.content.taskManagement.task_modal_delete')
                                        </td>
                                    </tr>
                                @elseif(auth()->user()->id == 1 )   
                                <tr>
                                    <td class="align-middle px-2 px-md-4 py-4">
                                        <div class="d-flex flex-stack">
                                            <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                                @php
                                                    $hasImage = false;
                                                @endphp
                        
                                                @foreach($task->employees->files as $file)
                                                    @if($file->types == 0)
                                                        <img src="{{ $file->image_url }}" class="h-40 align-self-center" alt="">
                                                        @php
                                                            $hasImage = true;
                                                        @endphp
                                                        @break
                                                    @endif
                                                @endforeach
                        
                                                @if(!$hasImage)
                                                    <img src="assets/image/employee_default.png" class="h-40 align-self-center" alt="">
                                                @endif
                                            </div>
                        
                                            <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                                                <div class="flex-grow-1 me-2">
                                                    <span class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                        {{ $task->employees->name }}
                                                    </span>
                                                    <span class="text-muted fw-semibold d-block fs-6">{{ $task->employees->code }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                        <span class="fs-7 text-primary bg-primary bg-opacity-20 rounded-full px-3 py-1" style="background-color:rgba(3, 78, 162, 0.15)!important;">
                                            {{ $task->employees->roles->name }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        {{ $task->name }}
                                    </td>
                                    <td class="align-middle text-left px-2 px-md-4 py-4">
                                        {{ \Carbon\Carbon::parse($task->from_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($task->to_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="align-middle text-left px-2 px-md-4 py-4">
                                        @if ($task->status == 0)
                                            <span class="text-danger">Chưa bắt đầu</span>
                                        @elseif($task->status == 1)
                                            <span class="text-primary">Đang diễn ra</span>
                                        @else
                                            <span class="text-success">Hoàn thành</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                        <button type="button" data-id="{{$task->id}}" class="btn btn-ghost p-1 edit_task_employee crm_task_target_edit" data-bs-toggle="modal" data-bs-target="#ti_modal_job_edit_{{$task->employees->id}}">
                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                        </button>
                                        @include('crm.content.taskManagement.task_modal_edit')
                        
                                        <button type="button" class="btn btn-ghost p-1 crm_task_target_delete" data-id="{{$task->id}}" data-bs-toggle="modal" data-bs-target="#ti_modal_job_delete_{{$task->employees->id}}">
                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                                        </button>
                                        @include('crm.content.taskManagement.task_modal_delete')
                                    </td>
                                </tr> 
                                @endif
                        @endforeach
                        
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@include('crm.content.taskManagement.task_modal')

<script type="module" src="/assets/crm/js/htecomJs/task_edit.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/task_delete.js"></script>
@endsection
