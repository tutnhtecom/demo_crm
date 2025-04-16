@extends('crm.layouts.layout')

@section('header', 'Ngành và tổ hợp môn')
@section('content')
    <div class="px-6">
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Cấu hình hệ thống</li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <li class="breadcrumb-item text-primary">Ngành và tổ hợp môn</li>
                </ul>
            </div>

        </div>

        <div class="card">
            <div class="card-header p-4">
                <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-2 mb-3 mb-md-0">
                        <form class="w-100 position-relative mb-lg-0" autocomplete="off">
                            <input type="hidden" />
                            <i
                                class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input id="search-input-subject_combination" type="text"
                                class="search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13"
                                name="search" value="" placeholder="Tìm kiếm..." />
                            <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
                                <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                            </span>
                            <span
                                class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4">
                                <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </form>
                    </div>
                    <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                        <button data-bs-toggle="modal" data-bs-target="#createMajor" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 18 18" fill="none">
                                <path opacity="0.3" d="M16.5 9C16.5 13.1421 13.1421 16.5 9 16.5C4.85786 16.5 1.5 13.1421 1.5 9C1.5 4.85786 4.85786 1.5 9 1.5C13.1421 1.5 16.5 4.85786 16.5 9Z" fill="white"/>
                                <path d="M9.5625 6.75C9.5625 6.43934 9.31066 6.1875 9 6.1875C8.68934 6.1875 8.4375 6.43934 8.4375 6.75L8.4375 8.43752H6.75C6.43934 8.43752 6.1875 8.68936 6.1875 9.00002C6.1875 9.31068 6.43934 9.56252 6.75 9.56252H8.4375V11.25C8.4375 11.5607 8.68934 11.8125 9 11.8125C9.31066 11.8125 9.5625 11.5607 9.5625 11.25L9.5625 9.56252H11.25C11.5607 9.56252 11.8125 9.31068 11.8125 9.00002C11.8125 8.68936 11.5607 8.43752 11.25 8.43752H9.5625V6.75Z" fill="white"/>
                            </svg>

                            <span class="d-none d-md-inline">Thêm mới chuyên ngành</span>
                        </button>
                        @include('crm.content.majorSubjectCombination.modal_create_major')
                    </div>
                </div>

            </div>
            <div class="card-body p-4 overflow-x-auto">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100"
                        id="table_major_subject_combination">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-nowrap align-middle fs-5 text-start px-4">Tên chuyên ngành</th>
                                <th class="text-nowrap align-middle fs-5 text-start px-4">Danh sách tổ hợp môn</th>
                                <th class="text-nowrap align-middle fs-5 text-start px-4 w-40px">Thêm tổ hợp môn</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{dd($data)}} --}}
                            @if(isset($data['data']))
                            @foreach ($data['data'] as $item)
                                <tr>
                                    <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                        <div class="d-flex justify-content-between align-items-center gap-1">
                                            <div>
                                                {{$item['name']}}
                                            </div>
                                            <div class="d-flex align-items-center gap-1">
                                                <button data-id="{{$item['id']}}" type="button" class="btn btn-ghost p-1 icon_edit_major" 
                                                    data-bs-toggle="modal" data-bs-target="#editMajor"
                                                    data-name="{{$item['name']}}"
                                                >
                                                    <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                                </button>
                                                <button type="button" class="btn btn-ghost p-1 icon_delete_major" data-bs-toggle="modal" data-bs-target="#deleteMajor"
                                                    data-id-major="{{$item['id']}}"
                                                >
                                                    <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                        @if( isset($item['block']) )
                                        @foreach ($item['block'] as $block)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    {{$block['name']}} 
                                                </div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <button type="button" class="btn btn-ghost p-1 icon_edit_combination" 
                                                        data-bs-toggle="modal" data-bs-target="#editCombination"
                                                        data-combination-name="{{$block['name']}}"
                                                        data-combination-id="{{$block['id']}}"
                                                        data-major-id="{{$item['id']}}"
                                                    >
                                                        <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                                    </button>
                                                    <button type="button" class="btn btn-ghost p-1 icon_delete_combination"
                                                        data-bs-toggle="modal" data-bs-target="#deleteCombination" 
                                                        data-ti-button-action="row-remove" data-ti-row-confirm="true"
                                                        data-id-combination="{{$block['id']}}"
                                                    >
                                                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td class="align-middle px-2 px-md-4 py-4">
                                        <button data-id="{{$item['id']}}" data-bs-toggle="modal" data-bs-target="#createCombination" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 btn_add_combination">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 18 18" fill="none">
                                                <path opacity="0.3" d="M16.5 9C16.5 13.1421 13.1421 16.5 9 16.5C4.85786 16.5 1.5 13.1421 1.5 9C1.5 4.85786 4.85786 1.5 9 1.5C13.1421 1.5 16.5 4.85786 16.5 9Z" fill="white"/>
                                                <path d="M9.5625 6.75C9.5625 6.43934 9.31066 6.1875 9 6.1875C8.68934 6.1875 8.4375 6.43934 8.4375 6.75L8.4375 8.43752H6.75C6.43934 8.43752 6.1875 8.68936 6.1875 9.00002C6.1875 9.31068 6.43934 9.56252 6.75 9.56252H8.4375V11.25C8.4375 11.5607 8.68934 11.8125 9 11.8125C9.31066 11.8125 9.5625 11.5607 9.5625 11.25L9.5625 9.56252H11.25C11.5607 9.56252 11.8125 9.31068 11.8125 9.00002C11.8125 8.68936 11.5607 8.43752 11.25 8.43752H9.5625V6.75Z" fill="white"/>
                                            </svg>

                                            <span class="d-none d-md-inline">Thêm mới</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('crm.content.majorSubjectCombination.modal_create_combination')
    @include('crm.content.majorSubjectCombination.modal_edit_major')
    @include('crm.content.majorSubjectCombination.modal_edit_combination')
    @include('crm.content.majorSubjectCombination.modal_delete_major')
    @include('crm.content.majorSubjectCombination.modal_delete_combination')

<script type="module" src="/assets/crm/js/htecomJs/majorSubjectCombination.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/majorSubjectCombinationEdit.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/majorSubjectCombinationDelete.js"></script>
@endsection
