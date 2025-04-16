{{-- <form id="myForm6" class="col-12" method="POST" action="" data-step="6" enctype="multipart/form-data"> --}}
<form id="myForm6" class="col-12" method="POST" action="" data-step="6" style="display:none;">
    @csrf
    <h5 class="text-18 mb-4"> Xác nhận nộp hồ sơ </h5>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="text-14 text-w-500 upload-scan-text"> Upload ảnh scan giấy tờ bao gồm </div>
            <div class="upload-scan-img">
                <div class="d-flex flex-wrap gap-2 upload-img-wrapper mb-4">
                    {{-- <div class="img-upload-preview">
                        <img src="/assets/image/img-example.png" alt="">
                    </div> --}}
                    <div class="fileUpload">
                        <input name="images[]" type="file" class="upload" id="input-upload-f6" accept="image/*,.zip,.rar,.pdf"/>
                        <span class="file-preview" style="text-align: center;font-size: 14px;">
                            Nhấn vào đây để tải file
                            {{-- <img src="/assets/image/img-example.png" alt=""> --}}
                            {{-- <i class="fa fa-plus"></i> --}}
                        </span>
                        {{-- <button type="button" class="btn_remove_upload"><i class="fa fa-trash"></i></button> --}}
                    </div>
                    <div class="btn_add_input_upload"><i class="fa fa-plus"></i></div>
                </div>
                <div id="preview-images" class="preview-container"></div>
                <hr>
                <div class="text-note">
                    <p class="text-14" style="margin-bottom:0">
                        1. Giấy khai sinh: yêu cầu hình ảnh mặt trước và mặt sau <br>
                        2. Căn cước công dân: yêu cầu hình ảnh mặt trước và mặt sau <br>
                        3. Bằng tốt nghiệp/Giấy chứng nhận tốt nghiệp tạm thời: yêu cầu hình ảnh mặt trước và mặt sau <br>
                        4. Học bạ/Bảng điểm: yêu cầu hình ảnh của tất cả các trang của học bạ/bảng điểm <br>
                        5. Chứng chỉ Tin học/Ngoại ngữ: yêu cầu hình ảnh mặt trước và mặt sau <br>
                        6. Hồ sơ khác: yêu cầu hình ảnh mặt trước và mặt sau <br>
                        Lưu ý: các hồ sơ từ 1-4 là bắt buộc
                    </p>
                    <p class="text-14"> (Tối đa 16MB) </p>
                </div>
            </div>
        </div>
        <div class="col-12 text-note-2">
            <p class="text-14">Sinh viên chú ý, phải tiến hành lưu thông tin trước khi in phiếu thông tin. Nếu chưa thực
                hiện lưu thông tin, phiếu thông tin sẽ có dòng chữ "Bản xem trước" và phiếu thông tin này là không hợp
                lệ.</p>
        </div>
    </div>

    <div style="margin-bottom: 150px"></div>
    <div class="row">
        <div class="col-12 d-flex gap-3 justify-content-end">
            <button type="button" id="prevStep6" class="button-custome-back">
                <span>&#10140;</span> Quay lại
            </button>
            <button type="submit" class="button-custome-next">
                Xác nhận nộp <img src="/assets/image/check.png" alt="">
            </button>
        </div>
    </div>
</form>
