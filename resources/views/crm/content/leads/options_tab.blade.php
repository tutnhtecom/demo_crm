
<div class="tab-pane fade" id="custom-fields" role="tabpanel" aria-labelledby="custom-fields-tab">
    <div class="d-flex mb-3 gap-1">
        <button type="button" class="btn min-w-100px btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#update_field_lead_modal">
            <img src="assets/crm/media/svg/crm/pen.svg" width="14" height="14" />
            <span class="d-none d-md-inline">Chỉnh sửa</span>
        </button>
        @include('crm.content.leads.modal_update_field_for_lead')
    </div>
    <div class="border rounded p-3">
        @if (!empty($dataId->extended_fields))
            @foreach ($dataId->extended_fields as $key => $value)
                <div class="row gy-0 gx-2 mb-1">
                    <div class="col-3 rounded-top border-bottom border-gray-100 bg-primary bg-opacity-80">
                        <div class="d-flex align-items-center text-white h-100 px-4"> {{ str_replace('_', ' ', $key) }}</div>
                    </div>
                    <div class="col-9">
                        <div
                            class="d-flex align-items-center justify-content-between rounded border border-gray-300 w-100 h-100 p-4">
                            {{ $value }}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Không có dữ liệu</p>
        @endif
    </div>
</div>

<script>
    var customFields = <?= json_encode($customFields) ?>;
</script>
