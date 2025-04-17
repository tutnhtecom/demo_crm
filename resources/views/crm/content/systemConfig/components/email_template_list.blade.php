<div class="card mx-6" style="border-radius: 0; border:0;">
    <!-- Nội dung bảng -->
    <div class="card-body p-4 overflow-x-auto">
        <div class="row">
            <div class="col-12">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <!--begin::Title-->
                    <h5 class="card-title text-dark fw-bolder m-md-0">Danh sách mẫu Email</h5>
                    <div class="d-flex justify-content-end">
                        <!--begin:Action Buttons-->
                        <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                            <button data-bs-toggle="modal" data-bs-target="#createExampleEmailModal"
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
                            </button>
                            <button data-bs-toggle="modal" data-bs-target="#createTypeEmailModal"
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

                                <span class="d-none d-md-inline">Thêm mới loại mẫu</span>
                            </button>
                            @include('crm.content.systemConfig.modal_create_email')
                            @include('crm.content.systemConfig.modal_create_type_email')
                        </div>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
        </div>
        <div class="row my-3">
            @foreach ($email_types as $e_type)
            <div class="col-12 col-md-6">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <!--begin::Table-->
                    <table data-class="table_example_email_{{$e_type->id}}" class="table_example_email_{{$e_type->id}} table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-nowrap align-middle fs-5 text-start px-4"> {{$e_type->name}} </th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                           @php
                                $hasTemplate = false;
                                if(count($email_template) > 0) {
                                    foreach ($email_template as $key => $e_template){                                                                              
                                        $status = view()->exists('includes.template.' . $e_template->file_name);
                                        //<!-- Băt đầu lệnh if kiểm tra trạng thái -->
                                        if($e_template->types_id === $e_type->id && $status) {                                                                                        
                                            $hasTemplate = true;
                                        @endphp
                                        <tr>
                                            <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                                {{$e_template->title}}
                                            </td>
                                            <td class="align-middle text-center">
                                                <button type="button" class="btn-edit-email btn btn-ghost p-1" data-id="{{$e_template->id}}" data-bs-toggle="modal" data-bs-target="#editExampleEmailModal{{$e_template->id}}">
                                                    <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                                        height="18" />
                                                </button>

                                                {{-- Modal edit exam mail --}}
                                                @include('crm.content.systemConfig.modal_edit_exam_email')

                                                <button type="button" class="btn btn-ghost p-1"
                                                    data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                    data-ti-button-action="row-remove" data-ti-row-confirm="true" data-id="{{$e_template->id}}" data-bs-toggle="modal" data-bs-target="#deleteExampleEmailModal{{$e_template->id}}">
                                                    <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                                        height="18" />
                                                </button>

                                                {{-- Modal delete exam mail --}}
                                                @include('crm.content.systemConfig.modal_delete_exam_email')
                                            </td>
                                        </tr>                
                                        @php
                                        }
                                        //<!-- // Kết thúc lệnh if kiểm tra trạng thái -->
                                    }
                                }
                           @endphp
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>