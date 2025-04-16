<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TT Đào tạo trực tuyến – Trường Đại học Mở Tp. Hồ Chí Minh | @yield('title')</title>
	<!-- include file css -->
	@include('includes.stylesheet')
</head>

<body class="body-regiter-profile">
    <section class="h-100 sContent">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9 d-general">
					<div class="text-center d-logo mt-4">
                        <img src="/assets/image/logo.png" alt="" id="logo-register-profile">
					</div>
                    <div class="text-center mb-3 d-logo text-light">
                        <h6 style="color:#fff">
                        	<strong>Chào mừng bạn đến với trang đăng ký hồ sơ tuyển sinh</strong>
                        </h6>
					</div>
					<div class="card shadow-lg">
						<div class="card-body pt-3 pb-5">
							<div class="text-center">
                                <h1 class="card-title mb-4">Đăng nhập để theo dõi kết quả hồ sơ</h1>
                            </div>
							<div class="form-login px-4">
								<form autocomplete="off" method="POST">
									<div class="mb-3 email-login-lead-wrapper">
										<label class="mb-2 text-dark" for="email">Địa chỉ email hoặc số điện thoại</label>
										<input id="email-lead-login" type="email" class="form-control email-login-lead" name="email" value="" required  autocomplete="off"  placeholder="Nhập">
										<div class="error-message"></div>
									</div>
									<div class="mb-3 password-login-lead-wrapper">
										<label class="mb-2 text-muted" for="password">Mật khẩu</label>
                                        <div class="block-input-password">
                                            <input id="password-lead-login" type="password" class="form-control password-login-lead" name="password" required autocomplete="off"  placeholder="Nhập">
                                            <span id="toggle-password" style="cursor: pointer;">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                        </div>
										<div class="error-message"></div>
									</div>
									<div class="align-items-center d-flex d-login btn-login-wrapper">
										<button type="button" class="btn ms-auto w-100" id="btn-lead-login">
											Đăng nhập
										</button>
                                        <div class="loader-btn-login" style="display:none;"></div>
									</div>
									<div class="align-items-center d-flex justify-content-end">
										<a class="btn ms-auto" id="btn_lead_forgot_password" data-bs-toggle="modal" data-bs-target="#lead_forgot_password_modal">
											Quên mật khẩu?
										</a>
										<div class="modal fade" id="lead_forgot_password_modal" tabindex="-1" aria-labelledby="lead_forgot_password_label" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
												<div class="modal-header">
													<h1 class="modal-title fs-5" id="exampleModalLabel">Nhập Emal để cấp lại mật khẩu</h1>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<div class="email_forgot_password_wapper">
														<input type="text" id="email_forgot_password" placeholder="Nhập Email" class="form-control">
													</div>
												</div>
												<div class="modal-footer">
													<button id="forgot_password_submit" type="button" class="btn btn-primary">Gửi</button>
													<button id="forgot_password_close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
												</div>
												</div>
											</div>
										</div>
									</div>
									<p id="error-lead-login" style="display:none;"></p>
									<p class="form-text text-dark my-3 text-center" id="divOr">                                    
										<span class="titleOr"> Nếu chưa có hồ sơ, hãy nhấn nút bên dưới </span>                                    
									</p>
									<div class="align-items-center d-flex d-regiter">
                                        {{-- <button type="button" class="btn btn-warning ms-auto w-100"  id="btnRegister"> --}}
                                            <a href="{{ route('Leads.register') }}" id="btn-register-lead" class="btn ms-auto w-100">
                                                Đăng ký hồ sơ	
                                            </a>
                                        {{-- </button> --}}
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
</body>

</html>