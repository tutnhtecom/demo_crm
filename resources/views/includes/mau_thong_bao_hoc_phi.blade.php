<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>            
    <h4><strong>{{$title}}</strong></h4>
    <table class="table border-0">   
        <!-- Họ và tên -->
        @if(isset($full_name))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Họ và tên: </strong></span></td>
                <td class="text-left"><span>{{$full_name}}</span></td>
            </tr>
        @endif     
        <!-- Mã số sinh viên -->
        @if(isset($leads_code))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Mã số sinh viên: </strong></span></td>
                <td class="text-left"><span>{{$leads_code}}</span></td>
            </tr>
        @endif    
        <!-- Email -->
         @if(isset($email))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Email: </strong></span></td>
                <td class="text-left"><span>{{$email}}</span></td>
            </tr>
        @endif
        <!-- Số tiền phải đóng -->
        @if(isset($price))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Học phí: </strong></span></td>
                <td class="text-left"><span>{{number_format($price)}}</span></td>
            </tr>
        @endif 
        <!-- Hạn nộp: From date -->
        @if(isset($from_date))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Từ ngày: </strong></span></td>
                <td class="text-left"><span>{{date('d/m/Y', strtotime($from_date))}}</span></td>
            </tr>
        @endif    
        <!-- Số tiền phải đóng -->
        @if(isset($to_date))
            <tr>
                <td style="width:130px;text-align:left !important;"><span><strong>Đến ngày: </strong></span></td>
                <td class="text-left"><span>{{date('d/m/Y', strtotime($to_date))}}</span></td>
            </tr>
        @endif 
    </table>
    <h4>Trân trọng!</h4>    
</body>
</html>