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
                        <div class="card-body py-1">
                            <div class="text-center mt-4">
                                <h1 class="fs-4 card-title fw-bold">Thay đổi mật khẩu</h1>
                            </div>
                            <div class="form-login px-4">
                                <!-- Email -->
                                <div class="crm-email-forgot-wrapper">
                                    <label class="title-14 mb-2 text-dark" for="email" id="lblEmail" data-email="{{$email}}">
                                        <strong>Email:</strong> 
                                        <i class="px-3"><u>{{$email}}</u></i>
                                    </label>
                                    <div class="title-14 pt-2 e-error-msg error-input"></div>
                                </div>        
                                <!-- Mật khẩu mới-->                           
                                <div class="div-new-password py-2">
                                    <label for="newPassword" class="mb-2">Mật khẩu mới: </label>
                                    <input type="password" id="new_password" class="form-control">
                                    <p class="error-input mt-1"></p>
                                </div>
                                <!-- Nhắc lại mật khẩu: -->
                                <div class="div-confirm-password py-2">
                                    <label for="confirmPassword" class="text-sm font-small text-gray-700 block mb-2">Nhập lại mật khẩu:</label>
                                    <input type="password" id="confirm_password" class="form-control">
                                    <p class="error-input mt-1"></p>
                                </div>  
                                <!-- Button Xác nhận -->
                                <div class="my-4">
                                    <button type="button" class="btn btn-primary w-100" id="forgot_confirm" style="background-color:#034EA2">
                                        Xác nhận
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- include file js -->
    @include('includes.script')
    <script type="module" src="{{ asset('assets/crm/js/htecomJs/change_password_employees.js') }}" ></script>
</body>

</html>