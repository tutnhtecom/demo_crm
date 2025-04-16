import { baseUrl,dashboardMajorRateApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    renderDashBoardMajorRate('','');
    $('#filter_date_major_rate').on('apply.daterangepicker', function () {
        let dateRangeText = $('#filter_date_major_rate .text-gray-600').text();
        let fromDate, toDate;

        if (dateRangeText.includes(" - ")) {
            [fromDate, toDate] = dateRangeText.split(" - ");
        } else {
            fromDate = toDate = dateRangeText;
        }
        
        renderDashBoardMajorRate(fromDate,toDate);
    });
})

function renderDashBoardMajorRate(from_date, to_date){
    const token = localStorage.getItem('jwt_token');
    let date_range = $('#filter_date_major_rate .major_rate_date').text();
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
        url: baseUrl + dashboardMajorRateApi,
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
                updateChartMajorRate(res.data);
            } else {
                console.log("Không có dữ liệu");
            }
        },
        error: (res) => {
            console.log(res.data);
        }
    })

    function updateChartMajorRate(apiData){
        const labels = Object.keys(apiData);
        const data   = Object.values(apiData);

        if (window.chartMajorRate) {
            window.chartMajorRate.data.labels = labels;
            window.chartMajorRate.data.datasets[0].data = data;
            window.chartMajorRate.update();
        } else {
            console.log("Không có dữ liệu");
        }
    }
}