import { baseUrl, createConfigGeneralApi,updateConfigGeneralApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '#btn_task_create', (e)=>{
        e.preventDefault();
        const btn       = $(e.currentTarget);
        const api       = baseUrl+createConfigGeneralApi;
        const token     = localStorage.getItem('jwt_token');
        let taskStart   = $('#task_start_date').val();
        let taskEnd     = $('#task_end_date').val();
        btn.html('Đang tạo...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "start_date": taskStart,
                "end_date"  : taskEnd,
                "types"     : 1
            },
            success: (res)=>{
                if (res.code == 200) {
                    $.notify(res.message, "success");
                    document.location.reload();
                }
                btn.html('Tạo');
            },
            error: (error)=>{
                console.log(error);
            }
        })
    })

    $(document).on('click', '#btn_task_update', (e)=>{
        e.preventDefault();
        const btn       = $(e.currentTarget);
        const id        = btn.attr('data-id');
        const api       = baseUrl+updateConfigGeneralApi+id;
        const token     = localStorage.getItem('jwt_token');
        let taskStart   = $('#task_start_date').val();
        let taskEnd     = $('#task_end_date').val();
        btn.html('Đang cập nhật...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "start_date": taskStart,
                "end_date"  : taskEnd,
                "types"     : 1
            },
            success: (res)=>{
                if (res.code == 200) {
                    $.notify(res.message, "success");
                    document.location.reload();
                }
                btn.html('Cập nhật');
            },
            error: (error)=>{
                console.log(error);
            }
        })
    })

    $(document).on('click', '#btn_kpi_create', (e)=>{
        e.preventDefault();
        const btn       = $(e.currentTarget);
        const api       = baseUrl+createConfigGeneralApi;
        const token     = localStorage.getItem('jwt_token');
        let taskStart   = $('#kpi_start_date').val();
        let taskEnd     = $('#kpi_end_date').val();
        btn.html('Đang tạo...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "start_date": taskStart,
                "end_date"  : taskEnd,
                "types"     : 0
            },
            success: (res)=>{
                if (res.code == 200) {
                    $.notify(res.message, "success");
                    document.location.reload();
                }
                btn.html('Tạo');
            },
            error: (error)=>{
                console.log(error);
            }
        })
    })

    $(document).on('click', '#btn_kpi_update', (e)=>{
        e.preventDefault();
        const btn       = $(e.currentTarget);
        const id        = btn.attr('data-id');
        const api       = baseUrl+updateConfigGeneralApi+id;
        const token     = localStorage.getItem('jwt_token');
        let taskStart   = $('#kpi_start_date').val();
        let taskEnd     = $('#kpi_end_date').val();
        btn.html('Đang cập nhật...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "start_date": taskStart,
                "end_date"  : taskEnd,
                "types"     : 0
            },
            success: (res)=>{
                if (res.code == 200) {
                    $.notify(res.message, "success");
                    document.location.reload();
                }
                btn.html('Cập nhật');
            },
            error: (error)=>{
                console.log(error);
            }
        })
    })

    // Thêm mới thông số cho yêu cầu kỹ thuật
    $(document).on('click', '#btn_supports_create', (e)=>{        
        e.preventDefault();
        const btn           = $(e.currentTarget);
        const api           = baseUrl+createConfigGeneralApi;
        const token         = localStorage.getItem('jwt_token');
        let supportStart    = $('#support_end_date').val();
        let supportEnd      = $('#support_end_date').val();
        btn.html('Đang tạo...');
        let data =  {
            "start_date": supportStart,
            "end_date"  : supportEnd,
            "types"     : 2
        }       
        
        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: data,
            success: (res)=>{
                if (res.code == 200) {
                    $.notify(res.message, "success");
                    document.location.reload();
                }
                btn.html('Tạo');
            },
            error: (error)=>{
                console.log(error);
            }
        })
    })
    
    // Update
    $(document).on('click', '#btn_supports_update', (e)=>{
        e.preventDefault();
        const btn       = $(e.currentTarget);
        const id        = btn.attr('data-id');
        const api       = baseUrl+updateConfigGeneralApi+id;
        const token     = localStorage.getItem('jwt_token');
        let taskStart   = $('#support_end_date').val();
        let taskEnd     = $('#support_end_date').val();
        btn.html('Đang cập nhật...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "start_date": taskStart,
                "end_date"  : taskEnd,
                "types"     : 2
            },
            success: (res)=>{
                if (res.code == 200) {
                    $.notify(res.message, "success");
                    document.location.reload();
                }
                btn.html('Cập nhật');
            },
            error: (error)=>{
                console.log(error);
            }
        })
    });
    // Reset inputs

    $('#task_start_date').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });

    $('#task_end_date').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });

    $('#kpi_start_date').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });

    $('#kpi_end_date').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });

    $('#support_end_date').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
})
