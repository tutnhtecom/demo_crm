<div class="modal fade modal-md" id="modal_update_filter" tabindex="-1" aria-labelledby="convertLeadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header my-0 py-3">
                <h3>Chỉnh sửa bộ lọc thời gian</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <form id="create-filter-form">
                    <!-- Họ và tên -->
                    <div class="row create_filter_name">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Tên bộ lọc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 ">
                            <input type="text" name="name" id="name" placeholder="Nhập..." class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày bắt đầu -->
                    <div class="row my-3">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Ngày bắt đầu</span>
                            <span class="text-danger"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_start_date">
                            <input type="date" name="start_date" id="start_date"  placeholder="dd/mm/yyyy"  class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày kết thúc -->
                    <div class="row">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Kết thúc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_end_date" >
                            <input type="date" name="end_date" id="end_date"  placeholder="dd-mm-yyyy" class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                        
                    </div>
                </form> --}}
                <div id="html_append">
                    
                </div>
            </div>
            <div class="modal-footer py-2 mx-0 px-3">
                <div class="row">
                    <div class="col-lg-12 text-righ">
                        <button type="button" class="btn btn-primary py-2" id="btn_update_filter">
                            Cập nhật
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .div_label {
        align-self: center; 
        justify-content: end;
    }
    .span_lbl {
        font-size:13px;
        /* font-weight: 700; */
    }
</style>