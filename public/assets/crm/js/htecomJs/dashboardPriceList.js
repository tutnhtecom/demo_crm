import { baseUrl,dashboardPriceListApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    renderDashBoardPriceList('','');
    $('#filter_date_price_list').on('apply.daterangepicker', function () {
        let dateRangeText = $('#filter_date_price_list .text-gray-600').text();
        // let [fromDate, toDate] = dateRangeText.split(" - ");
        let fromDate, toDate;

        if (dateRangeText.includes(" - ")) {
            [fromDate, toDate] = dateRangeText.split(" - ");
        } else {
            fromDate = toDate = dateRangeText; // Khi chỉ có một ngày, gán cả fromDate và toDate bằng cùng một giá trị
        }
        
        renderDashBoardPriceList(fromDate, toDate);
    });
})

function renderDashBoardPriceList(from_date, to_date){
    const token = localStorage.getItem('jwt_token');
    let date_range = $('#filter_date_price_list .price_list_date').text();
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
        url: baseUrl + dashboardPriceListApi,
        type: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`
        },
        data: {
            "from_date" : from_date,
            "to_date"   : to_date,
        },
        success: (res) => {
            if (res) {
                updateChartPriceList(res)
            } else {
                console.log(res);
            }
        },
        error: (res) => {
            console.log(res);
        }
    })
    
    function updateChartPriceList(apiData) {
        const labels = Object.keys(apiData);
        const priceList = labels.map(label => apiData[label].price_list/1000000);
        const transactions = labels.map(label => apiData[label].transactions/1000000);
        if (window.chartPriceList) {
            window.chartPriceList.data.labels = labels;
            window.chartPriceList.data.datasets[0].data = priceList;
            window.chartPriceList.data.datasets[1].data = transactions;
            window.chartPriceList.update();
        } else {
            console.log("Không có dữ liệu");
        }
    }
}
