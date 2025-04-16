<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không tồn tại</title>
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
    <h1>500</h1>
    @php
        if (!isset($msg)){
            $msg = "Có lỗi bất ngờ xảy ra. Vui lòng liên hệ bộ phận kỹ thuật để được hỗ trợ.";
        }
    @endphp
    <p>{{$msg}}</p>
</body>
</html>
