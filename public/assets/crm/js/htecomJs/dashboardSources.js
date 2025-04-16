import { baseUrl,dashboardSourcesApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    renderDashBoardSources('','');
    $('#filter_date_sources').on('apply.daterangepicker', function () {
        let dateRangeText = $('#filter_date_sources .text-gray-600').text();
        // let [fromDate, toDate] = dateRangeText.split(" - ");
        let fromDate, toDate;

        if (dateRangeText.includes(" - ")) {
            [fromDate, toDate] = dateRangeText.split(" - ");
        } else {
            fromDate = toDate = dateRangeText; // Khi chỉ có một ngày, gán cả fromDate và toDate bằng cùng một giá trị
        }
        
        renderDashBoardSources(fromDate, toDate);
    });
})

function renderDashBoardSources(from_date, to_date){
    const token = localStorage.getItem('jwt_token');
    let date_range = $('#filter_date_sources .sources_date').text();
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
        url: baseUrl + dashboardSourcesApi,
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
                updateChartSources(res.data);
            } else {
                updateChartSources(
                    {
                        "Facebook": 0,
                        "Bạn bè": 0,
                        "Website": 0,
                        "Zalo": 0
                    }
                )
            }
            
        },
        error: (res) => {
            console.log(res.data);
        }
    })

    function updateChartSources(apiData){
        const labels = Object.keys(apiData);
        const data = Object.values(apiData);

        if (window.chartSources) {
            window.chartSources.data.labels = labels;
            window.chartSources.data.datasets[0].data = data;
            window.chartSources.update();
        } else {
            console.log("Không có dữ liệu");
        }
    }
}
