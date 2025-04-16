<div class="modal fade" id="edit_custom_field_modal_{{$item['id']}}" tabindex="-1" aria-labelledby="edit_custom_field_modal_{{$item['id']}}_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa trường tùy chỉnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input_field_name_wrapper">
                    <input id="input_field_name_{{$item['id']}}" value="{{$item['name']}}" type="text" placeholder="Nhập tên trường tùy chỉnh" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button id="" type="button" class="btn btn-primary btn_edit_custom_field" data-id="{{$item['id']}}">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
