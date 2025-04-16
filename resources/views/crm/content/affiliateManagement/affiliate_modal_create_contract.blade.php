<div class="modal fade" id="contractCreateModal{{ $data['id'] }}" tabindex="-1" aria-labelledby="contractCreateModalLabel">
    <div class="modal-dialog" style="min-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo hợp đồng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form_create_contract">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 contract_signed_document_wrapper mb-3">
                            <label for="" class="form-label">Văn bản ký kết <span class="text-danger">*</span></label>
                            <select id="contract_signed_document" class="form-select"
                                    data-placeholder="Chọn văn bản..." data-label="Chọn văn bản..." data-dropdown-parent="#affiliateCreateModal" required>
                                    <option value="">Chọn văn bản</option>
                                    <option value="Thảo thuận hợp tác">Thảo thuận hợp tác</option>
                                    <option value="Hợp đồng">Hợp đồng</option>
                            </select>                            
                            <p class="error-input mt-1"></p>
                        </div>
                        <div class="col-lg-6 col-md-6 contract_signed_content_wrapper mb-3">
                            <label for="" class="form-label">Nội dung hợp tác <span class="text-danger">*</span></label>
                            <input type="text" id="contract_signed_content" placeholder="Nhập" class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <div class="contract_date_wrapper mb-3">
                        <div class="row d-flex flex-stack">
                            <div class="col-6 mb-3 contract_date_start_wrapper">
                                <label class="form-label" for="contract_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                <input type="date" class="form-control price-date-start" id="contract_date_start" required />
                                <p class="error-input mt-1"></p>
                            </div>
                            <div class="col-6 mb-3 contract_date_end_wrapper">
                                <label class="form-label" for="contract_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="contract_date_end" required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="contract_btn_create" data-id="{{ $data['id'] }}" type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
