<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký hồ sơ</title>
    @include('includes.stylesheet')
    <script src="/assets/js/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Hệ thống tuyển sinh Đại học - </title>
    </head>
    <body>        
        <section class="container-fluid">
            <div class="screen-loading">
                <div class="screen-loading-container"><div class="loader"></div></div>
            </div>
            @yield('content')
        </section>
    </body>
    </html>

    @include('includes.script')   
</body>
</html>