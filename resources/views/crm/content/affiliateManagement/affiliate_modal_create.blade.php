<div class="modal fade" id="affiliateCreateModal" tabindex="-1" aria-labelledby="affiliateCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo thông tin đơn vị liên kết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form action="" id="create_affiliate_form">
            <div class="modal-body">
                <div class="form_create_affiliate">
                    <label for="" class="form-label" style="font-style:italic;text-decoration:underline;">
                        Thông tin đơn vị liên kết
                    </label>
                    <br>
                    <!-- Họ và tên  và phân loại -->
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 affiliate_sources_wrapper mb-3">
                            <label for="" class="form-label">Phân loại <span class="text-danger">*</span></label>
                            <!-- data-control="select2" -->
                            <select id="affiliate_sources" class="form-select"
                                    data-placeholder="Chọn phân loại" data-label="Chọn phân loại" data-dropdown-parent="#affiliateCreateModal" required>
                                    <option value="">Chọn phân loại</option>
                                    <option value="ĐVLK với Trường">ĐVLK với Trường</option>
                                    <option value="ĐVLK với Trung tâm">ĐVLK với Trung tâm</option>
                            </select>
                            <!-- <input type="text" id="affiliate_sources" placeholder="Nhập" class="form-control" required> -->
                        </div>
                        <div class="col-lg-6 col-md-6 affiliate_name_wrapper mb-3">
                            <label for="" class="form-label">Tên đơn vị liên kết <span class="text-danger">*</span></label>
                            <input type="text" id="affiliate_name" placeholder="Nhập" class="form-control" required>
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Chọn địa phương -->
                    <div class="row mb-3">
                        <div class="col-12 affiliate_location_wrapper mb-3">
                            <label for="" class="form-label">Địa phương <span class="text-danger">*</span></label>
                            <select id="affiliate_location" data-control="select2" class="form-select"
                                    data-placeholder="Chọn địa phương" data-label="Chọn địa phương" data-dropdown-parent="#affiliateCreateModal" required>
                                    <option value="">Chọn địa phương</option>
                                    @foreach ($cities as $item)
                                        <option value="{{$item['name']}}">{{$item['name']}}</option>
                                    @endforeach
                            </select>
                            {{-- <input type="text" id="affiliate_location" placeholder="Nhập" class="form-control"> --}}
                        </div>
                    </div>
                    <hr>
                    <!-- Thông tin lãnh đạo -->
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="" class="form-label" style="font-style:italic;text-decoration:underline;font-size:14px">
                                Thông tin lãnh đạo
                            </label>                            
                        </div>
                       <!-- Họ và tên lãnh đạo                          -->
                        <div class="col-lg-6 col-md-6">
                            <label for="" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" id="affiliate_manager_name" placeholder="Nhập" class="form-control" required>
                        </div>   
                        <!-- Chức vụ -->
                        <div class="col-lg-6 col-md-6 affiliate_employee_wrapper mb-3">
                            <label for="" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                            <input type="text" id="affiliate_manager_position" placeholder="Nhập" class="form-control" required>
                        </div>
                        <!-- Email -->
                        <div class="col-lg-6 col-md-6 affiliate_employee_wrapper mb-3">
                            <label for="" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" id="affiliate_manager_email" placeholder="Nhập" class="form-control" required>
                        </div>
                        <!-- Số điện thoại -->
                        <div class="col-lg-6 col-md-6 affiliate_employee_wrapper mb-3">
                            <label for="" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" id="affiliate_manager_phone" placeholder="Nhập" class="form-control" required>
                        </div>
                    </div>
                    <hr>
                    <!-- Thông tin nhân sự -->
                    <div class="employees_key_contact_wrapper">
                        <div class="row mb-3 employee_record">
                            <div class="col-lg-12 col-md-">
                                <label for="" class="form-label" style="font-style:italic;text-decoration:underline;">
                                    Thông tin nhân sự đầu mối 1
                                </label>
                            </div>
                            <!-- Họ tên -->                            
                            <div class="col-lg-6 col-md-6 employee_fullName_wrapper mb-3">
                                <label for="" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" id="" name="employees[0][name]" placeholder="Nhập" class="form-control" required>
                            </div>
                            <!-- Chức vụ -->
                            <div class="col-lg-6 col-md-6 employee_position_wrapper mb-3">
                                <label for="" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                                <input type="text" id="" name="employees[0][position]" placeholder="Nhập" class="form-control" required>
                            </div>
                            <!-- Email -->
                            <div class="ccol-lg-6 col-md-6 employee_email_wrapper mb-3">
                                <label for="" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" id="" name="employees[0][email]" placeholder="Nhập" class="form-control" required>
                            </div>
                            <!-- Số điện thoại -->
                            <div class="col-lg-6 col-md-6 employee_phone_wrapper mb-3">
                                <label for="" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" id="" name="employees[0][phone]" placeholder="Nhập" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button id="add_employee_key_contact" type="button" class="btn btn-primary">Thêm nhân sự</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="affiliate_btn_create" type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </form>
        </div>
    </div>
</div>
