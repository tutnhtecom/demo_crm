<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Cấu hình chung')
@section('content')
<div class="px-6">
    <div class="app_breadcrumb d-flex align-items-center justify-content-between">
        <div class="x-3 py-4">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    <a href="/" class="text-gray-500">
                        <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Cấu hình hệ thống</li>
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <li class="breadcrumb-item text-primary fw-bold lh-1">Cấu hình chung</li>
            </ul>
        </div>

    </div>
    <div class="row">
        <!-- Thiết lập thông số Giao việc -->
        <div class="col-4">
            <div class="card">
                <form id="" data-attr="">
                    <div class="card-body py-3 px-10">
                        <div class="row gx-3">
                            <div class="col-12">
                                <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Cấu hình giao việc</h3>
                            </div>
                            @php
                            $kpiTypeOne = null;
                            if (isset($data['data'])) {
                            $kpiTypeOne = collect($data['data'])->firstWhere('types', 1);
                            }
                            @endphp
                            <div class="col-12 col-md-6 mt-3">
                                <div class="">
                                    <label for="" class="form-label"> Nhắc công việc trước khi bắt đầu</label>                                    
                                    <!-- <input value="{{ $kpiTypeOne['start_date'] ?? '' }}" type="text" id="task_start_date"
                                        name=""
                                        placeholder="Nhập" class="form-control" required maxlength="2" /> -->
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Nhập" aria-label="Nhập"  required
                                        value="{{ $kpiTypeOne['start_date'] ?? '' }}" type="text" id="task_start_date">
                                        <span class="input-group-text" id="basic-addon2"><i>Ngày</i></span>
                                    </div>
                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <div class="">
                                    <label for="" class="form-label"> Nhắc công việc trước khi hết hạn </label>
                                    <div class="input-group mb-3">
                                        <input  type="text" class="form-control" placeholder="Nhập" aria-label="Nhập"  required
                                                value="{{ $kpiTypeOne['end_date'] ?? '' }}" type="text" id="task_end_date">
                                        <span class="input-group-text" id="basic-addon2"><i>Ngày</i></span>
                                    </div>
                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3 px-10 mb-2">
                        <div class="row gx-6">
                            @if($kpiTypeOne)
                            <div class="col-12 col-md-12">
                                <div class="d-flex align-items-center justify-content-end gap-3 h-100">
                                    <button id="btn_task_update" type="submit" class="btn btn-primary"
                                        data-id="{{$kpiTypeOne['id'] ?? ''}}">Cập nhật</button>
                                </div>
                            </div>
                            @else
                            <div class="col-12 col-md-12">
                                <div class="d-flex align-items-center justify-content-end gap-3 h-100">
                                    <button id="btn_task_create" type="button" class="btn btn-primary"
                                        data-id="">Tạo</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Thiết lập thông số Kpis -->
        <div class="col-4">
            <div class="card">
                <form id="" data-attr="">
                    <div class="card-body py-3 px-10 mb-2">
                        <div class="row gx-3 pt-3">
                            <div class="col-12">
                                <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Cấu hình chỉ tiêu tuyển sinh</h3>
                            </div>
                            @php
                            $kpiTypeZero = null;
                            if(isset($data['data'])){
                            $kpiTypeZero = collect($data['data'])->firstWhere('types', 0);
                            }
                            @endphp
                            <div class="col-12 col-md-6">
                                <div class="">
                                    <label for="" class="form-label"> Nhắc Kpis trước khi bắt đầu </label>                                    
                                    <!-- <input value="{{ $kpiTypeZero['start_date'] ?? '' }}" type="text" id="kpi_start_date" name="" placeholder="Nhập" class="form-control" required maxlength="2" /> -->

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Nhập" aria-label="Nhập"  required
                                        value="{{ $kpiTypeZero['start_date'] ?? '' }}" type="text" id="kpi_start_date">
                                        <span class="input-group-text" id="basic-addon2"><i>Ngày</i></span>
                                    </div>

                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="">
                                    <label for="" class="form-label"> Nhắc Kpis trước khi hết hạn </label>                                    
                                    <!-- <input value="{{ $kpiTypeZero['end_date'] ?? '' }}" type="text" id="kpi_end_date"
                                        name="" class="form-control"
                                        placeholder="Nhập" required maxlength="2" /> -->
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Nhập" aria-label="Nhập"  required
                                        value="{{ $kpiTypeZero['end_date'] ?? '' }}" type="text" id="kpi_end_date">
                                        <span class="input-group-text" id="basic-addon2"><i>Ngày</i></span>
                                    </div>   

                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3 px-10 mb-2">
                        <div class="row gx-6">
                            @if($kpiTypeZero)
                            <div class="col-12 col-md-12">
                                <div class="d-flex align-items-center justify-content-end gap-3 h-100">
                                    <button id="btn_kpi_update" type="submit" class="btn btn-primary"
                                        data-id="{{$kpiTypeZero['id'] ?? ''}}">Cập nhật</button>
                                </div>
                            </div>
                            @else
                            <div class="col-12 col-md-12">
                                <div class="d-flex align-items-center justify-content-end gap-3 h-100">
                                    <button id="btn_kpi_create" type="button" class="btn btn-primary"
                                        data-id="">Tạo</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Thiết lập thông số cho Yêu cầu hỗ trợ -->
        <div class="col-4">
            <div class="card">
                <form id="" data-attr="">
                    <div class="card-body py-3 px-10 mb-2">
                        <div class="row gx-3 pt-3">
                            <div class="col-12">
                                <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Cấu hình Yêu cầu hỗ trợ</h3>
                            </div>
                            @php
                            $kpiTypeZero = null;
                            if(isset($data['data'])){
                            $kpiTypeZero = collect($data['data'])->firstWhere('types', 2);
                            }
                            @endphp
                            <div class="col-12 col-md-12">
                                <div class="">
                                    <label for="" class="form-label"> Thời gian tự động chuyển trạng thái Yêu cầu hỗ trợ </label>                                    
                                    <!-- <input value="{{ $kpiTypeZero['end_date'] ?? '' }}" type="text" id="support_end_date" name="" placeholder="Nhập" class="form-control" required maxlength="2" /> -->
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Nhập" aria-label="Nhập"  required
                                        value="{{ $kpiTypeZero['end_date'] ?? '' }}" type="text" id="support_end_date">
                                        <span class="input-group-text" id="basic-addon2"><i>Ngày</i></span>
                                    </div>   
                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="py-3 px-10 mb-2">
                        <div class="row gx-6">
                            @if($kpiTypeZero)
                            <div class="col-12 col-md-12">
                                <div class="d-flex align-items-center justify-content-end gap-3 h-100">
                                    <button id="btn_supports_update" type="submit" class="btn btn-primary"
                                        data-id="{{$kpiTypeZero['id'] ?? ''}}">Cập nhật</button>
                                </div>
                            </div>
                            @else
                            <div class="col-12 col-md-12">
                                <div class="d-flex align-items-center justify-content-end gap-3 h-100">
                                    <button id="btn_supports_create" type="button" class="btn btn-primary" data-id="">Tạo</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Thiết lập tổng đài -->
        <div class="col-4">
            <div class="card">
                <div class="card-body py-3 px-10 mb-2">
                    <div class="row gx-3 pt-3">
                        <div class="col-12">
                            <h3 class="text-dark fs-3 fw-bolder mb-3 mb-md-6">Cấu hình kết nối tổng đài</h3>
                        </div>
                        @if(isset($voip) && count($voip) > 0)
                            @foreach ($voip as $key => $item)
                                <div class="create_api_key_wrapper mb-4">
                                    <label class="form-label">API KEY <span style="color:red;">*</span> </label>
                                    <input value="{{$item->api_key ?? ''}}" id="create_api_key" type="text" class="form-control" name="" placeholder="Nhập API KEY" voip-id="{{$item->id}}" required>
                                    <p class="error-input"></p>
                                </div>

                                <div class="create_api_secret_wrapper mb-4">
                                    <label class="form-label">API SECRET <span style="color:red;">*</span> </label>
                                    <input value="{{$item->api_secret ?? ''}}" id="create_api_secret" type="text" class="form-control" name="" placeholder="Nhập API SECRET" required>
                                    <p class="error-input"></p>
                                </div>

                                <div class="create_ip_voip24h_wrapper mb-4">
                                    <label class="form-label">IP Tổng đài <span style="color:red;">*</span> </label>
                                    <input value="{{$item->voip_ip ?? ''}}" id="create_ip_voip24h" type="text" class="form-control" name="" placeholder="Nhập IP Tổng đài" required>
                                    <p class="error-input"></p>
                                </div>                                
                            @endforeach
                        @else
                            <div class="create_api_key_wrapper mb-4">
                                <label class="form-label">API KEY <span style="color:red;">*</span> </label>
                                <input id="create_api_key" type="text" class="form-control" name="" placeholder="Nhập API KEY" required>
                                <p class="error-input"></p>
                            </div>

                            <div class="create_api_secret_wrapper mb-4">
                                <label class="form-label">API SECRET <span style="color:red;">*</span> </label>
                                <input id="create_api_secret" type="text" class="form-control" name="" placeholder="Nhập API SECRET" required>
                                <p class="error-input"></p>
                            </div>

                            <div class="create_ip_voip24h_wrapper mb-4">
                                <label class="form-label">IP Tổng đài <span style="color:red;">*</span> </label>
                                <input id="create_ip_voip24h" type="text" class="form-control" name="" placeholder="Nhập IP Tổng đài" required>
                                <p class="error-input"></p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="py-3 px-10 mb-2">
                    <div class="row gx-6">
                        <div class="col-12 col-md-12">
                            <div class="d-flex align-items-center justify-content-end gap-3 h-100">
                                @if(count($voip) > 0)
                                    <button id="btn_update_config_voip" type="button" class="btn btn-primary" data-id="">Lưu</button>
                                @else
                                    <button id="btn_create_config_voip" type="button" class="btn btn-primary" data-id="">Lưu</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="module" src="/assets/crm/js/htecomJs/generalConfiguration.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Voip24H/voip24h_config.js"></script>
@endsection