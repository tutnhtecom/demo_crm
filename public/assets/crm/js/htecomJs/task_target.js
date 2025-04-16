import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { updateKpiApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    let from_date = null;
    let to_date = null;
        // Lấy khoảng ngày 
    $('#daterange').daterangepicker({
        startDate: moment().subtract(7, 'days'), // Mặc định chọn từ 7 ngày trước
        endDate: moment(), // Đến hôm nay
        maxDate: moment(), // Không cho chọn ngày trong tương lai
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: "Áp dụng",
            cancelLabel: "Hủy",
            fromLabel: "Từ",
            toLabel: "Đến",
            customRangeLabel: "Tùy chỉnh",
            weekLabel: "W",
            daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            monthNames: [
                "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
            ]
        },
        ranges: {
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 ngày qua': [moment().subtract(6, 'days'), moment()],
            '30 ngày qua': [moment().subtract(29, 'days'), moment()],
            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function(start, end, label) {
        from_date = start;        
        to_date = end;
        // console.log("Khoảng ngày đã chọn: " + start.format('YYYY-MM-DD') + ' đến ' + end.format('YYYY-MM-DD'));
    });

    $('.fee_kpi_input').on('input', function (e) {
        const maxLength = 12; // Giới hạn số ký tự tối đa (không tính dấu chấm)
        let value = $(this).val();
    
        value = value.replace(/\D/g, '');
    
        if (value.length > maxLength) {
            value = value.substring(0, maxLength); // Cắt chuỗi nếu vượt quá
        }
    
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
        $(this).val(value);
    });

    $('.lead_kpi_input').on('input', function (e) {
        const maxLength = 12; // Giới hạn số ký tự tối đa (không tính dấu chấm)
        let value = $(this).val();
    
        value = value.replace(/\D/g, '');
    
        if (value.length > maxLength) {
            value = value.substring(0, maxLength); // Cắt chuỗi nếu vượt quá
        }
    
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
        $(this).val(value);
    });

    var tableTaskTarget;
    var dataTaskTargetInit = function() {
        tableTaskTarget = new DataTable('#task_target_table', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            dom: "lrtip",
            columnDefs: [
                { width: '50px', targets: 0 }
            ]
        });
    };

    $('#search_task_target').on('keyup', function() {
        tableTaskTarget.search(this.value).draw();
    });
    dataTaskTargetInit();

    $(document).on('click', '.task_target_btn_submit', ()=>{
        const token  = localStorage.getItem('jwt_token');
        const api    = baseUrl+updateKpiApi;

        let status = $('#keep_kpi_for_next_month').is(':checked') ? 1 : 0;
        let kpisData = [];
        $('.task_target_btn_submit').html('Đang lưu...');

        
        tableTaskTarget.rows().every(function () {
            let row = this.node(); // Lấy DOM của hàng hiện tại
            let feeKpiInput = $(row).find('input[name^="fee_kpi"]').val();
            
            if (!feeKpiInput) return;
        
            let employeeId  = $(row).find('input[name^="fee_kpi"]').attr('name').match(/\d+/)[0];
            let feeKpi      = feeKpiInput.split('.').join('');
            let leadKpi     = $(row).find(`#lead_kpi_${employeeId}`).val();
            let from_date   = $('#kpi_from_date_' + employeeId).val();            
            let to_date     = $('#kpis_to_date_' + employeeId).val();           
            let semester_id = $('#kpi_semester_select').val();
            leadKpi = leadKpi === '' ? '0' : leadKpi;
            
        
            if (parseFloat(feeKpi) > 0 || parseFloat(leadKpi) > 0) {
                kpisData.push({
                    employees_id: employeeId,
                    price: feeKpi,
                    quantity: leadKpi,
                    from_date : from_date,
                    to_date : to_date,
                    semester_id : semester_id
                });
            }
        });            
        if (kpisData.length === 0) {
            $.notify("Không có dữ liệu để lưu!", "warn");
            $('.task_target_btn_submit').html('Lưu thay đổi');
            return;
        }

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "status": status,
                "data": kpisData
            },
            success: (res) => {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.message, "error");
                }
                $('.task_target_btn_submit').html('Lưu thay đổi');
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    })


    $('#total_fee_kpi').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
    $('#total_lead_kpi').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
    $('#total_fee_kpi').on('input', function () {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        if (value.length > 12) {
            value = value.substring(0, 12);
        }
        value = new Intl.NumberFormat('vi-VN').format(value);
        $(this).val(value);
    });

    $('#total_lead_kpi').on('input', function () {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        if (value.length > 12) {
            value = value.substring(0, 12);
        }
        value = new Intl.NumberFormat('vi-VN').format(value);
        $(this).val(value);
    });

    $('#distribute_kpi').on('click', function () {
        let totalFeeKpi = parseFloat($('#total_fee_kpi').val().replace(/\./g, '').replace(',', '.')) || 0;
        let totalLeadKpi = parseFloat($('#total_lead_kpi').val().replace(/\./g, '').replace(',', '.')) || 0;
        // let totalLeadKpi = parseInt($('#total_lead_kpi').val()) || 0;
        // console.log(totalLeadKpi); return false;
        
        let rows = tableTaskTarget.rows().nodes();
        let numRows = rows.length;

        if (numRows === 0) {
            alert('Không có dòng nào để phân phối!');
            return;
        }

        let feeKpiPerRow = Math.floor(totalFeeKpi / numRows);
        let leadKpiPerRow = Math.floor(totalLeadKpi / numRows);

        $(rows).each(function (index, row) {
            let feeInput = $(row).find('.fee_kpi_input');
            let leadInput = $(row).find('.lead_kpi_input');

            let feeValue = feeKpiPerRow;
            let leadValue = leadKpiPerRow;

            if (index === numRows - 1) {
                feeValue += totalFeeKpi - feeKpiPerRow * numRows;
                leadValue += totalLeadKpi - leadKpiPerRow * numRows;
            }

            feeInput.val(new Intl.NumberFormat('vi-VN').format(feeValue));
            leadInput.val(leadValue);
        });

        alert('Phân phối thành công!');
        $('#total_fee_kpi').val('');
        $('#total_lead_kpi').val('');
        $('#distribute_kpi_close').click();
    });



})