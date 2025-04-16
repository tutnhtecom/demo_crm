<!DOCTYPE html>
<html>
<head>
    <title>Quên mật khẩu</title>
</head>
<body>       
    <h3><strong>{{$title}}</strong></h3>
    <table class="table border-0">
        @if(isset($email))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Email: </strong></span></td>
                <td class="text-left"><span>{{$email}}</span></td>
            </tr>
        @endif
        <!-- Password -->
        @if(isset($password))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Mật khẩu: </strong></span></td>
                <td class="text-left"><span>{{$password}}</span></td>
            </tr>
        @endif       
        <tr>
            <td style="width:130px;text-align:left !important;"><span><strong>Đăng nhập hệ thống: </strong></span></td>
            <td class="text-left"><a href="{{route('Leads.login')}}">Tại đây</a></td>
        </tr>
    </table>
    <h3>Trân trọng!</h3>    
</body>
</html>