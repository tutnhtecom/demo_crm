<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    @include('includes.stylesheet')
    <script src="/assets/js/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            /* background: linear-gradient(135deg,
                    #e6f0fa,
                    #b3cde0); */
            /* Gradient nhẹ với tông xanh */
            min-height: 100vh;
            display: flex;
            /* justify-content: center;
            align-items: center; */
            margin: 0;
        }
    
        .register-form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            /* box-shadow: 0 4px 15px rgba(3, 78, 162, 0.1); */
            /* Bóng nhẹ với tông #034EA2 */
            width: 100%;
            min-width: 400px;
            max-height: 500px;
            height: max-content;
        }
    
        .register-form h2 {
            text-align: center;
            color: #034ea2;
            /* Màu chủ đạo cho tiêu đề */
            margin-bottom: 20px;
            font-size: 24px;
        }
    
        .form-group {
            margin-bottom: 20px;
        }
    
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
    
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease;
        }
    
        .form-group input:focus {
            border-color: #034ea2;
            /* Viền input khi focus */
            outline: none;
            box-shadow: 0 0 5px rgba(3, 78, 162, 0.3);
            /* Hiệu ứng bóng với #034EA2 */
        }
    
        .form-group input::placeholder {
            color: #aaa;
        }
    
        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #034ea2;
            /* Màu chủ đạo cho button */
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
    
        .submit-btn:hover {
            background: #023a7d;
            /* Màu đậm hơn khi hover */
        }

        .success_register{
            padding         : 5px 10px;
            margin          : 14px;
            text-align      : center;
            border          : 1px solid green;
            border-radius   : 5px;
            color           : green; 
            display         :none;
        }
    
        @media (max-width: 480px) {
            .register-form {
                padding: 20px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>TT Đào tạo trực tuyến – Trường Đại học Mở Tp. Hồ Chí Minh - </title>
    </head>
    <body>        
        <div class="register-form">
            <h2>Đăng Ký Để Nhận Tư Vấn</h2>
            {{-- <form id="registerFormLandingPage"> --}}
                <div class="form-group form_landing_name_wrapper">
                    <label for="name">Họ và Tên <span style="color:red">*</span> </label>
                    <input type="text" id="form_landing_name" name="name" placeholder="Nhập họ và tên" maxlength="50" required>
                    <p class="error-input"></p>
                </div>
                <div class="form-group form_landing_email_wrapper">
                    <label for="email">Email <span style="color:red">*</span></label>
                    <input type="email" id="form_landing_email" name="email" placeholder="Nhập email" maxlength="50" required>
                    <p class="error-input"></p>
                </div>
                <div class="form-group form_landing_phone_wrapper">
                    <label for="phone">Số Điện Thoại <span style="color:red">*</span></label>
                    <input type="text" id="form_landing_phone" name="phone" placeholder="Nhập số điện thoại" maxlength="10" required inputmode="numeric" pattern="[0-9]*">
                    <p class="error-input"></p>
                </div>
                <button id="submit_form_landing" type="button" class="submit-btn">Đăng Ký</button>
            {{-- </form> --}}
            <p class="success_register"></p>
        </div>
    </body>
    </html>

    <script>
        $(document).ready(()=>{
            const baseUrl = window.location.origin;
            const routeApi = '/api/leads/dang-ky/';

            $(document).on('click', '#submit_form_landing', function(e){
                e.preventDefault();
                let full_name   = $('#form_landing_name').val();
                let email       = $('#form_landing_email').val();
                let phone       = $('#form_landing_phone').val();
                let urlParams   = new URLSearchParams(window.location.search);
                let id          = urlParams.get('id');
                const api       = baseUrl+routeApi+id;

                $.ajax({
                    url: api,
                    method: 'POST',
                    data: {
                        full_name   : full_name,
                        email       : email,
                        phone       : phone,
                    },
                    success: (res)=>{
                        if(res.code == 422){
                            handleError('#form_landing_name', '.form_landing_name_wrapper', res.data.full_name);
                            handleError('#form_landing_email', '.form_landing_email_wrapper', res.data.email);
                            handleError('#form_landing_phone', '.form_landing_phone_wrapper', res.data.phone);
                        } else {
                            $('#form_landing_name').val('');
                            $('#form_landing_email').val('');
                            $('#form_landing_phone').val('');
                            $('.success_register').html(res.message).show();
                            setTimeout(() => {
                                $('.success_register').hide();
                            }, 3000);
                        }
                    },
                    error: (error)=>{
                        console.log(error);
                    }
                })
                return false;
            })

            handleRemoveError('.form_landing_name_wrapper', '#form_landing_name');
            handleRemoveError('.form_landing_email_wrapper', '#form_landing_email');
            handleRemoveError('.form_landing_phone_wrapper', '#form_landing_phone');

            function handleError(field, wrapper, errors) {
                if (errors != null) {
                    $(field).addClass('border-error');
                    $(wrapper + ' .error-input').html(errors.join(', '));
                    $(wrapper + ' .error-input').addClass('show-error');
                }
            }

            // handle remove error effect when click input \\
            function handleRemoveError(wrapper, id_input){
                $(wrapper).on('click', function() {
                    $(this).find('.error-input').removeClass('show-error').html('');
                    $(this).find(id_input).removeClass('border-error');
                });
            }

            $(document).on('input', '#form_landing_phone', function () {
                $(this).val($(this).val().replace(/\D/g, ''));
            });
        })
    </script>
    @include('includes.script')   
</body>
</html>



