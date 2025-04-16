<div class="modal fade" id="importLeadsModal" tabindex="-1" aria-labelledby="importLeadsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import danh sách sinh viên tiềm năng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">                
                <input id="import_leads_file" type="file">
                <p class="mt-3" style="margin-bottom:0"> Tải file mẫu: <a href="assets/file/mau_import_sinh_vien.xlsx">FILE MẪU</a> </p>
                <p class="error_log_leads leads_err mt-3" style="margin-bottom:0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button id="import_btn_leads" type="button" class="btn btn-primary">Tải lên</button>
            </div>
        </div>
    </div>
</div>