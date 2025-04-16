<div class="modal fade" id="taskAuto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chia KPI tự động</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="total_fee_kpi">Tổng học phí phải thu</label>
                    <input type="text" id="total_fee_kpi" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="total_lead_kpi">Tổng thí sinh</label>
                    <input type="text" id="total_lead_kpi" class="form-control">
                </div>
                {{-- <button id="distribute_kpi" class="btn btn-primary">Xác nhận</button> --}}
            </div>
            <div class="modal-footer">
                <button id="distribute_kpi" type="button" class="btn btn-primary">Xác nhận</button>
                <button id="distribute_kpi_close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="mb-3">
    <label for="total_fee_kpi">Tổng học phí phải thu</label>
    <input type="text" id="total_fee_kpi" class="form-control">
</div>
<div class="mb-3">
    <label for="total_lead_kpi">Tổng thí sinh</label>
    <input type="text" id="total_lead_kpi" class="form-control">
</div>
<button id="distribute_kpi" class="btn btn-primary">Xác nhận</button> --}}
