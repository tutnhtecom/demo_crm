<div class="modal fade modal_delete" id="deleteStatusModal{{$status['id']}}" tabindex="-1" aria-labelledby="deleteStatusModal{{$status['id']}}Label" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:160px;">
        <div class="modal-content" style="max-width: 444px">
            <div class="">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="assets/crm/media/svg/crm/danger-triange.svg" alt="">
                </div>
                <div class="d-flex justify-content-center align-items-center" style="font-size:24px;font-weight:600;margin-bottom:15px;"> Xóa bản ghi này? </div>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <button id="btn_delete_sources" type="button" class="btn btn-primary btn_delete_sources" data-id="{{$status['id']}}">Xác nhận</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>

            </div>
        </div>
    </div>
</div>
