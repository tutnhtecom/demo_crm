{{-- <button type="button" class="btn-support" data-bs-toggle="modal" data-bs-target="#support-modal">
    <div class="d-flex align-items-center justify-content-center">
        <img src="/assets/image/support-icon.png" alt="">
        <p style="margin-bottom:0">Hỗ trợ tư vấn</p>
    </div>
</button> --}}
<div class="modal fade" id="support-modal" tabindex="-1" aria-labelledby="support-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="support-modal-label"><strong>Yêu cầu hỗ trợ</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-support">
                    @csrf
                    <div class="support-fullname-wrapper support-wrapper">
                        <label for="">
                            Họ và tên <span class="required">&#42;</span>
                        </label>
                        <input id="support-fullname" type="text" placeholder="Họ và tên">
                        <p class="error-input"></p>
                    </div>
                    <div class="support-email-wrapper support-wrapper">
                        <label for="">
                            Email <span class="required">&#42;</span>
                        </label>
                        <input id="support-email" type="email" placeholder="Email">
                        <p class="error-input"></p>
                    </div>
                    <div class="support-phone-wrapper support-wrapper">
                        <label for="">
                            Số điện thoại <span class="required">&#42;</span>
                        </label>
                        <input id="support-phone" type="number" placeholder="Số điện thoại">
                        <p class="error-input"></p>
                    </div>
                    <div class="support-question-wrapper support-wrapper">
                        <label for="">
                            Để lại câu hỏi <span class="required">&#42;</span>
                        </label>
                        <textarea id="support-question" type="text" placeholder="Để lại câu hỏi"></textarea>
                        <p class="error-input"></p>
                    </div>
                    <div class="support-file-wrapper support-wrapper">
                        <label for="">
                            File đính kèm
                        </label>
                        <div class="support-file-input">
                            <span class="placeholder-text">Tải lên</span>
                            <input type="file" id="support-file">
                            <span class="icon" style="z-index:1000;">
                                <img src="/assets/image/icon-upload.png" alt="" class="upload-icon" >
                                <img src="/assets/crm/media/svg/crm/delete.svg" class="delete-icon" alt="Xóa" width="18" height="18" style="display: none;">
                            </span>
                        </div>
                        <p class="error-input"></p>
                    </div>
                    <div class="support-submit-wrapper mb-3">
                        <button type="submit">
                            <span class="support-btn-text">Gửi</span>
                            <div class="support-loader" style="display:none">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </button>
                    </div>
                    <div class="success-form-wrapper" style="display:none;"> <p class="success-form" ></p> </div>
                </form>
            </div>
        </div>
    </div>
</div>
