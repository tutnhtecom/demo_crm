import {
    baseUrl,
    dvlkCommissionApi,
} from "/assets/crm/js/htecomJs/variableApi.js";

$(document).ready(() => {
    const idDVLK = $(".table_tthh").attr("data-id");
    const token = localStorage.getItem("jwt_token");
    const ten_dvlk = $('#datatable_commission').attr('data-name-dvlk');

    // $.ajax({
    //     url: baseUrl + dvlkCommissionApi + idDVLK,
    //     type: "GET",
    //     headers: {
    //         Authorization: `Bearer ${token}`,
    //     },
    //     success: function (res) {
    //         let data = res;
    //         let options = [
    //             "Số lượng SV nhập học",
    //             "Học phí",
    //             "Định mức thanh toán",
    //             "Thời gian thực hiện thanh toán",
    //             "ĐV",
    //             "CN",
    //         ];

    //         // 1. Tìm tất cả các năm học có trong dữ liệu
    //         let years = Object.keys(data).sort();
    //         let semesters = [];

    //         Object.values(data).forEach((item) => {
    //             semesters.push(item.semesters_name);
    //         });

    //         // 2. Tạo `<thead>` động
    //         let thead = `
    //             <tr class="text-white text-nowrap fs-5 text-left">
    //                 <th colspan="100">ĐVLK: TT GDTX tỉnh BR-VT</th>
    //             </tr>
    //             <tr class="text-white text-nowrap fs-5 text-center">
    //                 <th rowspan="3">STT</th>
    //                 <th rowspan="3"> <div>Khóa tuyển sinh</div> </th>
    //         `;

    //         years.forEach((year) => {
    //             thead += `<th colspan="6" class="hidden-dt-column-order" style="text-align:center!important;">${year}</th>`;
    //         });

    //         thead += `</tr>`;

    //         thead += `<tr class="text-white text-nowrap fs-5 text-center">`;
    //         semesters.forEach((semester) => {
    //             thead += `<th colspan="6">${semester}</th>`;
    //         });
    //         thead += `</tr>`;

    //         thead += `<tr class="text-white text-nowrap fs-5 text-center">`;
    //         semesters.forEach(() => {
    //             options.forEach((option) => {
    //                 thead += `<th>${option}</th>`;
    //             });
    //         });
    //         thead += `</tr>`;

    //         $("#thead_commission").html(thead);

    //         // 3. Xây dựng dữ liệu cho tbody
    //         let tableData = [];
    //         let stt = 1;

    //         if(data){
    //             Object.values(data).forEach((item) => {
    //                 tableData.push(item);
    //             });
    //         }
    //         console.log(tableData);

    //         var couunt = 1;
    //         $('#datatable_commission').DataTable({
    //             autoWidth: false,
    //             stateSave: true,
    //             destroy: true, // Hủy bảng cũ nếu có
    //             data: tableData,
    //             columns: [
    //                 {
    //                     data: couunt++,
    //                     className: '',
    //                     searchable: false,
    //                     render: function(tableData, type, row) {
    //                         console.log(tableData);
    //                         return `<span class="">`+data+`</span>`;
    //                     }
    //                 },
    //                 { title: "Khóa tuyển sinh" },
    //                 ...years.flatMap(year => [
    //                     { title: `Số lượng SV nhập học`},
    //                     { title: `Học phí`},
    //                     { title: `Định mức thanh toán`},
    //                     { title: `Thời gian thực hiện thanh toán`},
    //                     { title: `ĐV`},
    //                     { title: `CN`},
    //                 ])
    //             ],
    //         });
    //         console.log(tableData);
    //     },
    //     error: function (xhr, status, error) {
    //         console.error("Lỗi khi gọi API:", error);
    //     },
    // });

    $.ajax({
        url: baseUrl + dvlkCommissionApi + idDVLK,
        type: "GET",
        headers: {
            Authorization: `Bearer ${token}`,
        },
        success: function (res) {
            let data = res;

            // 1. Lấy danh sách năm và semester (chỉ lấy các semester có dữ liệu)
            let years = Object.keys(data).sort();
            let yearSemesterMap = {};
            let allSemesters = new Set();

            // Tạo map cho từng năm chỉ với các semester có dữ liệu
            years.forEach((year) => {
                let semestersWithData = data[year]
                    .filter(
                        (item) =>
                            item.total_quantity ||
                            item.total_price ||
                            item.payment_rate ||
                            item.payment_manager_price
                    )
                    .map((item) => item.semesters_name);
                yearSemesterMap[year] = [...new Set(semestersWithData)].sort();
                semestersWithData.forEach((semester) =>
                    allSemesters.add(semester)
                );
            });

            let allSemestersArray = [...allSemesters].sort();

            // 2. Tạo thead động
            let thead = `
                <tr class="text-white text-nowrap fs-5 text-left">
                    <th colspan="${
                        2 +
                        years.reduce(
                            (sum, year) =>
                                sum + yearSemesterMap[year].length * 6,
                            0
                        )
                    }">ĐVLK: ${ten_dvlk}</th>
                </tr>
                <tr class="text-white text-nowrap fs-5 text-center">
                    <th rowspan="3" style="width:5%;min-width:65px;" class="text-center">STT</th>
                    <th rowspan="3" style="width:10%;min-width:150px;" class="text-center"><div>Khóa tuyển sinh</div></th>
            `;

            years.forEach((year) => {
                let colspan = yearSemesterMap[year].length * 6;
                if (colspan > 0) {
                    thead += `<th colspan="${colspan}" style="text-align:center!important;">${year}</th>`;
                }
            });

            thead += `</tr>`;

            thead += `<tr class="text-white text-nowrap fs-5 text-center">`;
            years.forEach((year) => {
                yearSemesterMap[year].forEach((semester) => {
                    thead += `<th colspan="6" class="text-center" >${semester}</th>`;
                });
            });
            thead += `</tr>`;

            thead += `<tr id="xuong_dong" class="text-white text-nowrap fs-5 text-center">`;
            years.forEach((year) => {
                yearSemesterMap[year].forEach(() => {
                    [
                        "SL SV nhập học",
                        "Học phí",
                        "Định mức TT",
                        "Thời gian thực hiện TT",
                        "Đơn vị",
                        "Cá nhân",
                    ].forEach((option) => {
                        thead += `<th style="width:10%;" class="text-center margin-right-1">${option}</th>`;
                    });
                });
            });
            thead += `</tr>`;

            $("#thead_commission").html(thead);

            // 3. Chuẩn bị dữ liệu cho DataTable
            let formattedData = [];
            let courseGroups = {};

            // Nhóm dữ liệu theo tran_academy
            Object.keys(data)
                .sort()
                .forEach((year) => {
                    let yearData = data[year];
                    yearData.forEach((item) => {
                        if (!courseGroups[item.tran_academy]) {
                            courseGroups[item.tran_academy] = {};
                        }
                        if (!courseGroups[item.tran_academy][year]) {
                            courseGroups[item.tran_academy][year] = {};
                        }
                        if (
                            !courseGroups[item.tran_academy][year][
                                item.semesters_name
                            ]
                        ) {
                            courseGroups[item.tran_academy][year][
                                item.semesters_name
                            ] = [];
                        }
                        courseGroups[item.tran_academy][year][
                            item.semesters_name
                        ].push({
                            total_quantity              : item.total_quantity || 0,
                            total_price                 : item.total_price || 0,
                            payment_rate                : item.payment_rate || 0,
                            payment_manager_price       : item.payment_manager_price || 0,
                            payment_manager_rate        : item.payment_manager_rate || 0,
                            payment_condition           : item.payment_condition || "",
                            payment_note                : item.payment_note || "",
                            payment_for_manager         : item.payment_for_manager || 0,
                            payment_5_for_price_lists   : item.payment_5_for_price_lists || 0,
                            payment_for_sources         : item.payment_for_sources || 0,
                        });
                    });
                });

                

            // Chuyển dữ liệu thành mảng phẳng (hiển thị trên 1 dòng)
            let stt = 1;
            Object.keys(courseGroups).forEach((tran_academy) => {
                let courseData = courseGroups[tran_academy];
                let row = {
                    stt: stt,
                    tran_academy: tran_academy,
                };

                years.forEach((year) => {
                    yearSemesterMap[year].forEach((semester) => {
                        let semesterData =
                            courseData[year] && courseData[year][semester]
                                ? courseData[year][semester]
                                : [];

                        if (semesterData.length > 0) {
                            // Cộng dồn các giá trị số
                            let totalQuantity = semesterData.reduce(
                                (sum, item) =>
                                    sum + parseFloat(item.total_quantity || 0),
                                0
                            );
                            let totalPrice = semesterData.reduce(
                                (sum, item) =>
                                    sum + parseFloat(item.total_price || 0),
                                0
                            );
                            let paymentForManager = semesterData.reduce(
                                // (sum, item) => sum + parseFloat(item.payment_for_manager || 0), 0
                                (sum, item) => sum + parseFloat((item.payment_for_manager || "0").replace(/\./g, "")), 0
                            ).toLocaleString("vi-VN");
                            
                            let payment5ForPriceLists = semesterData.reduce(
                                // (sum, item) => sum + parseFloat(item.payment_5_for_price_lists || 0 ),0
                                (sum, item) => sum + parseFloat((item.payment_5_for_price_lists || "0").replace(/\./g, "")), 0
                            ).toLocaleString("vi-VN");
                            let paymentForSources = semesterData.reduce(
                                // (sum, item) => sum + parseFloat(item.payment_for_sources || 0), 0
                                (sum, item) => sum + parseFloat((item.payment_for_sources || "0").replace(/\./g, "")), 0
                            ).toLocaleString("vi-VN");

                            // Với các trường không phải số, lấy giá trị đầu tiên (hoặc có thể hiển thị dạng danh sách nếu cần)
                            let paymentCombo =
                                semesterData[0].payment_rate ||
                                semesterData[0].payment_manager_price ||
                                semesterData[0].payment_manager_rate ? 
                                    `
                                        <div>
                                            <span>${semesterData[0].payment_rate}% (${semesterData[0].payment_manager_price})</span><br>
                                            <hr style="margin:5px 0 !important;">
                                            <span>${semesterData[0].payment_manager_rate}%</span>
                                        </div>
                                    ` : "-";
                                        // ${semesterData[0].payment_rate}% (${semesterData[0].payment_manager_price}) ${semesterData[0].payment_manager_rate}%
                            let paymentNote = semesterData[0].payment_note || "-";

                            row[`${year}_${semester}_total_quantity`] = totalQuantity || "-";
                            row[`${year}_${semester}_total_price`] = totalPrice ? totalPrice.toLocaleString() : "-";
                            row[`${year}_${semester}_payment_combo`] = paymentCombo;
                            row[`${year}_${semester}_payment_note`] = paymentNote;
                            row[`${year}_${semester}_manager_combo`] = paymentForSources || "-";
                            // row[`${year}_${semester}_payment_for_sources`] = `${paymentForManager} ${payment5ForPriceLists}`;
                            row[`${year}_${semester}_payment_for_sources`] = `
                                <div>
                                    <span>${paymentForManager}</span><br>
                                    <hr style="margin:5px 0 !important;">
                                    <span>${payment5ForPriceLists}</span>
                                </div>
                            ` || "-";

                            // row[`${year}_${semester}_manager_combo`] = `${paymentForManager} / ${payment5ForPriceLists}`;
                            // row[`${year}_${semester}_payment_for_sources`] = paymentForSources || "";
                        } else {
                            row[`${year}_${semester}_total_quantity`] = "-";
                            row[`${year}_${semester}_total_price`] = "-";
                            row[`${year}_${semester}_payment_combo`] = "-";
                            row[`${year}_${semester}_payment_note`] = "-";
                            row[`${year}_${semester}_manager_combo`] = "-";
                            row[`${year}_${semester}_payment_for_sources`] = "-";
                        }
                    });
                });

                formattedData.push(row);
                stt++;
            });

            // 4. Khởi tạo DataTable
            $("#datatable_commission").DataTable({
                autoWidth: false,
                stateSave: true,   
                destroy: true,
                data: formattedData,
                columns: [
                    {
                        data: "stt",
                        searchable: false,
                        render: function (data) {
                            return `<span>${data}</span>`;
                        },
                        width: "5%"
                    },
                    {
                        data: "tran_academy",width: "15%"
                    },
                    ...years.flatMap((year) =>
                        yearSemesterMap[year].flatMap((semester) => [
                            {
                                data: `${year}_${semester}_total_quantity`,
                                title: "SL SV nhập học",
                                width: "10%" 
                            },
                            {
                                data: `${year}_${semester}_total_price`,
                                title: "Học phí",
                                width: "10%" 
                            },
                            {
                                data: `${year}_${semester}_payment_combo`,
                                title: "Định mức TT",
                                width: "10%" 
                            },
                            {
                                data: `${year}_${semester}_payment_note`,
                                title: "Thời gian thực hiện TT",
                                width: "10%" 
                            },
                            {
                                data: `${year}_${semester}_manager_combo`,
                                title: "Đơn vị",
                                width: "10%" 
                            },
                            {
                                data: `${year}_${semester}_payment_for_sources`,
                                title: "Cá nhân",
                                width: "10%" 
                            },
                        ])
                    ),
                ],
               
                pageLength: 10,
                order: [[0, "asc"]],
                language: {
                    decimal: ",",
                    thousands: ".",
                },
                
                createdRow: function (row, data, dataIndex) {
                    // Đảm bảo các ô trống được hiển thị
                    $(row)
                        .find("td")
                        .each(function () {
                            if ($(this).html() === "") {
                                $(this).html(" ");
                            }
                        });
                },

                columnDefs: [
                    { targets: 0, width: "5%" }, // STT
                    { targets: 1, width: "15%" }, // Học viện
                    { targets: "_all", width: "10%" }, // Các cột còn lại mặc định 10%
                ],
            });

        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        },
    });
});
