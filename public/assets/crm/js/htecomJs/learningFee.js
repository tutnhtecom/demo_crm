import {baseUrl, learnFeeForSourcesApi} from '/assets/crm/js/htecomJs/variableApi.js'
$(document).ready(() => {
    let loading_html = `<div class="hte_loading_wrapper">
        <div class="hte_spanner show">
            <div class="hte_loader"></div>
        </div>
    </div>` ;
    $(document).on('change', '#academic_terms_leads_fee', function (e) {
        $('#learning-fee').prepend(loading_html);        
        let params = {
            "academic_terms_id" : $(this).val(),
            "types"             : 1 
        }        
        get_data_by_types(params);
    })
    $(document).on('click', '#learning_fee_tab', function (e) { 
        $('#learning-fee').prepend(loading_html);        
        let params = {            
            "types"             : 0
        }        
        get_data_by_types(params);
    })
    function get_data_by_types(params){        
        let data = null;
        if(params.academic_terms_id && params.types == 1) {
            data = { "academic_terms_id" : params.academic_terms_id }
        }
        const data_id           = $('#learning_fee_tab').attr('data-id')
        const api               = baseUrl+learnFeeForSourcesApi+data_id;
        const token             = localStorage.getItem('jwt_token');
        $.ajax({
            url: api,
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: data,
            success: (res)=>{
                if(res && res.code == 422) {
                    $.notify(res.message, "error");
                } else {
                    render_data_table(res.data);
                }
            },
            error: (err)=>{
                console.log(err);
            },
            complete: ()=>{
                $('.hte_loading_wrapper').remove();
            }
        });
    }
    function render_data_table(data){        
        let tHead = `<thead>
                <tr class="text-white text-nowrap fs-5 text-center">
                    <th rowspan="2" class="align-middle text-center">Học kỳ</th>
                    <th rowspan="2" class="align-middle">Số lượng SV nhập học</th>
                    <th rowspan="2" class="align-middle">Học phí</th>
                    <th colspan="2" class="align-middle text-center" >Định mức thanh toán</th>
                    <th rowspan="2" class="align-middle" style="width:10%">Thời gian thực hiện thanh toán</th>
                    <th rowspan="2" class="align-middle">Đơn vị</th>
                    <th rowspan="2" class="align-middle text-center" >Nhân sự Quản lý</th>
                </tr>
                <tr class="text-white text-nowrap fs-5 text-center">
                    <th class="align-middle text-center">Đơn vị </th>
                    <th class="align-middle">Nhân sự quản lý</th>
                </tr>
            </thead>`;
        let tbody = `<tbody>`;
        let quantity_check = true;
        data.forEach(d => {
            tbody += `<tr class="text-white text-nowrap fs-5 text-center">`;
            tbody += `<td class="align-middle text-center">${d.semesters_name}<br>(${d.from_year} - ${d.to_year})</td>`;
            // if(quantity_check){
            //     // tbody += `<td rowspan="${data.length *2}" class="align-middle text-center">${d.total_quantity}</td>`;
            //     tbody += `<td rowspan="${data.length *2}"  class="align-middle text-center">${d.total_quantity}</td>`;
            //     quantity_check = false;
            // }
            tbody += `<td class="align-middle text-center">${d.total_quantity}</td>`;
            tbody += `<td class="align-middle text-center">${d.total_price}</td>`;
            tbody += `<td class="align-middle text-center">${d.payment_rate}% <br>(${d.payment_manager_price})</td>`;
            tbody += `<td class="align-middle text-center">${d.payment_manager_rate}%</td>`;
            tbody += `<td class="align-middle text-center">${d.payment_note}</td>`;
            tbody += `<td class="align-middle text-center">${d.payment_for_sources}</td>`;
            tbody += `<td class="align-middle text-center">${d.payment_for_manager}</td>`;
            tbody += `<tr>`;

        });
        let tHtml = tHead + tbody + `</tbody>`;
        $('#table_leads_fee').html(tHtml);
    }
    function render_data (academic_terms_id) {
        // Render data  for dataable
        const data_id           = $('#learning_fee_tab').attr('data-id')
        const api               = baseUrl+learnFeeForSourcesApi+data_id;
        const token             = localStorage.getItem('jwt_token');
        $('#table_leads_fee').DataTable({
            // processing: true,
            // serverSide: true,
            ajax: {
                url: api,
                method: 'POST',
                headers: {
                    Authorization: `Bearer ${token}`
                },
                data: {
                    academic_terms_id: academic_terms_id
                }               
            },
            columns: [
                {
                    // Khóa tuyển sinh
                    data: 'academic_terms_name',
                    name: 'academic_terms_name',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="id_lead">` + data + `</span>`
                    }
                },
                {
                    // Tông số lượng nhập học
                    data: 'total_quantity',
                    name: 'total_quantity',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="id_lead">` + data + `</span>`
                    }
                },
                {
                    // Học phí
                    data: 'total_price',
                    name: 'total_price',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="id_lead">` + data + `</span>`
                    }
                },
                {
                    // Định mức thanh toán
                    data: 'payment_rate',
                    name: 'payment_rate',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="id_lead">` + data + `</span>`
                    }
                },
                {
                    // Thời gian thực hiện
                    data: 'payment_note',
                    name: 'payment_note',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="id_lead">` + data + `</span>`
                    }
                },
                {
                    data: 'payment_rate',
                    name: 'payment_rate',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="id_lead">` + data + `</span>`
                    }
                },
                {
                    data: 'payment_for_employees',
                    name: 'payment_for_employees',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="id_lead">` + data + `</span>`
                    }
                }
            ]
        })
    }
})
