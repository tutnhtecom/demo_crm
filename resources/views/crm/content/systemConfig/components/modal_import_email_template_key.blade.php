<div class="modal fade" id="import_email_template_key" tabindex="-1" aria-labelledby="importLeadsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import danh sách Key cho Mẫu email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-lg-12 py-3">
                        <span>Chọn loại mẫu email:</span>
                    </div>
                    <div class="col-lg-12">
                        <select id="price-tempMail-lead" name="price-tempMail-lead" class="form-select">
                            <option value="" disabled selected>Chọn loại mẫu email</option>
                            @if (isset($email_template_type))
                                @foreach ($email_template_type as $tmp)
                                    <option value="{{$tmp['id']}}<">{{$tmp['name']}}</option>
                                @endforeach                                 
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-lg-12">
                        <input id="import_leads_file" type="file" class="form-control" style="border:0; border-bottom: 1px solid #ccc">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="mt-3" style="margin-bottom:0"> Tải file mẫu: <a href="assets/file/mau_import_sinh_vien.xlsx">FILE MẪU</a> </p>
                        <p class="error_log_leads leads_err mt-3" style="margin-bottom:0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="import_btn_leads" type="button" class="btn btn-primary">Tải lên</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>