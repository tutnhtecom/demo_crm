<div class="tab-pane fade" id="custom-fields" role="tabpanel" aria-labelledby="leads_by_sources">   
    <div class="row">
        {{-- <div class="col-lg-1 col-md-1 align-self-center text-lg-start" >
            <label for="modal_thread" class="form-label">Chọn Niên khoá:</label>
        </div> --}}
        {{-- <div class="col-lg-3 col-md-3">
            @if (!empty($dataAcademicTerms))
                <select id="academic_terms_leads" name="academic_terms_leads" aria-label="Chọn Niên khoá"
                    data-control="select2" data-placeholder="Chọn Niên khoá" class="form-select mb-3">
                    <option value="-" selected> Chọn Niên khoá </option>
                    @foreach($dataAcademicTerms as $k => $item)
                    <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}"> {{ $item['name'] }} {{ !empty($item['from_year']) && !empty($item['to_year']) ? '('.$item['from_year'].'-'.$item['to_year'].')' : '' }} </option>
                    @endforeach
                </select>
            @endif
        </div> --}}
        {{-- <div class="col-lg-12 col-md-12 justify-content-end d-flex">            
            <button id="btn_import_leads" type="button"  class="btn btn-primary d-flex align-items-center gap-2 crm_notification_pricelist mx-2"
                data-bs-toggle="modal" data-bs-target="#modal_import_tractions">
                <img src="assets/crm/media/svg/crm/upload.svg" width="22" height="22" />
                <span class="d-none d-md-block">Nhập dữ liệu</span>
            </button>
        </div> --}}
    </div>
    <div class="row">
        {{-- <div class="col-12">
            <div class="table-responsive position-relative border rounded-3 my-3">
                <table class="table-leads_by_sources table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0" id="table_leads_by_sources">

                </table>
            </div>
        </div> --}}

        <div class="col-12">
            <div class="table-responsive position-relative border rounded-3 my-3">
                <table id="datatable" border="1" cellspacing="0" cellpadding="8" data-id="{{ $data['id'] }}" class="display table_dssv table-leads_by_sources table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0" style="width:100%">
                    <thead id="dynamic-thead"></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="module" src="/assets/crm/js/htecomJs/import_transactions.js"></script>
    <script type="module" src="/assets/crm/js/htecomJs/dvlk_render_student_list.js"></script>
    @include('crm.content.leads.modal.modal_import_transactions_for_leads')
</div>