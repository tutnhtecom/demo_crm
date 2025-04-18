<div class="modal fade" id="importSourcesModal" tabindex="-1" aria-labelledby="importSourcesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import danh sách Đơn vị liên kết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input id="import_sources_file" class="form-control" type="file" style="border:0; border-bottom: 1px solid #ccc;">
                <p class="mt-3" style="margin-bottom:0"> Tải file mẫu: <a
                        href="assets/file/mau_import_ĐVLK.xlsx">FILE MẪU</a> </p>
                <p class="error_log_leads mt-3" style="margin-bottom:0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button id="import_btn_sources" type="button" class="btn btn-primary">Tải lên</button>
            </div>
        </div>
    </div>
</div>