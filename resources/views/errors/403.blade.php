<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lỗi truy cập</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            color: #333;
            padding: 50px;
        }
        h1 {
            font-size: 50px;
            color: #d9534f;
        }
        p {
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>403</h1>
    <p>{{$msg ?? null}}</p>
    <a href="{{ route('crm.login') }}">Quay lại đăng nhập</a>
</body>
</html>
