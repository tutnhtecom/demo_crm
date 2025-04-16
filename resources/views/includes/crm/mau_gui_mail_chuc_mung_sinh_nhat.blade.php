<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>                      
    <p><strong>Kính gửi:</strong> {{ $name }}</p>
    <p>Nhân dịp sinh nhật của bạn, {{ env('APP_NAME') }} gửi đến bạn những lời chúc tốt đẹp nhất:</p>
    <p>🌟 Chúc bạn luôn tràn đầy năng lượng và hạnh phúc.</p>
    <p>🌟 Những ước mơ và mục tiêu của bạn sẽ sớm trở thành hiện thực.</p>        
    <p>🌟 Sức khỏe dồi dào và thành công viên mãn trên mọi chặng đường.</p>        
    <p><strong>Thân mến!</strong></p>
    <p><span>{{ env('APP_NAME') }}</span></p>    
</body>
</html>