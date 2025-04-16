<!DOCTYPE html>
@extends('crm.layouts.layout')
@section('header', 'Cấu hình')
@section('content')
<div class="px-6">
    <!--begin::App Breadcrumb-->
    <div class="app_breadcrumb d-flex align-items-center justify-content-between">        
        <div class="mx-3 py-4">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Cấu hình hệ thống</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>                
                <!--begin::Item-->
                <li class="breadcrumb-item text-primary">Mẫu Email</li>
                <!--end::Item-->
            </ul>
        </div>        
    </div>    
    @include('crm.content.systemConfig.components.email_template_tabs')                  
</div>
<!--end::Content-->

@include('crm.content.systemConfig.modal_key_email_template')
</div>
<script type="module" src="/assets/crm/js/htecomJs/createTypeEmailExample.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/createEmailExample.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/editEmailExample.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/deleteEmailExample.js"></script>

<script>
    $('table[data-class]').each(function() {
        var tableClass = '.' + $(this).data('class'); // Lấy class động từ data-class

        // Khởi tạo DataTable
        var tableExample_Email = new DataTable(tableClass, {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            dom: "lrtip"
        });
    });
</script>
@endsection