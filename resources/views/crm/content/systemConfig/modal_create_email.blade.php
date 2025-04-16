<div class="modal fade" id="createExampleEmailModal" tabindex="-1" aria-labelledby="createExampleEmailModalLabel">
    <div class="modal-dialog modal_wrapper modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo mẫu email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 email_example">
                        <div class="form_example_email">
                            <div id="email_template_form" action="">
                                <!-- Thông tin key -->
                                <div class="mb-3 container_guide_wrapper">
                                    <button data-bs-toggle="modal fade" data-bs-target="" class="btn btn-sm btn-primary" id="btn_modal_key">                                     
                                        <span class="d-none d-md-inline">Từ khóa</span>
                                    </button>                                 
                                </div>
                                <div class="form-check form-check-sm cursor-pointer d-flex justify-content-end align-items-center gap-1">
                                    <input class="form-check-input" type="checkbox" value="" id="email_template_default">
                                    <label class="form-check-label text-gray-900" for="">
                                        Chọn mặc định
                                    </label>
                                </div>
                                <div class="email_template_type_wrapper mb-4">
                                    <label for="" class="mb-1">Chọn loại mẫu mail</label>
                                    <select name="" id="email_template_type" class="form-select">
                                        <option value="">Chọn mẫu mail</option>
                                        @foreach ($email_types as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="email_template_title_wrapper mb-4">
                                    <label for="" class="mb-1">Tiêu đề</label>
                                    <input id="email_template_title" type="text" placeholder="Nhập tiêu đề">
                                </div>
                                <div class="email_template_content_wrapper mb-2">
                                    <label for="" class="mb-1">Nhập nội dung mail</label>
                                    <textarea name="" id="email_template_content" class="form-control"></textarea>
                                </div>
                                <!-- <div class="email_template_fileName_wrapper mb-4">
                                    <label for="" class="mb-1">Tên mẫu mail</label>
                                    <input id="email_template_fileName" type="text" placeholder="Nhập tên">
                                </div> -->
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 email_view">b</div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button id="email_template_btn_submit" type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
    {{-- @include('crm.content.systemConfig.modal_key_email_template')  --}}
</div>
<script>
    // $(document).on("click", "#btn_modal_1", function () {
    //     let firstModal = bootstrap.Modal.getInstance($("#createExampleEmailModal")[0]);
    //     $("#createExampleEmailModal").addClass("modal-level-1");

    //     let secondModal = new bootstrap.Modal($("#key_email_template")[0]);
    //     $("#key_email_template").addClass("modal-level-2");
        
    //     secondModal.show();
    // });
    $(document).on("click", "#btn_modal_key", function () {
        let modalElement = $("#key_email_template");

        if (modalElement.hasClass("show")) {
            modalElement.modal("hide");
        } else {
            modalElement.modal("show");
        }
    });
</script>