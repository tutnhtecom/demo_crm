<div class="tab-pane fade my-4" id="learning-fee" role="tabpanel" aria-labelledby="leads_by_sources">
    {{-- <div class="row">
        <div class="col-lg-1 col-md-1 align-self-center text-lg-start mx-2" >
            <label for="modal_thread" class="form-label">Chọn Niên khoá:</label>
        </div>
        <div class="col-lg-3 col-md-3">
            @if (!empty($dataAcademicTerms))
                <select id="academic_terms_leads_fee" name="academic_terms_leads_fee" aria-label="Chọn Niên khoá"
                    data-control="select2" data-placeholder="Chọn Niên khoá" class="form-select mb-3">
                    <option value="-" selected> Chọn Niên khoá </option>
                    @foreach($dataAcademicTerms as $k => $item)
                    <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}"> {{ $item['name'] }} {{ !empty($item['from_year']) && !empty($item['to_year']) ? '('.$item['from_year'].'-'.$item['to_year'].')' : '' }} </option>
                    @endforeach
                </select>
            @endif
        </div>
    </div> --}}
    <div class="row">
        {{-- <div class="col-12">
            <div class="table-responsive position-relative border rounded-3 my-3">
                <table class="table-leads_by_sources table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0" id="table_leads_fee">                   
                </table>
            </div>
        </div> --}}

        <div class="col-12">
            <div class="table-responsive position-relative border rounded-3 my-3">
                {{-- <table border="1" cellspacing="0" cellpadding="8" data-id="{{ $data['id'] }}" class="table_tthh table-leads_by_sources table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
                    <thead>
                        <tr class="text-white text-nowrap fs-5 text-center">
                            <th colspan="16">ĐVLK: TT GDTX tỉnh BR-VT</th>
                        </tr>
                        <tr class="text-white text-nowrap fs-5 text-center">
                            <th rowspan="3">STT</th>
                            <th rowspan="3"> <div>Khóa tuyển sinh</div> </th>
                            <th colspan="18">2023-2024</th>
                            <th colspan="8">2024-2025</th>
                        </tr>
                        <tr class="text-white text-nowrap fs-5 text-center">
                            <th colspan="6">Học kỳ 1</th>
                            <th colspan="6">Học kỳ 2</th>
                            <th colspan="6">Học kỳ 3</th>
                            <th colspan="6">Học kỳ 1</th>
                        </tr>
                        <tr class="text-white text-nowrap fs-5 text-center">
                            <th>Số lượng SV nhập học</th>
                            <th>Học phí</th>
                            <th>Định mức thanh toán</th>
                            <th>Thời gian thực hiện thanh toán</th>
                            <th>ĐV</th>
                            <th>CN</th>
                            
                            <th>Số lượng SV nhập học</th>
                            <th>Học phí</th>
                            <th>Định mức thanh toán</th>
                            <th>Thời gian thực hiện thanh toán</th>
                            <th>ĐV</th>
                            <th>CN</th>

                            <th>Số lượng SV nhập học</th>
                            <th>Học phí</th>
                            <th>Định mức thanh toán</th>
                            <th>Thời gian thực hiện thanh toán</th>
                            <th>ĐV</th>
                            <th>CN</th>

                            <th>Số lượng SV nhập học</th>
                            <th>Học phí</th>
                            <th>Định mức thanh toán</th>
                            <th>Thời gian thực hiện thanh toán</th>
                            <th>ĐV</th>
                            <th>CN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Khóa 02/2024</td>
                            <td>10</td>
                            <td>20.000.000</td>
                            <td>300.000 / 5%</td>
                            <td>Học kỳ đầu tiên</td>
                            <td>300.000 / 150.000</td>
                            <td>300,000</td>
                        </tr>
                    </tbody>
                </table> --}}

                <table border="1" cellspacing="0" cellpadding="8" data-name-dvlk="{{ $data['name'] }}" id="datatable_commission" data-id="{{ $data['id'] }}" class="table_tthh table-leads_by_sources table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
                    <thead id="thead_commission">
                        
                    </thead>
                    <tbody id="tbody_commission"></tbody>
                </table>
                
            </div>
        </div>
    </div>
    
    <script type="module" src="/assets/crm/js/htecomJs/dvlk_commission.js"></script>
</div>

