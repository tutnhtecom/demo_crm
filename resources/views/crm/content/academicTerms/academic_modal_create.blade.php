<div class="modal fade" id="academicModalCreate" tabindex="-1" aria-labelledby="academicModalCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header my-0 py-4">
                <h5 class="modal-title" id="exampleModalLabel">Tạo khóa tuyển sinh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body my-0 py-2">
                <div class="row">
                    <div class="col-12 academy_name_wrapper mb-3">
                        <label for="" class="form-label"> Khóa tuyển sinh 
                        <!-- <span class="text-danger">*</span> -->
                        </label>
                        <select id="academy_name" class="form-select" name="academic_name"
                            data-placeholder="Chọn khóa tuyển sinh" data-label="Chọn khóa tuyển sinh" data-dropdown-parent="#affiliateCreateModal" required>
                            @foreach ($academy_list as $academy_list_item)
                                <option value="{{$academy_list_item->id}}">{{$academy_list_item->name}}</option>
                            @endforeach
                        </select>                 
                        <p class="error-input mt-1"></p>
                    </div>
                    <div class="col-12 mb-3 admission_year_wrapper">
                        <label for="">Năm tuyển sinh <span class="text-danger">*</span></label>
                        <input id="admission_year" type="text" placeholder=" Nhập năm tuyển sinh" class="form-control">
                        <p class="error-input mt-1"></p>
                    </div>
                    <div class="col-12 mb-3 admission_semesters_wrapper">
                        <label for="" class="form-label">Học kỳ nhập học <span class="text-danger">*</span></label>
                        <input id="admission_semesters" type="text" placeholder="" class="form-control" disabled>
                        <p class="error-input mt-1"></p>
                    </div>
                    <div class="col-12 mb-3 academy_opening_day_wrapper">
                        <label for="">Ngày khai giảng <span class="text-danger">*</span></label>
                        <input type="date" id="academy_opening_day" name="academy_opening_day" class="form-control">
                        <p class="error-input mt-1"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer my-0 py-2">
                <button id="academy_btn_submit" type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
