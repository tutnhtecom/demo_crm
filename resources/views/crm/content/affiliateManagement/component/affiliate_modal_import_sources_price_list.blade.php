<div class="modal fade" id="importSourcesPriceListsModal" tabindex="-1" aria-labelledby="importSourcesPriceListsModalLabel" aria-hidden="true">
    @php
        $a
    @endphp
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import danh sách Học phí cho ĐVLK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row my-3">                    
                    <!-- Chọn niên khóa -->
                    {{-- <div class="col-6 mb-3">
                        <label for="modal_thread" class="form-label">Niên khoá 
                            <span class="text-danger">*</span>
                        </label>
                        <select id="academic_terms" name="academic_terms_id" aria-label="Chọn Niên khoá"
                            data-control="select" data-placeholder="Chọn Niên khoá" class="form-select">
                            <option value="-" selected> Chọn Niên khoá </option>
                            @if(isset($academic_terms) && is_array($academic_terms) && count($academic_terms) > 0) 
                                @foreach($academic_terms as $k => $item)
                                <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}"> 
                                    {{ $item['name'] }} {{ !empty($item['from_year']) && !empty($item['to_year']) ? '('.$item['from_year'].'-'.$item['to_year'].')' : '' }} 
                                </option>
                                @endforeach
                            @endif
                        </select>
                        <p class="error-input mt-1"></p>                    
                    </div> --}}

                    <!--Chọn học kỳ -->
                    <div class="col-12 mb-3 semesterSelectWrapper">
                        <label for="modal_thread" class="form-label">Học kỳ 
                            <span class="text-danger">*</span>
                        </label>
                        <select id="dvlk_semester" name="semesters_id" aria-label="Chọn Học kỳ"
                                data-placeholder="Chọn Học kỳ" class="form-select" aria-placeholder="Chọn Học kỳ">
                            @foreach ($dvlk_semesters as $item)
                                @if($item->types == 1)
                                    <option value="{{$item->id}}"> {{$item->note}} </option>
                                @endif    
                            @endforeach
                        </select>                                    
                        <p class="error-input mt-1"></p>                    
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-12">
                        <input id="dvlk_import_price_list" type="file" class="form-control" style="border:0;border-bottom: 1px solid #ccc; border-radius: 0;">
                        <p class="mt-4" style="margin-bottom:0;font-size:12px;"> Tải file mẫu: <a href="assets/file/danh_sach_hoc_phi_cua_dvlk.xlsx">FILE MẪU</a> </p>
                        <p class="error_log_leads mt-3" style="margin-bottom:0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="dvlk_close_modal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button id="dvlk_import_price_list_btn" type="button" class="btn btn-primary">Tải lên</button>
            </div>

            <div class="show_err" style="color:red;padding: calc(var(--bs-modal-padding) - var(--bs-modal-footer-gap)* 0.5);">
            </div>
        </div>
    </div>
</div>