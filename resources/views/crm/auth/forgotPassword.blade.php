<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quên mật khẩu</title>
    <!-- include file css -->
    @include('includes.stylesheet')
</head>

<body class="b-crm-login">
    <!-- loadding -->
    @include('includes.loading')
    <section class="sContent">
        <div class="container">
            <div class="row justify-content-sm-center">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9 d-general">
                    <div class="text-center d-logo">
                        <img src="/assets/image/logo.png" alt="" id="crm-logo">
                    </div>
                    <div class="card shadow-lg my-4">
                        <div class="card-body py-3">
                            <div class="text-center my-4">
                                <h1 class="fs-4 card-title fw-bold mb-4">Quên mật khẩu</h1>
                            </div>
                            <div class="form-login px-4">
                                <form id="crm-form-forgotpassword" autocomplete="off">
                                    {{ csrf_field() }}
                                    <div class="mb-3 crm-email-forgot-wrapper">
                                        <label class="title-14 mb-2 text-dark" for="email">Nhập Email</label>
                                        <input id="crm-email-forgot" type="text" class="form-control input-form"
                                            name="email" value="" required autocomplete="off"
                                            placeholder="Nhập email">
                                        <div class="title-14 pt-2 e-error-msg error-input"></div>
                                    </div>
                                    <div class="align-items-center d-flex d-login my-2">
                                        <button type="button" class="btn btn-primary ms-auto w-100" id="btnForgot"
                                            style="background-color:#034EA2">
                                            Xác nhận
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- include file js -->
    @include('includes.script')
    <script type="module" src="/assets/crm/js/htecomJs/crm_forgot_password.js"></script>
</body>

</html>
