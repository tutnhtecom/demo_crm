{{-- <div id="banner-lead" class="banner-intro"> --}}
<div id="banner-lead" class="banner-intro" style="display:none">
    <div class="banner-intro-logo">
        <img src="/assets/image/logo.png" alt="">
    </div>
    <div class="banner-intro-info">
        <div class="info-file">
            <h6 class="text-18">Thông tin thí sinh</h6>
            <div class="row mb-2">
                <div class="info-row">
                    <label for="" class="info-label">Mã số hồ sơ</label>
                    <span id="lead_profile_code" class="info-value"></span>
                </div>
            </div>
            <div class="row mb-2">
                <div class="info-row">
                    <label for="" class="info-label">Họ và tên</label>
                    <span id="lead_full_name" class="info-value"></span>
                </div>
            </div>
            <div class="row mb-2">
                <div class="info-row">
                    <label for="" class="info-label">Giới tính</label>
                    <span id="lead_gender" class="info-value"></span>
                </div>
            </div>
            <div class="row mb-2">
                <div class="info-row">
                    <label for="" class="info-label">Ngành học</label>
                    <span id="lead_major" class="info-value"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="info-lead-wrapper">
        @include('page.button_support')
        <div class="button-view-info hidden_button">
            <a id="preview_file_register" href="" target="_blank">
                <button type="button" class="btn-view-file d-flex align-items-center gap-2">
                    <img src="/assets/image/file-check.png" alt=""> Xem trước phiếu thông tin
                </button>
            </a>
        </div>
    </div>
</div>
