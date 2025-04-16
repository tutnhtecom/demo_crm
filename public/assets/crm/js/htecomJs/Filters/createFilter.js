import { baseUrl, createFilterApi, updateFilterApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError }       from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('click', '#btn_add_filter', (e)=>{                
        const btn = $(e.currentTarget);
        const api = baseUrl+createFilterApi;
        const token = localStorage.getItem('jwt_token');

        let data = {
            "name"          : $('#name').val(),
            "start_date"    : formatDate($('#start_date').val()),
            "end_date"      : formatDate($('#end_date').val()),
        }                
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: data,
            success: (res) => {
                if(res.code == 422){
                    handleError('#name', '.create_filter_name_wrapper', res.data.name);
                    handleError('#start_date', '.create_filter_start_date', res.data.start_date);
                    handleError('#end_date', '.create_filter_end_date', res.data.end_date);                    
                } else {
                    $('#name').val('');
                    $('#start_date').val('');
                    $('#end_date').val('');
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Tạo');
            },
            error: (error) => {
                console.log(error);
            }
        })
    });

   
    $(document).on('click', '.create_filter_name_wrapper', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#name').removeClass('border-error');
    });

    $(document).on('click', '.create_filter_start_date', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#start_date').removeClass('border-error');
    });

    $(document).on('click', '.create_filter_end_date', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#end_date').removeClass('border-error');
    });

    $(document).on('click', '.update_config_filter', (e)=>{
        let id = $(e.currentTarget).attr('data-id');
        $('#btn_update_filter').attr('data-id', id);
    })

    $(document).on('click', '#btn_update_filter', (e)=>{   
        const id  = $(e.currentTarget).attr('data-id'); 
        const btn = $(e.currentTarget);
        const api = baseUrl+updateFilterApi+id;
        const token = localStorage.getItem('jwt_token');
        let data = {
            "name"          : $('#u_name').val(),
            "start_date"    : formatDate($('#u_start_date').val()),
            "end_date"      : formatDate($('#u_end_date').val()),
        }             
        btn.html('Đang lưu...');
        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: data,
            success: (res) => {
                if(res.code == 422){
                    handleError('#u_name', '.create_filter_name', res.data.name);
                    handleError('#u_start_date', '.create_filter_start_date', res.data.start_date);
                    handleError('#u_end_date', '.create_filter_end_date', res.data.end_date);                    
                } else {
                    $('#name').val('');
                    $('#start_date').val('');
                    $('#end_date').val('');
                    $('#config-filter').val('');
                    $.notify(res.message, "success");
                    
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Tạo');
            },
            error: (error) => {
                console.log(error);
            }
        })
    });
})
