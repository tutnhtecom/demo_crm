@extends('crm.layouts.layout')
@section('header', 'Khóa tuyển sinh')
@section('title', 'Danh sách học kỳ')
@section('content')
    <div class="px-6">
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Khóa tuyển sinh</li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <li class="breadcrumb-item text-primary">Danh sách học kỳ</li>
                </ul>
            </div>

        </div>

        <div class="card">
            <div class="card-header p-4">
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">

                    <div class="d-flex justify-content-end gap-2">
                        <h2>Danh sách học kỳ</h2>
                    </div>
                </div>

            </div>
            <div class="card-body p-4 overflow-x-auto">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100"
                        id="table_academic_terms">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Tên học kỳ</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Ngày bắt đầu</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Ngày kết thúc</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{dd($data->semesters)}} --}}
                            @if(isset($data->semesters))
                            @foreach ($data->semesters as $item)
                                <tr>
                                    <td class="align-middle px-2 px-md-4 py-4 text-primary text-center">
                                        {{$item->name}}
                                    </td>
                                    <td class="align-middle px-2 px-md-4 py-4 text-primary text-center">
                                        {{$item->from_day}}/{{$item->from_month}}/{{$item->from_year}}
                                    </td>
                                    <td class="align-middle px-2 px-md-4 py-4 text-primary text-center">
                                        {{$item->to_day}}/{{$item->to_month}}/{{$item->to_year}}
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
@endsection
