<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>
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
					<div class="text-center d-logo" style="margin-top: 40px;">
                        <img src="/assets/image/logo.png" alt="" id="crm-logo" style="width:350px;"> 
					</div>                    
					<div class="card shadow-lg my-4">
						<div class="card-body py-3">
							<div class="text-center my-4">
                                <h1 class="fs-4 card-title fw-bold mb-4">Đăng nhập</h1>
                            </div>
							<div class="form-login px-4">
								<form id="crm-form-login" autocomplete="off">
									{{ csrf_field() }}
									<div class="mb-3 crm-email-login-wrapper">
										<label class="title-14 mb-2 text-dark" for="email">
											Nhập số điện thoại hoặc email:
										</label>
										<input id="crm-email-login" type="text" class="form-control input-form" name="email" value="" required  autocomplete="off"  placeholder="Nhập Email hoặc Số Điện Thoại">
										<div class="title-14 pt-2 e-error-msg error-input" style="width:auto;"></div>
									</div>
									<div class="mb-3 d-password crm-password-login-wrapper">
										<label class="title-14 mb-2 text-muted" for="password">Mật khẩu</label>
                                        <div style="position:relative;">
                                            <input id="crm-password-login" type="password" class="form-control input-form show-password" name="password" required autocomplete="off"  placeholder="Nhập mật khẩu">
                                            <i class="fa fa-eye" aria-hidden="true" id="icon-show"></i>										
                                        </div>
										<div class="title-14 pt-2 p-error-msg error-input"></div>
									</div>
									<div class="align-items-center d-flex d-login my-2">
										<button type="submit" class="btn btn-primary ms-auto w-100" id="btnLogin" style="background-color:#034EA2">
											Đăng nhập
										</button>										
									</div>
									<div class="d-flex justify-content-end">
										<a href="{{route('crm.forgotPassword')}}" style="font-size: 14px;font-style: italic;">
											Quên mật khẩu?
										</a>
									</div>		
									<div class="title-14 crm-result"></div>
									<div class="align-items-center text-center my-4">
										<input type="checkbox" name="chkRemember" id="chkRemember"> 
										<span class="tilte-14 px-2">Ghi nhớ đăng nhập</span>
									</div>	
									
								</form>
							</div>
						</div>	
						<div class="text-center mb-5">
							<span class="title-14">Chưa có tài khoản? </span>
							<a href="{{ route('crm.register') }}" class="text-primary title-14 lnkReister" style="text-decoration:none;">Đăng ký</a>							
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