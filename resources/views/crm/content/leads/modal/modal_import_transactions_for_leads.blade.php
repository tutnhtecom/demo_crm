<div class="modal fade" id="modal_import_tractions" tabindex="-1" aria-labelledby="modal_import_tractions">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import danh sách giao dịch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <input type="checkbox" name="modal_auto_send_mail" id="modal_auto_send_mail" class="form-check-input" style="border-radius: 3px; width:20px;height: 20px;">
                        <span style="font-size: 13px;"><strong>Tắt tự động gửi mail</strong></span>
                    </div>                   
                </div>
                <div class="row mt-4">
                    <input id="file_import_transactions" type="file" class="form-control pt-6" style="border: 0;border-bottom: 1px solid #ccc;border-radius: 0;">
                    <p class="mt-3" style="margin-bottom:0"> Tải file mẫu: <a href="assets/file/mau_import_giao_dich.xlsx">FILE MẪU</a> </p>
                <p class="error_log_leads transaction_err mt-3" style="margin-bottom:0"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_import_transactions" type="button" class="btn btn-primary">Tải lên</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
    <script type="module" src="/assets/crm/js/htecomJs/import_transactions.js"></script>
</div>
