<div class="modal fade" id="affiliateEditModal" tabindex="-1" aria-labelledby="affiliateEditModalLabel">
    <div class="modal-dialog" style="min-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin đơn vị liên kết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="update-affiliate-info" id="update-affiliate-info">
                <div class="modal-body">
                    <div class="form_create_affiliate">
                        <label for="" class="form-label" style="font-style:italic;text-decoration:underline;">
                            Thông tin đơn vị liên kết
                        </label>
                        <br>
                         <!-- Phân loại --> <!-- Tên đơn vị liên kết -->
                        <div class="row mb-3">
                            <!-- Phân loại -->
                            <div class="col-lg-6 col-md-6 affiliate_sources_wrapper mb-3">
                                <label for="" class="form-label">Phân loại <span class="text-danger">*</span></label>                              
                                <select id="affiliate_sources" class="form-select"
                                    data-placeholder="Chọn phân loại" data-label="Chọn phân loại" data-dropdown-parent="#affiliateCreateModal" required>
                                    <option value="">Chọn phân loại</option>
                                    <option value="ĐVLK với Trường" @if(isset($data['sources_types']) && $data['sources_types'] == "ĐVLK với Trường") selected  @endif >
                                        ĐVLK với Trường
                                    </option>
                                    <option value="ĐVLK với Trung tâm" @if(isset($data['sources_types']) && $data['sources_types'] == "ĐVLK với Trung tâm") selected  @endif >
                                        ĐVLK với Trung tâm
                                    </option>
                                </select>                                
                            </div>
                            <!-- Tên đơn vị liên kết -->
                            <div class="col-lg-6 col-md-6 affiliate_name_wrapper mb-3">
                                <label for="" class="form-label">Tên đơn vị liên kết <span class="text-danger">*</span></label>
                                <input type="text" id="affiliate_name" name="affiliate_name" value="{{$data['name']}}" class="form-control" required>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!-- Địa phương -->
                        <div class="row mb-3">
                            <div class="col-12 affiliate_location_wrapper mb-3">
                                <label for="" class="form-label">Địa phương </label>
                                <input type="text" id="affiliate_location" name="affiliate_location" value="{{$data['location_name']}}" class="form-control" hidden>
                                <input type="text" id="affiliate_location" name="affiliate_location_show" value="{{$data['location_name']}}" class="form-control" required disabled>
                                <i>Không thể thay đổi vì ảnh hưởng đến mã ĐVLK</i> <b>{{$data['code']}}</b>
                            </div>
                        </div>
                        <hr>
                        <!-- Thông tin lãnh đạo -->                         
                        <!-- ----------------------------------------------------------------------------------------------------------- -->
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="" class="form-label" style="font-style:italic;text-decoration:underline;">
                                    Thông tin lãnh đạo
                                </label>
                            </div>                           
                            @foreach ($managers as $manager)
                            <div class="col-lg-6 col-md-6 affiliate_manager_wrapper mb-3">
                                <label for="" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" id="affiliate_manager_name" name="affiliate_manager_name" value="{{$manager['name']}}" class="form-control" required>
                            </div>
                            <div class="col-lg-6 col-md-6 affiliate_employee_wrapper mb-3">
                                <label for="" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                                <input type="text" id="affiliate_manager_position" name="affiliate_manager_position" value="{{$manager['positions']}}" class="form-control" required>
                            </div>
                            <div class="col-lg-6 col-md-6 affiliate_employee_wrapper mb-3">
                                <label for="" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" id="affiliate_manager_email" name="affiliate_manager_email" value="{{$manager['email']}}" class="form-control" required>
                            </div>
                            <div class="col-lg-6 col-md-6 affiliate_employee_wrapper mb-3">
                                <label for="" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" id="affiliate_manager_phone" name="affiliate_manager_phone" value="{{$manager['phone']}}" class="form-control" required>
                            </div>
                            @endforeach
                        </div>
                        <!-- ----------------------------------------------------------------------------------------------------------- -->
                        <hr>
                        <!-- Thông tin nhân viên -->
                        <!------------------------------------------------------------------------------------------------------------- -->
                        <div class="employees_key_contact_wrapper">
                            @foreach ($employees as $k => $employee)
                                <div class="row mb-3 employee_record">
                                    <div class="col-lg-12 col-md-12">
                                        <label for="" class="form-label" style="font-style:italic;text-decoration:underline;">
                                            Thông tin nhân sự đầu mối {{$k+1}}
                                        </label>
                                    </div>
                                    <!-- <br> -->
                                    <div class="col-lg-6 col-md-6 employee_fullName_wrapper mb-3">
                                        <label for="" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" name="employees[0][name]" value="{{$employee['name']}}" class="form-control" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 employee_position_wrapper mb-3">
                                        <label for="" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                                        <input type="text" name="employees[0][position]" value="{{$employee['positions']}}" class="form-control" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 employee_email_wrapper mb-3">
                                        <label for="" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="text" name="employees[0][email]" value="{{$employee['email']}}" class="form-control" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 employee_phone_wrapper mb-3">
                                        <label for="" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="employees[0][phone]" value="{{$employee['phone']}}" class="form-control" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!------------------------------------------------------------------------------------------------------------- -->
                        <div class="row my-2 ">
                            <div class="col-lg-12 col-md-12 d-flex justify-content-end">
                                <button id="add_employee_key_contact" type="button" class="btn btn-primary my-2">Thêm nhân sự</button>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="affiliate_btn_update" type="submit" class="btn btn-primary" data-id="{{ $data['id'] }}">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>