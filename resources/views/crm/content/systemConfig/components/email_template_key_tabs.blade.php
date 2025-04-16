<div class="card mx-6" style="border-radius: 0; border:0;">
    <!-- Nội dung bảng -->
    <div class="card-body p-4 overflow-x-auto">
        <div class="row">
            <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                <!--begin::Title-->
                <h5 class="card-title text-dark fw-bolder m-md-0">Quản lý Nguồn tiếp cận</h5>
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
                        <input id="search_input_sources" type="text"
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
                </div>
                <div class="d-flex justify-content-end">
                    <!--begin:Action Buttons-->
                    <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                        <button id="btn_import_leads" type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_lead_create_lead"
                            data-bs-toggle="modal" data-bs-target="#import_email_template_key">
                            <img src="assets/crm/media/svg/crm/upload.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Nhập dữ liệu</span>
                        </button>
                    </div>
                </div>
                <!--end::Actions-->
            </div>
        </div>
        <div class="row my-3">
            <div class="table-responsive position-relative border-0 rounded-3 my-3">
                @if (isset($email_template_type))
                    @foreach ($email_template_type as $value)
                        <div class="col-12 py-2 pl-4 rounded-5" style="border:0; border-bottom: 1px solid #ccc;" 
                             data-bs-toggle="collapse" data-bs-target="#tbl_key_{{$value['id']}}">
                            <span class="px-6"><strong>{{$value["name"]}}</strong></span>
                        </div>   
                        <div class="collapse" id="tbl_key_{{$value['id']}}">
                            <!--begin::Table-->
                            <table class="table table-striped table-crm table-row-devider-300 bordered w-100" id="table_email_template_key">    
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-nowrap align-middle fs-5 text-start px-4" style="max-width:50px;">STT</th>
                                        <th class="text-nowrap align-middle fs-5 text-start px-4">Tên hiển thị</th>
                                        <th class="text-nowrap align-middle fs-5 text-center px-4">Key mặc định</th>
                                        <th class="text-nowrap align-middle fs-5 text-center px-4">Key tùy chỉnh</th>
                                        <th class="text-nowrap align-middle fs-5 text-center px-4">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($email_template_key))
                                        @foreach ($email_template_key as $key => $item)
                                            @if ($item["email_template_types_id"] == $value["id"])
                                                <tr>
                                                    <td class="text-center">
                                                        {{$key+1}}
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        {{ $item["display_name"] }}
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        {{ $item["default_key"] }}
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        {{ $item["customs_key"] }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn btn-ghost p-1 update_config_filter">
                                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                                        </button>
                                                        <button type="button" class="btn btn-ghost p-1" name="delete_item" onclick="delete_item(<?= $item['id'] ?>)" data-id="{{$item['id']}}">
                                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                                                        </button>
                                                    </td>                    
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>                 
                    @endforeach
                @endif
                
                
               
            </div>
        </div>
    </div>
    @include('crm.content.systemConfig.components.modal_import_email_template_key')
</div>
<style>
    /* #table_email_template_key {
        width: 400px;
        height: 300px;        
        overflow-y: auto;        
    } */
</style>
<script>


</script>