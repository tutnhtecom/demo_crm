import { baseUrl,dashboardNewLeadsApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    renderDashBoardNewLeads('','');
    $('#filter_date_new_leads').on('apply.daterangepicker', function () {
        let dateRangeText = $('#filter_date_new_leads .text-gray-600').text();
        let fromDate, toDate;

        if (dateRangeText.includes(" - ")) {
            [fromDate, toDate] = dateRangeText.split(" - ");
        } else {
            fromDate = toDate = dateRangeText;
        }

        renderDashBoardNewLeads(fromDate, toDate);
    });
})

function renderDashBoardNewLeads(from_date, to_date){
    const token = localStorage.getItem('jwt_token');
    let date_range = $('#filter_date_new_leads .new_leads_date').text();
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
        url: baseUrl + dashboardNewLeadsApi,
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
                updateChartNewLeads(res.data);
            } else {
                console.log("Không có dữ liệu");
            }
            
        },
        error: (res) => {
            console.log(res.data);
        }
    })

    function updateChartNewLeads(apiData){
        const labels = Object.keys(apiData).map(formatDate);
        const data = Object.values(apiData);

        if (window.chartNewLeads) {
            window.chartNewLeads.data.labels = labels;
            window.chartNewLeads.data.datasets[0].data = data;
            window.chartNewLeads.update();
        } else {
            console.log("Không có dữ liệu");
        }
    }
}

function formatDate(date) {
    const [year, month, day] = date.split("-");
    return `${day}/${month}/${year}`;
}
