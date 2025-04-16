<?php 
    return [
        "leads" => [
            "display_fields"      => [
                ['field_name' => 'id',  'display_name'                  =>'ID'],
                ['field_name' => 'full_name','display_name'             =>'Họ và tên'],                
                ['field_name' => 'leads_code','display_name'            =>'Mã số sinh viên'],
                ['field_name' => 'phone','display_name'                 =>'Số điện thoại'],
                ['field_name' => 'email','display_name'                 =>'Email'],
                ['field_name' => 'gender','display_name'                =>'Giới tính'],
                ['field_name' => 'date_of_birth','display_name'         =>'Ngày sinh'],
                ['field_name' => 'identification_card','display_name'   =>'CMND/CCCD'],
                ['field_name' => 'lst_status_id','display_name'         =>'Tình trạng tư vấn'],
                ['field_name' => 'sources_id','display_name'            =>'Nguồn'],
                ['field_name' => 'tags_id','display_name'               =>'Gắn thẻ'],
                ['field_name' => 'created_time','display_name'          =>'Ngày tạo'],
                ['field_name' => 'marjors_name','display_name'          =>'Ngành học quan tâm'],
                ['field_name' => 'assignments_id','display_name'        =>'Tư vấn viên phụ trách'],
                ['field_name' => 'contacts_dcll','display_name'         =>'Địa chỉ liên lạc'],                
                ['field_name' => 'contacts_hktt','display_name'         =>'Hộ khẩu thường trú'],   
                ['field_name' => 'father_name','display_name'           =>'Họ và tên Cha'],
                ['field_name' => 'father_phone','display_name'          =>'Số điện thoại Cha'],
                ['field_name' => 'mother_name','display_name'           =>'Họ và tên Mẹ'],
                ['field_name' => 'mother_phone','display_name'          =>'Số điện thoại Mẹ'],
                ['field_name' => 'method_name','display_name'           =>'Phương thức xét tuyển'],     
                ['field_name' => 'academy_list_name','display_name'     =>'Khóa tuyển sinh'],     
                ['field_name' => 'total_price_lists','display_name'     =>'Tổng học phí phải đóng'],
                ['field_name' => 'total_transactions','display_name'    =>'Tổng học phí đã đóng']
            ]
        ],
        "students" => [
            "display_fields"      => [
                ['field_name' => 'id',  'display_name'                  =>'ID'],
                ['field_name' => 'full_name','display_name'             =>'Họ và tên'],                
                ['field_name' => 'students_code','display_name'         =>'Mã số sinh viên'],
                ['field_name' => 'phone','display_name'                 =>'Số điện thoại'],
                ['field_name' => 'email','display_name'                 =>'Email'],
                ['field_name' => 'gender','display_name'                =>'Giới tính'],
                ['field_name' => 'date_of_birth','display_name'         =>'Ngày sinh'],
                ['field_name' => 'identification_card','display_name'   =>'CMND/CCCD'],
                ['field_name' => 'lst_status_id','display_name'         =>'Tình trạng tư vấn'],
                ['field_name' => 'sources_id','display_name'            =>'Nguồn'],
                ['field_name' => 'tags_id','display_name'               =>'Gắn thẻ'],
                ['field_name' => 'created_time','display_name'          =>'Ngày tạo'],
                ['field_name' => 'marjors_name','display_name'          =>'Ngành học quan tâm'],
                ['field_name' => 'assignments_id','display_name'        =>'Tư vấn viên phụ trách'],
                ['field_name' => 'contacts_dcll','display_name'         =>'Địa chỉ liên lạc'],                
                ['field_name' => 'contacts_hktt','display_name'         =>'Hộ khẩu thường trú'],   
                ['field_name' => 'father_name','display_name'           =>'Họ và tên Cha'],
                ['field_name' => 'father_phone','display_name'          =>'Số điện thoại Cha'],
                ['field_name' => 'mother_name','display_name'           =>'Họ và tên Mẹ'],
                ['field_name' => 'mother_phone','display_name'          =>'Số điện thoại Mẹ'],
                ['field_name' => 'method_name','display_name'           =>'Phương thức xét tuyển'],     
                ['field_name' => 'academy_list_name','display_name'     =>'Khóa tuyển sinh'],     
                ['field_name' => 'total_price_lists','display_name'     =>'Tổng học phí phải đóng'],
                ['field_name' => 'total_transactions','display_name'    =>'Tổng học phí đã đóng']
            ]
        ],
        "affiliate" => [
            "semesters"         => ["Học kỳ 1", "Học kỳ 2", "Học kỳ 3"],
            "headings"          => ["Họ tên", "Khóa tuyển sinh", "Ngành học", "MSSV"],
            "title_price_lists" => "Học phí"
        ],
        "email_template" => [
            "title" => [
                'note'  => 'Chú thích',
                'key'   => 'Từ khóa'
            ],
            "table_1" => [
                [ 'note'  => 'Họ và tên',        'key'   => '{{$full_name}}'],
                [ 'note'  => 'Mã số sinh viên',  'key'   => '{{$leads_code}}'],
                [ 'note'  => 'Ngày sinh',        'key'   => '{{$date_of_birth}}'],        
                [ 'note'  => 'Căn cước công dân','key'   => '{{$identification_card}}'],
                [ 'note'  => 'Số điện thoại',    'key'   => '{{$phone}}'],
                [ 'note'  => 'Số điện thoại nhà riêng ','key'   => '{{$home_phone}}'],
            ],
            "table_2" => [
                [ 'note'  => 'Học phí',         'key'   => '{{$price}}'],
                [ 'note'  => 'Từ ngày',         'key'   => '{{$from_date}}'],                
                [ 'note'  => 'Nơi sinh ',       'key'   => '{{$place_of_birth}}'],
                [ 'note'  => 'Quốc tịch',       'key'   => '{{$nations_name}}'],
                [ 'note'  => 'Dân tộc',         'key'   => '{{$ethnics_name}}'],
                [ 'note'  => 'Đến ngày',        'key'   => '{{$to_date}}'],
            ],
            "table_3" => [
                [ 'note'  => 'Email',               'key'   => '{{$email}}'],
                [ 'note'  => 'Mật khẩu',            'key'   => '{{$password}}'],  
                [ 'note'  => 'Ngành học',           'key'   => '{{$marjors_name}}'],
                [ 'note'  => 'Giới tính',           'key'   => '{{$gender}}'],
            ]
        ]

    ]
?>