import { baseUrl, dvlkRenderStudentListApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(function () {
    const idDVLK = $('.table_dssv').attr('data-id');
    const token = localStorage.getItem('jwt_token');

    $.ajax({
        url: baseUrl+dvlkRenderStudentListApi+idDVLK, // API chứa dữ liệu JSON
        type: "GET",
        headers: {
            'Authorization': `Bearer ${token}`
        },
        success: function (response) {
            let data = response;
            let years = new Set();
            let semesters = ["Học kỳ 1", "Học kỳ 2", "Học kỳ 3"];

            // 1. Tìm tất cả các năm học có trong dữ liệu
            if (data.data) {
                $.each(data.data, function (studentId, studentRecords) {
                    $.each(studentRecords, function (year, details) {
                        years.add(year);
                    });
                });
            }

            years = Array.from(years).sort(); // Sắp xếp theo thứ tự năm học

            // 2. Tạo `<thead>` động
            let thead = `<tr class="text-white text-nowrap fs-5 text-center">
                <th rowspan="2" class="text-center">STT</th>
                <th rowspan="2">Họ và tên</th>
                <th rowspan="2">MSV</th>
                <th rowspan="2">Khóa tuyển sinh</th>
                <th rowspan="2">Ngành học</th>`;

            years.forEach(year => {
                thead += `<th colspan="3" class="hidden-dt-column-order" style="text-align:center!important;">${year}</th>`;
            });

            thead += `</tr><tr>`;

            years.forEach(() => {
                semesters.forEach(sem => {
                    thead += `<th class="text-white text-nowrap fs-5 text-center hidden-dt-column-order">${sem}</th>`;
                });
            });

            thead += `</tr>`;
            $("#dynamic-thead").html(thead); // Cập nhật thead

            // 3. Xây dựng dữ liệu cho tbody
            let tableData = [];
            let stt = 1;

            // Kiểm tra nếu transactions tồn tại
            if (data.data) {
                $.each(data.data, function (studentId, studentRecords) {
                    // Lấy thông tin sinh viên từ bất kỳ năm nào
                    let firstYear = Object.keys(studentRecords)[0]; // Lấy năm đầu tiên trong danh sách
                    let studentInfo = studentRecords[firstYear] || {}; // Lấy thông tin sinh viên từ năm đầu tiên

                    let row = [
                        stt++, // STT
                        studentInfo.students_name || "N/A",
                        studentInfo.students_code || "N/A",
                        studentInfo.students_academy || "N/A",
                        studentInfo.students_majors || "N/A"
                    ];

                    // Duyệt qua các năm trong danh sách years
                    years.forEach(year => {
                        if (studentRecords[year]) {
                            semesters.forEach(sem => {
                                let data = studentRecords[year][sem] || `<div class="text-end">0</div>`; // Nếu không có giá trị, gán "0"
                                row.push(`<div class="text-end">${data}</div>`); // Đẩy HTML vào mảng row
                                // row.push(studentRecords[year][sem] || "0");
                            });
                        } else {
                            semesters.forEach(() => row.push(`<div class="text-end">0</div>`)); // Nếu năm đó không có, thêm "0"
                        }
                    });

                    tableData.push(row);
                    
                });
            }

            // 4. Render DataTables với dữ liệu động
            $('#datatable').DataTable({
                autoWidth: false,
                stateSave: true,   
                destroy: true, // Hủy bảng cũ nếu có
                data: tableData,
                columns: [
                    { title: "STT" },
                    { title: "Họ và tên" },
                    { title: "Mã số sinh viên" },
                    { title: "Khóa tuyển sinh" },
                    { title: "Ngành học" },
                    ...years.flatMap(year => [
                        { title: `Học kỳ 1`},
                        { title: `Học kỳ 2`},
                        { title: `Học kỳ 3`}
                    ])
                ],
                columnDefs: [
                    { targets: 0, width: "60px" },  // Cột STT
                    { targets: 1, width: "150px" }, // Cột tên sinh viên
                    { targets: 2, width: "120px" }, // Cột Mã số sinh viên
                    { targets: 3, width: "180px" }, // Cột học viện
                    { targets: 4, width: "200px" }, // Cột chuyên ngành
                    { targets: "_all", width: "100px" } // Các cột còn lại có độ rộng mặc định
                ]
            });
        }
    });
});
