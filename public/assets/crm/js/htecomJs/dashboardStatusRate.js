import { baseUrl,dashboardStatusRateApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    renderDashBoardStatusRate('','');
    $('#filter_date_status_rate').on('apply.daterangepicker', function () {
        let dateRangeText = $('#filter_date_status_rate .text-gray-600').text();
        let fromDate, toDate;

        if (dateRangeText.includes(" - ")) {
            [fromDate, toDate] = dateRangeText.split(" - ");
        } else {
            fromDate = toDate = dateRangeText;
        }
        
        renderDashBoardStatusRate(fromDate, toDate);
    });
})

function renderDashBoardStatusRate(from_date, to_date){
    const token = localStorage.getItem('jwt_token');
    let date_range = $('#filter_date_status_rate .status_rate_date').text();
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

    $.ajax({
        url: baseUrl + dashboardStatusRateApi,
        type: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`
        },
        data: {
            "from_date" : from_date,
            "to_date"   : to_date,
        },
        success: (res) => {
            if(res.data){
                updateChartStatusRate(res.data);
            } else {
                console.log("Không có dữ liệu");
            }
        },
        error: (res) => {
            console.log(res.data);
        }
    })

    function updateChartStatusRate(apiData){
        const labels = Object.keys(apiData);
        const data   = Object.values(apiData);

        if (window.chartStatusRate) {
            window.chartStatusRate.data.labels = labels;
            window.chartStatusRate.data.datasets[0].data = data;
            window.chartStatusRate.update();
        } else {
            console.log("Không có dữ liệu");
        }
    }
}