@php
$fields = config('data.leads.display_fields');
@endphp
<div class="modal fade modal-lg" id="exLeadsLists" tabindex="-1" aria-labelledby="modal_import_price_list">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Xuất file</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-2">
                <form id="form-checkout-fields">
                    <div class="row my-3">
                        <div class="col-6" style="align-seft:center">
                            <h5>Chọn lựa trường dữ liệu để xuất file</h6>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary mx-3" id="selectAll">Chọn tất cả</button>
                            <button type="button" class="btn btn-secondary" id="unSelectAll">Bỏ chọn tất cả</button>
                        </div>
                        <div class="row py-4">
                            @if (count($fields) > 0)
                            @foreach ( $fields as $field )
                                <!-- border:0; border-bottom:1px dotted #ccc; -->
                                <div class="col-lg-4 py-2" style="{{!isset($field['no_style']) ? 'border:0; border-bottom:1px dotted #ccc;' : ''}}">
                                    <input type="checkbox" name="check-field" id="check-field" data-field="{{ $field["field_name"] }}" checked class="checkbox">
                                    <span class="px-2" style="font-size:16px;">{{ $field["display_name"] }}</span>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </form>                
            </div>
            <div class="modal-footer mb-2 py-2" style="border: 0px">
                <button id="btn_export_items" type="button" data-type="lead"
                    class="btn btn-primary lh-0 d-flex align-items-center gap-1 py-3 my-0">
                    <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                    <span class="d-none d-md-block">Xuất file</span>
                </button>                
                <button type="button" class="btn btn-secondary py-3" data-bs-dismiss="modal" >Đóng</button>
            </div>
        </div>
    </div>
</div>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/exportItems.js') }}"></script>

