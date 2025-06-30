<div class="modal fade" id="modalChangeMultiStatus" tabindex="-1" aria-labelledby="statusModalChangeLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalChangeLabel">Chọn trạng thái cần chuyển đổi<span
                        class="item_full_name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" data-ti-menu="true" id="">
                    <div class="d-flex flex-column bg-white bgi-no-repeat rounded p-4">
                        <select id="status-filter-change" data-label="Chọn trạng thái" data-control="select2"
                            data-multi-checkboxes="true" data-select-all="true" data-hide-search="true"
                            class="form-select">
                            <option value="">Chọn trạng thái</option>
                            @foreach ($status as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_success_change_status" type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 ">
                    <span class="d-none d-md-block" style="padding:10px;">Xác nhận</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#status-filter-change').on('change', function () {
        var selectedValue = $(this).val(); // Lấy giá trị đã chọn
        $('#btn_success_change_status').attr('data-status-id', selectedValue);
    });
</script>