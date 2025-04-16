<div class="modal fade modal_exam_email" id="editExampleEmailModal{{$e_template->id}}" tabindex="-1" aria-labelledby="createExampleEmailModalLabel">
    <div class="modal-dialog modal_wrapper modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo mẫu email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 email_example">
                        <div class="form_example_email">
                            <div id="email_template_edit_form" action="">
                                <div class="mb-3 container_guide_wrapper">
                                    <!-- <button data-bs-toggle="modal fade" data-bs-target="#key_email_template" class="btn btn-sm btn-primary" id="btn_modal_1">                                     
                                        <span class="d-none d-md-inline">Từ khóa</span>
                                    </button> -->
                                    <div class="button_guide_wrapper mb-2 text-start">
                                        {{-- <button class="btn_guide_key"> 
                                            Từ khóa 
                                        </button> --}}
                                        <button id="btn_modal_key_edit" class="btn_guide_key"> 
                                            Từ khóa 
                                        </button>
                                    </div> 
                                    <div class="table_note_guide" style="display: none;">
                                        <div class="d-flex gap-4">
                                            {{-- @include('crm.content.systemConfig.table_key_for_email_template') --}}
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="email_template_edit_type_wrapper mb-4 text-start">
                                    <label for="" class="mb-1">Chọn loại mẫu mail</label>
                                    <select name="" id="email_template_edit_type_{{$e_template->id}}" class="form-select email_template_edit_type">
                                        <option value="">Chọn mẫu mail</option>
                                        @foreach ($email_types as $type)
                                            <option value="{{$type->id}}" {{ $type->id === $e_type->id ? "selected" : '' }}>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="error-input mt-1 error_{{$e_template->id}}"></p>
                                </div>
                                <div class="email_template_edit_title_wrapper mb-4 text-start">
                                    <label for="" class="mb-1">Tiêu đề</label>
                                    <input id="email_template_edit_title_{{$e_template->id}}" value="{{$e_template->title}}" type="text" placeholder="Nhập tiêu đề" class="email_template_edit_title">
                                    <p class="error-input mt-1"></p>
                                </div>
                                <div class="email_template_edit_content_wrapper mb-4 text-start">
                                    <label for="" class="mb-1">Nhập nội dung mail</label>
                                    <script>
                                        var contentEmail{{$e_template->id}} = @json($e_template->content);
                                    </script>
                                    <textarea name="" id="email_template_edit_content_{{$e_template->id}}" class="form-control email_template_edit_content"></textarea>
                                </div>
                                <div class="email_template_edit_fileName_wrapper mb-4 text-start">
                                    <label for="" class="mb-1">Tên mẫu mail</label>
                                    <input id="email_template_edit_fileName_{{$e_template->id}}" value="{{$e_template->file_name}}" type="text" placeholder="Nhập tên" class="email_template_edit_fileName">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 email_view">b</div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button id="" type="button" class="btn btn-primary email_template_btn_edit" data-id="{{$e_template->id}}">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
    
</div>
{{-- @include('crm.content.systemConfig.modal_key_email_template')  --}}

<script>
    // $(document).on("click", "#btn_modal_1", function () {
    //     let firstModal = bootstrap.Modal.getInstance($("#createExampleEmailModal")[0]);
    //     $("#createExampleEmailModal").addClass("modal-level-1");

    //     let secondModal = new bootstrap.Modal($("#key_email_template")[0]);
    //     $("#key_email_template").addClass("modal-level-2");
        
    //     secondModal.show();
    // });
    
</script>