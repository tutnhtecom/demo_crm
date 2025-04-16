<div class="modal fade" id="update_field_lead_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa trường tùy chỉnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="extended-fields-container" class="modal-body">
                @if (!empty($dataId->extended_fields))
                    @foreach ($dataId->extended_fields as $key => $value)
                        <div class="row mb-1">
                            <div class="col-4" style="padding-right:3px;">
                                <select class="form-select key_field_selected" disabled>
                                    <option value="{{ str_replace('_', ' ', $key) }}">{{ str_replace('_', ' ', $key) }}</option>
                                </select>
                            </div>
                            <div class="col-7" style="padding-left:3px;">
                                <input type="text" value="{{$value}}" class="form-control value_field_selected">
                            </div>
                            <div class="col-1" style="padding-left:3px;">
                                <button type="button" class="btn btn-ghost p-1 delete_row_custom_field">
                                    <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18">
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Không có dữ liệu</p>
                @endif
            </div>
            <div class="modal-footer">
                <button id="btn_update_field_lead" type="button" class="btn btn-primary" data-id={{$dataId->id}}>Lưu</button>
                <button id="add-row-btn" type="button" class="btn btn-primary">Thêm trường tùy chỉnh</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
