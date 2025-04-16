<div class="modal fade" id="semestersModalCreate" tabindex="-1" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo học kỳ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3 semesters_name_wrapper">
                        <label for="">Tên học kỳ <span class="text-danger">*</span></label>
                        <input id="semesters_name" type="text" placeholder="Nhập tên học kỳ" class="form-control" required>
                        <p class="error-input mt-1"></p>
                    </div>
                    <div class="col-12 mb-3 semesters_from_year_wrapper">
                        <label for="">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" id="semesters_from_year" name="candidate_dob" class="form-control" required>
                        <p class="error-input mt-1"></p>
                    </div>
                    <div class="col-12 mb-3 semesters_to_year_wrapper">
                        <label for="">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" id="semesters_to_year" name="candidate_dob" class="form-control" required>
                        <p class="error-input mt-1"></p>
                    </div>
                    <div class="col-12 mb-3 semesters_academic_wrapper">
                        <label for="">Niên khóa <span class="text-danger">*</span></label>
                        <select name="" id="semesters_academic" class="form-select" required>
                            <option value="">Chọn niên khóa</option>
                            @if(isset($academic_data))
                                @foreach ($academic_data as $item)
                                    <option value="{{$item['name']}}">{{$item['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <p class="error-input mt-1"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="semesters_btn_submit" type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
