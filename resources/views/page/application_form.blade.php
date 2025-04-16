<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{$title ?? 'Phiếu đăng ký dự tuyển đại học'}} </title>
	<!-- include file css -->
	{{-- @include('includes.stylesheet') --}}
    <link href="/assets/css/style.css" rel="stylesheet" crossorigin="anonymous">
    {{-- <link href="{{ asset('/assets/crm/css/htecomCss/crm.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">	    
    <link href="/assets/css/crm-style.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/png" href="/assets/image/logo-favicon.ico"/>

    <style>
        {!! file_get_contents(public_path('/assets/crm/css/htecomCss/crm.css')) !!}
        {!! file_get_contents(public_path('/assets/css/bootstrap.min.css')) !!}
    </style>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/DejaVuSans.ttf') }}") format('truetype');
        }
        body {
            font-family: "DejaVu Sans";
        }

        @media print {
            .pdf-container {
                display: block !important;
                width: 100%;
            }
        }
    </style>
</head>

<body class="">
    <section class="pdf-container" style="">
       
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="width: 50%; text-align: left; vertical-align: top;">
                    <div class="fw-bold text-center" style="width:max-content;font-size:12px;">
                        <span>BỘ GIÁO DỤC VÀ ĐÀO TẠO</span><br>
                        <span>TRƯỜNG ĐẠI HỌC MỞ</span><br>
                        <span>THÀNH PHỐ HỒ CHÍ MINH</span>
                        <hr style="margin:3px 94px;border-top:1px solid #000;opacity:1;">
                        <div>
                            <img src="./assets/crm/media/logos/logo-form.png" alt="" style="width: 60px;border:0">
                        </div>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="fw-bold text-center" style="width:max-content;font-size:14px;">
                        <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                        <span>Độc lập - Tự do - Hạnh phúc</span>
                        <hr style="margin:3px 70px;border-top:1px solid #000;opacity:1;">
                    </div>
                    <div class="fw-bold text-center" style="width:max-content;padding-left:74px;">
                        <table style="text-align:center;">
                            <tr >
                                <td style="font-weight: bold; padding-right: 10px;">
                                    MÃ HỒ SƠ:
                                    <span> {{$data->code ?? '0000000000'}} </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>        
        <table style="width: 100%; border-collapse: collapse;margin-bottom: 30px;">
            <tr>
                <td style="width: 20%; text-align: center; border: 1px solid transparent;">
                    <div style="width:120px; height:160px; border:1px solid #000; display: inline-block;">
                        @if($data->url_avatar !== null)
                            <img src="{{$data->url_avatar}}" alt="" style="width:120px; height:160px;">
                        @else
                            <span>Ảnh 3x4</span>
                        @endif
                    </div>
                </td>
                <td style="width: 75%; border: 1px solid transparent;">
                    <div style="text-align: center;">
                        <span style="font-weight: bold; font-size: 24px;">
                            PHIẾU ĐĂNG KÝ DỰ TUYỂN ĐẠI HỌC
                        </span>
                        <br>
                        <span style="font-weight: bold; font-size: 18px;"> HÌNH THỨC ĐÀO TẠO TỪ XA </span>
                    </div>
                    <table style="width: 100%; margin-top: 10px;">
                        <tr>
                            <td style="font-weight: bold;width: 120px;">PHƯƠNG THỨC:</td>
                            <td style="font-weight: bold;width: 130px;">
                                Truyền thống 
                                <div style="width: 20px; height:20px; border: 1px solid #000;display:inline-block;">
                                    <p style="text-align:center;margin-bottom:0;width:max-content;line-height:18px;"></p>
                                </div>
                            </td>
                            <td style="font-weight: bold;width: 130px;">
                                Qua mạng
                                <div style="width: 20px; height:20px; border: 1px solid #000;display:inline-block;">
                                    <p style="text-align:center;margin-bottom:0;width:max-content;line-height:18px;">X</p>
                                </div>
                            </td>
                        </tr>
                    </table>                    
                    <table style="width: 100%; margin-top: 10px;">
                        <tr>
                            <td style="font-weight: bold;width: 120px;">
                                Ngành đăng ký: 
                                <span style="font-weight:normal;">
                                    {{$data->marjors->name ?? '...................................................'}}
                                </span> 
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width: 120px;">
                                Chuyên ngành: 
                                <span style="font-weight:normal;">
                                    {{$data->marjors->name ?? '...................................................'}}
                                </span> 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="row justify-content-center">
            <div class="col-10">
                <div>
                    <span class="fw-bold" style="font-size: 20px;">I. PHẦN BẢN THÂN</span>
                </div>                
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;width:20%">1. Họ và tên (Chữ in hoa): </td>
                        <td style=" width:70%">
                            <div style="display:inline-block">
                                <span>
                                    {{$data->full_name}}
                                </span>
                                /
                                <span>
                                    Nam
                                    <div style="width: 15px; height:15px; border: 1px solid #000;display:inline-block">
                                        <p style="text-align:center;margin-bottom:0;width:max-content;line-height:12px;">
                                            {{$data->gender == 1 ? 'x' : ''}}
                                        </p>
                                    </div>
                                </span>
                                <span>
                                    Nữ
                                    <div style="width: 15px; height:15px; border: 1px solid #000;display:inline-block">
                                        <p style="text-align:center;margin-bottom:0;width:max-content;line-height:12px;">
                                            {{$data->gender == 0 ? 'x' : ''}}
                                        </p>
                                    </div>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;">
                            2. Ngày sinh: 
                            <span style="font-weight:normal;">
                                {{ \Carbon\Carbon::parse($data->date_of_birth)->format('d/m/Y') }}
                            </span> /
                            Nơi sinh: 
                            <span style="font-weight:normal;"> {{$data->place_of_birth}} </span>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;">
                            3. Dân tộc: 
                            <span style="font-weight:normal;"> {{$data->ethnics_name}} </span> / 
                            Quốc tịch:
                            <span style="font-weight:normal;"> {{$data->nations_name}} </span>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;">
                            4. Địa chỉ liên hệ: <span style="font-style:italic;font-weight: normal;">ghi rõ số nhà, đường, phường (xã), quận (huyện), tỉnh (thành phố)</span> 
                        </td>
                    </tr>
                    <tr>
                        <td style="">
                            @foreach ($data->contacts as $dcll)
                                @if($dcll->type == 0)
                                    - {{$dcll->address}}, {{$dcll->wards_name}}, {{$dcll->districts_name}}, {{$dcll->provinces_name}}
                                    @break
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;">
                            5. Địa chỉ thường trú: <span style="font-style:italic;font-weight: normal;">ghi rõ số nhà, đường, phường (xã), quận (huyện), tỉnh (thành phố)</span> 
                        </td>
                    </tr>
                    <tr>
                        <td style="">
                            @foreach ($data->contacts as $hktt)
                                @if($hktt->type == 1)
                                    - {{$hktt->address}}, {{$hktt->wards_name}}, {{$hktt->districts_name}}, {{$hktt->provinces_name}}
                                    @break
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </table>
                
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;">
                            6. Số điện thoại: 
                            <span style="font-weight:normal;"> {{$data->phone}} </span> /
                            Email:
                            <span style="font-weight:normal;"> {{$data->email}} </span>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold; width: 1%;">
                            7. Số CCCD: 
                            <span style="font-weight:normal;">
                                {{$data->identification_card}}
                            </span>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">7.</span>
                            Ngày cấp: <span style="font-weight:normal;"> {{$data->date_identification_card ?? '........../........../..........'}} </span>,
                            Nơi cấp:  <span style="font-weight:normal;"> {{$data->place_identification_card ?? '................................................'}} </span>
                        </td>
                    </tr>
                </table>                
                @foreach ($data->degree as $tdvh)
                @if($tdvh->type_id == 1 || $tdvh->type_id == 2 || $tdvh->type_id == 3 || $tdvh->type_id == 4)
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;">
                                    8. Trình độ văn hóa: <span style="font-style:italic;font-weight: normal;">Đã có bằng tốt nghiệp (THPT, BTTH):</span>
                                    <span style="font-weight:normal;">
                                        {{$tdvh->types->name ?? '..................................................'}}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">8.</span> 
                                    Số hiệu bằng: 
                                    <span style="font-weight:normal;">
                                        {{$tdvh->serial_number_degree ?? '......................................................'}}
                                    </span>,
                                    Năm tốt nghiệp:
                                    <span style="font-weight:normal;">
                                        {{$tdvh->year_of_degree ?? '.............................'}}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">8.</span> 
                                    Ngày cấp: 
                                    <span style="font-weight:normal;">
                                        {{ \Carbon\Carbon::parse($tdvh->date_of_degree)->format('d/m/Y') ?? '........./........./.........'}}
                                    </span>, 
                                    Nơi cấp: 
                                    <span style="font-weight:normal;">
                                        {{$tdvh->place_of_degree ?? '................................................'}}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    @break
                    @endif
                @endforeach

                @foreach ($data->degree as $tdcm)
                    @if($tdcm->type_id == 3 || $tdcm->type_id == 4)
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;">
                                    9. Trình độ chuyên môn: 
                                    <span style="font-weight:normal;">Đã tốt nghiệp: </span> 
                                    
                                    <span style="font-weight:normal;">Cao đẳng 
                                        <div style="width: 15px; height:15px; border: 1px solid #000;display:inline-block">
                                            <p style="text-align:center;margin-bottom:0;width:max-content;line-height:12px;">
                                                {{$tdcm->type_id == 3 ? 'x' : ''}}
                                            </p>
                                        </div>
                                    </span>
                                    <span style="font-weight:normal;">Đại học 
                                        <div style="width: 15px; height:15px; border: 1px solid #000;display:inline-block">
                                            <p style="text-align:center;margin-bottom:0;width:max-content;line-height:12px;">
                                                {{$tdcm->type_id == 4 ? 'x' : ''}}
                                            </p>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">9.</span> 
                                    Số hiệu bằng: 
                                    <span style="font-weight:normal;">
                                        {{$tdcm->serial_number_degree ?? '......................................................'}}
                                    </span>,
                                    Năm tốt nghiệp:
                                    <span style="font-weight:normal;">
                                        {{$tdcm->year_of_degree ?? '.............................'}}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">8.</span> 
                                    Ngày cấp: 
                                    <span style="font-weight:normal;">
                                        {{ \Carbon\Carbon::parse($tdcm->date_of_degree)->format('d/m/Y') ?? '........./........./.........'}}
                                    </span>, 
                                    Nơi cấp: 
                                    <span style="font-weight:normal;">
                                        {{$tdcm->place_of_degree ?? '................................................'}}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    @break
                    @endif
                @endforeach

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;"> 
                            <div style="display:inline-block">
                                10. Đã đi làm 
                                <div style="width: 15px; height:15px; border: 1px solid #000;display:inline-block">
                                    <p style="text-align:center;margin-bottom:0;width:max-content;line-height:12px;"></p>
                                </div>
                            </div>
                            <div style="display:inline-block;margin-left:30px">
                                Chưa đi làm 
                                <div style="width: 15px; height:15px; border: 1px solid #000;display:inline-block">
                                    <p style="text-align:center;margin-bottom:0;width:max-content;line-height:12px;"></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold; width: 1%;">
                            11. Tên cơ quan: <span style="font-weight:normal;">
                                {{$data->company_name ? $data->company_name : '........................................................................................................'}}
                            </span>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold; width: 1%;">
                            12. Địa chỉ cơ quan: <span style="font-weight:normal;">
                                {{$data->company_address ? $data->company_address : '...................................................................................................'}}
                            </span>
                        </td>
                    </tr>
                </table>
    
                <div>
                    <span class="fw-bold" style="font-size: 20px;">II. PHẦN GIA ĐÌNH</span>
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;">
                            1. Cha
                        </td>
                    </tr>
                </table>
                @foreach ($data->family as $father)
                    @if($father->type == 0)
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Họ và tên:
                                    <span style="font-weight:normal;">
                                        {{$father->full_name}}
                                    </span>
                                    / 
                                    <span>
                                        Năm sinh: <span style="font-weight:normal;">
                                            {{$father->year_of_birth}}
                                        </span>
                                    </span> 
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Địa chỉ thường trú: 
                                    <span style="font-weight:normal;"> 
                                        @foreach ($data->contacts as $hktt)
                                            @if($hktt->type == 1)
                                                {{$hktt->address}}, {{$hktt->provinces_name}}
                                                @break
                                            @endif
                                        @endforeach
                                    </span> 
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span>
                                    Trình độ học vấn: <span style="font-weight:normal;"> {{$father->edutpyes->name ?? '........................................................'}} </span> </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Nghề nghiệp: <span style="font-weight:normal;"> {{$father->jobs ?? '........................................................'}} </span> </td>
                            </tr>
                        </table>
                    @break
                    @endif
                @endforeach

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; font-weight: bold;">
                            2. Mẹ
                        </td>
                    </tr>
                </table>
                @foreach ($data->family as $mother)
                    @if($mother->type == 1)
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Họ và tên:
                                    <span style="font-weight:normal;">
                                        {{$mother->full_name}}
                                    </span>
                                    / 
                                    <span>
                                        Năm sinh: <span style="font-weight:normal;">
                                            {{$mother->year_of_birth}}
                                        </span>
                                    </span> 
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Địa chỉ thường trú: 
                                    <span style="font-weight:normal;"> 
                                        @foreach ($data->contacts as $hktt)
                                            @if($hktt->type == 1)
                                                {{$hktt->address}}, {{$hktt->provinces_name}}
                                                @break
                                            @endif
                                        @endforeach
                                    </span> 
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span>
                                    Trình độ học vấn: <span style="font-weight:normal;"> {{$mother->edutpyes->name ?? '........................................................'}} </span> </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Nghề nghiệp: <span style="font-weight:normal;"> {{$mother->jobs ?? '........................................................'}} </span> </td>
                            </tr>
                        </table>
                    @break
                    @endif
                @endforeach

                @foreach ($data->family as $wife)
                    @if($wife->type == 2)
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;">
                                    3. Vợ hoặc chồng
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Họ và tên:
                                    <span style="font-weight:normal;">
                                        {{$wife->full_name}}
                                    </span>
                                    / 
                                    <span>
                                        Năm sinh: <span style="font-weight:normal;">
                                            {{$wife->year_of_birth}}
                                        </span>
                                    </span> 
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Địa chỉ thường trú: 
                                    <span style="font-weight:normal;"> 
                                        @foreach ($data->contacts as $hktt)
                                            @if($hktt->type == 1)
                                                {{$hktt->address}}, {{$hktt->provinces_name}}
                                                @break
                                            @endif
                                        @endforeach
                                    </span> 
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span> 
                                    Nghề nghiệp: <span style="font-weight:normal;"> {{$wife->jobs ?? '........................................................'}} </span> </td>
                            </tr>
                        </table>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold;"> <span style="visibility:hidden;">1.</span>
                                    Số điện thoại: <span style="font-weight:normal;"> {{$wife->phone_number ?? '........................................................'}} </span> </td>
                            </tr>
                        </table>
                    @break
                    @endif
                @endforeach


                <div>
                    <span class="fw-bold" style="font-size: 20px;">III. PHẦN CAM ĐOAN</span>
                </div>
                <div class="gap-1 mb-2 ps-2">
                    <p style="text-align:justify">
                        Tôi tên: {{$data->full_name}} , cam đoan những lời khai trong phiếu này là đúng sự thật và tất cả những giấy tờ của tôi đã nộp trong hồ sơ là hợp pháp. Nếu một trong các giấy tờ đã nộp trong hồ sơ không hợp pháp, tôi xin chịu mọi hình thức xử lý của Nhà trường theo quy định của Bộ Giáo dục và Đào tạo.
                    </p>
                </div>
                <div class="gap-1 mb-2 ps-2">
                    <div class="text-end">
                        <p class="mb-1">
                            <span style="border-bottom: 1px dotted #000;display:inline-block;min-width: 50px;"></span>,
                            ngày <span style="border-bottom: 1px dotted #000;display:inline-block;min-width: 30px;"></span>, 
                            tháng <span style="border-bottom: 1px dotted #000;display:inline-block;min-width: 30px;"></span>, 
                            năm 20<span style="border-bottom: 1px dotted #000;display:inline-block;min-width: 20px;"></span>
                        </p>
                        <p class="mb-0 fw-bold" style="padding-right: 100px">Người đăng ký</p>
                        <p class="mb-1" style="padding-right: 80px">(Ký và ghi rõ họ tên)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- include file js -->
	{{-- @include('includes.script') --}}
</body>

</html>