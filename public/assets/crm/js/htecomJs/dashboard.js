import { baseUrl,post_statistical_overview } from '/assets/crm/js/htecomJs/variableApi.js';
import { global_function } from '/assets/crm/js/htecomJs/global.js';
$(document).ready(()=>{
    // report_new_leads();
    report_new_leads('','');
    $('#report_total_by_status').on('apply.daterangepicker', function () {
        let dateRangeText = $('#report_total_by_status .text-gray-600').text();
        let fromDate, toDate;

        if (dateRangeText.includes(" - ")) {
            [fromDate, toDate] = dateRangeText.split(" - ");
        } else {
            fromDate = toDate = dateRangeText;
        }

        report_new_leads(fromDate, toDate);
    });
})

function report_new_leads(from_date, to_date){
    const token = localStorage.getItem('jwt_token');
    let date_range = $('.candidate_data_status_transition_chart div[data-ti-daterangepicker="true"] div').text();
    if (date_range != 'Lọc') {
        if (date_range.includes(" - ")) {
            [from_date, to_date] = date_range.split(" - ");
        } else {
            from_date = to_date = date_range;
        }
    } else {
        from_date = moment().startOf('month').format('DD/MM/YYYY');
        to_date = moment().endOf('month').format('DD/MM/YYYY');
    }
    
    let html_status_label_open = `<td class="w-180px"><div class="fs-10 fs-md-5 fw-bold">`;
    let html_status_label_close = `</div></td>`;
    let html_status_value_open = `<td class="h-unset h-md-300px"> <div class="fs-10 fs-md-7 fw-bold">`;
    let html_status_value_close = `</div></td>`;
    let html_dropoff_danger = `
        <td class="text-danger text-center position-relative">
            <div class="d-none d-md-block" style="margin-top: -36px">
                <svg width="52" height="52" viewBox="0 0 28 28" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                    <circle cx="14" cy="14" r="12.5" stroke="white"
                        stroke-width="1.5" />
                    <path
                        d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9"
                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>

            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
            <p class="m-0 fs-8 fs-md-2 fw-bolder">0%</p>
            <p class="m-0 fs-10 fs-md-5 fw-bold">(0)</p>
        </td>
    `;

    let html_dropoff_warning = `
        <td class="text-muted text-center position-relative">
            <div class="d-none d-md-block" style="margin-top: -36px">
                <svg width="52" height="52" viewBox="0 0 28 28" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                    <circle cx="14" cy="14" r="12.5" stroke="white"
                        stroke-width="1.5" />
                    <path
                        d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9"
                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>

            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
            <p class="m-0 fs-8 fs-md-2 fw-bolder">0%</p>
            <p class="m-0 fs-10 fs-md-5 fw-bold">(0)</p>
        </td>
    `;

    let html_dropoff_success = `
        <td class="text-success text-center position-relative">
            <div class="d-none d-md-block" style="margin-top: -36px">
                <svg width="52" height="52" viewBox="0 0 28 28" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                    <circle cx="14" cy="14" r="12.5" stroke="white"
                        stroke-width="1.5" />
                    <path
                        d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9"
                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>

            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
            <p class="m-0 fs-8 fs-md-2 fw-bolder">0%</p>
            <p class="m-0 fs-10 fs-md-5 fw-bold">(0)</p>
        </td>
    `;

    $.ajax({
        url: baseUrl + post_statistical_overview,
        type: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`
        },
        data: {
            "from_date" : from_date,
            "to_date"   : to_date,
        },
        success: (res) => {
            if(res.code == 200){
                const dataDefault = {
                    "Nhận biết": 0,
                    "Quan tâm": 0,
                    "Đang cân nhắc": 0,
                    "Có nhu cầu": 0,
                    "Đã đóng học phí": 0,
                    "Đã nộp hồ sơ": 0,
                    "Không tham gia học": 0,
                    "Chưa có ngành": 0,
                    "Hoàn học phí": 0,
                    "Đang tư vấn": 0
                }
                $('.report_new_leads').text(res.data.report_new_leads);
                $('.report_profile_success').text(res.data.report_profile_success);
                $('.report_to_students').text(res.data.report_to_students);
                $('.report_total_leads').text(res.data.report_total_leads);
                $('.rate_converts').text(res.data.rate_converts);

                $('.table_statuses_label').empty();
                $('.table_statuses_value').empty();
                $('.table_dropoff_value').empty();
                if(res.data.report_by_status != ''){
                    $.each(res.data.report_by_status, function(status, count) {
                        $('.table_statuses_label').append(html_status_label_open + status + html_status_label_close);
                        $('.table_statuses_value').append(html_status_value_open + count + html_status_value_close);
                    });
                } else {
                    $('.table_statuses_label').append("<p style='padding: 15px'>Không có dữ liệu</p>");
                }

                $.each(res.data.report_by_status, function(status) {
                    $('.table_dropoff_value').append(html_dropoff_warning);
                });

                updateChartData(res.data.report_by_status);
               
            }
        },
        error: (xhr, status, error) => {
            console.error(xhr);
        }
    })

    function updateChartData(apiData){
        const labels = Object.keys(apiData);
        const data = Object.values(apiData);

        if (window.chartStatus) {
            window.chartStatus.data.labels = labels;
            window.chartStatus.data.datasets[0].data = data;
            window.chartStatus.update();
        } else {
            console.log("Không có dữ liệu");
        }
    }

    // function updateChartData(newData) {
    //     const data = Object.values(newData);
    //     if (window.myChart) {
    //         window.myChart.data.datasets[0].data = data;
    //         window.myChart.update();
    //     } else {
    //         const ctx = document.getElementById('myChart').getContext('2d');
    //         window.myChart = new Chart(ctx, {
    //             type: 'bar',
    //             data: {
    //                 labels: ['Label1', 'Label2', 'Label3', 'Label4', 'Label5', 'Label6', 'Label7', 'Label8'], // Thay đổi nếu cần
    //                 datasets: [{
    //                     label: 'Số liệu mới',
    //                     data: newData,
    //                     backgroundColor: 'rgba(75, 192, 192, 0.2)',
    //                     borderColor: 'rgba(75, 192, 192, 1)',
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 responsive: true,
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true
    //                     }
    //                 }
    //             }
    //         });
    //     }
    // }
}

// function report_new_leads(from_date, to_date){
//     const token = localStorage.getItem('jwt_token');
//     let date_range = $('#filter_date_sources .sources_date').text();
//     if (date_range != 'Lọc') {
//         if (date_range.includes(" - ")) {
//             [from_date, to_date] = date_range.split(" - ");
//         } else {
//             from_date = to_date = date_range;
//         }
//     } else {
//         from_date = moment().startOf('month').format('DD/MM/YYYY');
//         to_date = moment().endOf('month').format('DD/MM/YYYY');
//     }
    
//     $.ajax({
//         url: baseUrl + post_statistical_overview,
//         type: 'POST',
//         headers: {
//             'Authorization': `Bearer ${token}`
//         },
//         data: {
//             "from_date" : from_date,
//             "to_date"   : to_date,
//         },
//         success: (res) => {
//             if(res.data){
//                 updateChartSources(res.data);
//             } else {
//                 updateChartSources(
//                     {
//                         "Không liên lạc được": 0,
//                         "Đang cân nhắc": 0,
//                         "Đăng ký hồ sơ": 0,
//                         "Đã nộp hồ sơ": 0,
//                         "Đã đóng học phí": 0,
//                         "Không tham gia học": 0,
//                         "Hoàn học phí": 0,
//                         "Đang tư vấn": 0,
//                     }
//                 )
//             }
            
//         },
//         error: (res) => {
//             console.log(res.data);
//         }
//     })

//     function updateChartSources(apiData){
//         const labels = Object.keys(apiData);
//         const data = Object.values(apiData);

//         if (window.chartSources) {
//             window.chartSources.data.labels = labels;
//             window.chartSources.data.datasets[0].data = data;
//             window.chartSources.update();
//         } else {
//             console.log("Không có dữ liệu");
//         }
//     }
// }
