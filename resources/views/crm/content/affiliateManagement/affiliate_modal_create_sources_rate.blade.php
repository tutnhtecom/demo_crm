<div class="modal fade" id="sourceRateCreateModal" tabindex="-1" aria-labelledby="sourceRateCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">Tạo khoản chi cho {{$document['signed_document'] ?? null}} - {{$document['code'] ?? null}}</h5> -->
                <h5 class="modal-title" id="exampleModalLabel">Tạo mới khoản chi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-2">
                <form id="form_create_sources_rate">                    
                    <div class="row">
                        <div class="col-6 my-3">
                            <input type="text" name="sources_id" value="{{$data['id']}}" class="form-control" hidden>
                            <!-- <input type="text" name="payment_type" value="1" class="form-control" hidden>
                            <input type="text" name="payment_manager_type" value="1" class="form-control" hidden> -->
                            <input type="text" id="sources_documents_id" name="sources_documents_id" value="0" class="form-control" hidden>
                        </div>
                        <div class="col-12 expense_name_wrapper mb-3">
                            <label for="" class="form-label">Tên Khoản chi <span class="text-danger">*</span></label>
                            <select id="expense_name" class="form-select" name="expense_name"
                                data-placeholder="Chọn tên khoản chi..." data-label="Chọn Tên khoản chi..." data-dropdown-parent="#affiliateCreateModal" required>
                                <option value="">Chọn tên khoản chi</option>
                                <option value="Phí dịch vụ TVTS">Phí dịch vụ TVTS</option>
                                <option value="CSVC">CSVC</option>
                            </select>                 
                            <!-- <input type="text" id="expense_name" name="expense_name" placeholder="Nhập" class="form-control" required> -->
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    {{-- <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <div class="form-check form-check-sm d-flex justify-content-start align-items-center gap-1">
                                <input class="form-check-input cursor-pointer" type="checkbox" name="is_single" value="" id="is_single_check" checked>
                                <label class="form-check-label text-gray-900" for="">
                                    Tạo khoản chi cho từng học kỳ
                                </label>
                            </div>
                        </div>
                    </div>                     --}}
                    <div class="row my-3">
                        {{-- Niên khoá --}}
                        {{-- <div class="col-6 mb-3">
                            <label for="modal_thread" class="form-label">Niên khoá <span
                                class="text-danger">*</span></label>
                                @if (!empty($dataAcademicTerms))
                                    <select id="academic_terms" name="academic_terms_id" aria-label="Chọn Niên khoá"
                                        data-control="select" data-placeholder="Chọn Niên khoá" class="form-select">
                                        <option value="-" selected> Chọn Niên khoá </option>
                                        @foreach($dataAcademicTerms as $k => $item)
                                            <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}"> {{ $item['name'] }} {{ !empty($item['from_year']) && !empty($item['to_year']) ? '('.$item['from_year'].'-'.$item['to_year'].')' : '' }} </option>
                                        @endforeach
                                    </select>
                                @endif                                
                            <p class="error-input mt-1"></p>                    
                        </div> --}}
                        {{-- Học kỳ --}}
                        <div class="col-12 mb-3 semesterSelectWrapper">
                            <label for="modal_thread" class="form-label">Học kỳ 
                                <span class="text-danger">*</span>
                            </label>
                            <select id="semesterSelect" name="semesters_id" aria-label="Chọn Học kỳ"
                                    data-placeholder="Chọn Học kỳ" class="form-select">
                                @foreach ($dvlk_semesters as $item)
                                    @if($item->types == 1)
                                        <option value="{{$item->id}}"> {{$item->note}} </option>
                                    @endif    
                                @endforeach
                            </select>                                    
                            <p class="error-input mt-1"></p>                    
                        </div>
                    </div>
                    {{-- <div><label class="form-label"><input type="radio" name="enable_dktt" value="0" > Không cần điều kiện thanh toán </label></div> --}}
                    <div><label class="form-label"><input type="radio" name="enable_dktt" value="1" checked> Cần điều kiện thanh toán</label></div>
                    <div class="hte-form-wrapper">
                        <div class="mb-3">
                            <div class="row d-flex flex-stack">
                                <div class="d-flex align-items-center">
                                    <label>Số lượng sinh viên </label>
                                    <div class="mx-4">
                                        <div class="py-1">
                                            <label>
                                                <input type="radio" name="math_sign" value=">=" required>
                                                Lớn hơn hoặc bằng (>=)
                                            </label>
                                        </div>
                                        <div class="py-1">
                                            <label>
                                                <input type="radio" name="math_sign" value="<" required>
                                                Nhỏ hơn (<)
                                            </label>
                                        </div>
                                    </div>
                                    <!-- width:30ch;border:0; border-bottom: 1px solid #ccc;border-radius: 0 -->
                                    <input type="number" name="payment_condition" placeholder="1-9999" min="1" max="9999" class="form-control" class="mx-2"style="width: 12ch;" required>                                    
                                    <span class="px-2 mx-2"></span>
                                    <input type="text" name="payment_units" id="payment_units" placeholder="Nhập đơn vị tính" class="form-control" class="" style="width:30ch;" required>                                    
                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Mức chi cho đơn vị(%) <span class="text-danger">*</span></label>
                                <input type="number" min="0" max="100" name="payment_rate" placeholder="20" class="form-control" required>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Mức chi cho nhân sự phụ trách tuyển sinh/ sinh viên tuyển được (vnđ) <span class="text-danger">*</span></label>
                                <input id="payment_manager_price" type="text" min="0" max="3000000" name="payment_manager_price" placeholder="300000" class="form-control" required>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Mức chi cho nhân sự quản lý(%) <span class="text-danger">*</span></label>
                                <input type="number" min="0" max="100" name="payment_manager_rate" placeholder="5" class="form-control" required>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <label for="" class="form-label">Thời gian thực hiện thanh toán</label>
                            <select id="payment_note" class="form-select" name="payment_note"
                                data-placeholder="Chọn thời gian thanh toán..." data-label="Chọn thời gian thanh toán..." 
                                data-dropdown-parent="#affiliateCreateModal" required>
                                <option value="">Chọn thời gian thanh toán</option>
                                <option value="Học kỳ đầu tiên">Học kỳ đầu tiên</option>
                                <option value="Từng học kỳ">Từng học kỳ</option>
                            </select>     
                            <!-- <input type="text"  name="payment_note" class="form-control" required> -->
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_create_sources_rate" type="button" class="btn_create_sources_rate btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
