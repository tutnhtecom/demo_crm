import { baseUrl,createLeadFromSupportApi, changeStatusTicketApi} from '/assets/crm/js/htecomJs/variableApi.js';
$(document).ready(()=>{
    //Update status ticket
    $(document).on('change','.ticket_status_select', function(){
        var selectedOption = $(this).find('option:selected');
        const ticketId = $(this).attr('data-ticket-id');
        const selectedValue      = selectedOption.val();
        console.log('selectedValue', selectedValue);
        const api         = baseUrl+changeStatusTicketApi+ticketId;
        const token       = localStorage.getItem('jwt_token');

        if (selectedOption) {
            $.ajax({
                url: api,
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: {
                    "sp_status_id": selectedValue
                },
                success: function (res) {
                    if(res.code == 200){
                        $.notify(res.message, "success");
                    } else {
                        $.notify(res.message, "error");
                    }
                },
                error: function () {
                    $.notify(res.message, "error");
                }
            });
        }
    });

    $(document).on('click', '.convert_to_lead', function(){
        let userName = $(this).attr('data-user-name');
        let userEmail = $(this).attr('data-user-email');
        let userPhone = $(this).attr('data-user-phone');
        const token       = localStorage.getItem('jwt_token');
        const api         = baseUrl+createLeadFromSupportApi;

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "full_name": userName,
                "email": userEmail,
                "phone": userPhone,
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                } else {
                    if(res.data.full_name){
                        $.notify(res.data.full_name, "error");
                    }
                    if(res.data.email){
                        $.notify(res.data.email, "error");
                    }
                    if(res.data.phone){
                        $.notify(res.data.phone, "error");
                    }
                }

            },
            error: function () {
                $.notify(res.message, "error");
            }
        });
    });

    $(document).on("click", "#detail_support_and_update_stt", function (e) {
        
        const id = $(this).attr('data-id');
        const api = baseUrl+changeStatusTicketApi+id;
        const token = localStorage.getItem('jwt_token');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "sp_status_id": 2
            },
            success: function (res) {
                if(res.code == 200){
                    setTimeout(()=>{
                        window.location.href = baseUrl+'/crm/request_support/detail_support/'+id;
                    },1000)
                }
            },
            error: function () {
                $.notify(res.message, "error");
            }
        })
    })


    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#tiny',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
        });
    });

    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#create_lead_note',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
        });
    });

    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#edit_lead_note',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
        });
    });

    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#create_noti_content',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
        });
    });

    function clickMenuActive(){
        const currentUrl = window.location.href;
        $('.menu-link').removeClass('active'); // Thêm class 'active'
        $('.menu-link').parents('.menu-item, .menu-sub.menu-sub-accordion').removeClass('show');
        $('.menu-link').each(function() {
            const linkUrl = $(this).attr('href');

            if (currentUrl.includes(linkUrl)) {
                $(this).addClass('active'); // Thêm class 'active'
                $(this).parents('.menu-item, .menu-sub.menu-sub-accordion').addClass('show');
                // $(this).parents('.menu-item.menu-accordion').addClass('show');
            }
        });
    }
    clickMenuActive()

    function formatTime(createdAt) {
        const date = new Date(createdAt);

        const hours = String(date.getUTCHours()).padStart(2, '0'); // Thêm 0 ở đầu nếu cần
        const minutes = String(date.getUTCMinutes()).padStart(2, '0'); // Thêm 0 ở đầu nếu cần

        return `${hours}:${minutes}`;
    }

    // custome filter search \\
    var dtSearchInit = function() {
        $('#status-filter').change(function() {
            dtSearchAction($(this), 4);
        });
        $('#sources-filter').change(function() {
            dtSearchAction($(this), 5);
        });
        $('#marjor-filter').change(function() {
            dtSearchAction($(this), 7);
        });
        $('#tags-filter').change(function() {
            dtSearchAction($(this), 8);
        });
    };

    var dtSearchAction = function(selector, columnId) {
        var fv = selector.val();
        if ((fv == '') || (fv == null)) {
            tableLeads.column(columnId).search('').draw();
        } else {
            tableLeads.column(columnId).search(fv).draw();
        }
    };

    $('#btn_back_page').on('click', function () {
        window.history.back();
    });

    // $('.lead_status_select').on('change', function() {
    //     var selectedOption = $(this).find('option:selected');
    //     var selectedColor = selectedOption.data('bg-color');
    //     var selectedBorderColor = selectedOption.data('border-color');
    //     var selectedTextColor = selectedOption.data('text-color');

    //     $(this).css({
    //         'background-color': selectedColor,
    //         'border-color': selectedBorderColor,
    //         'color': selectedTextColor
    //     });
    // });

    $(".ticket_status_select").each(function () {
        updateSelectStyle($(this)); // Cập nhật màu lúc tải trang
    });

    $(document).on("change",".ticket_status_select", function () {
        updateSelectStyle($(this));
    });

    function updateSelectStyle(select) {
        let selectedOption = select.find("option:selected");
        let bgColor = selectedOption.data("bg-color") || "white";
        let textColor = selectedOption.data("color") || "black";
        let borderColor = selectedOption.data("border-color") || "black";

        select.css({
            "background-color": bgColor,
            "color": textColor,
            "border-color": borderColor
        });
    }
})

export function formatDate(inputDate) {
    const dateObj = new Date(inputDate);

    if (isNaN(dateObj.getTime())) {
        return null; // Nếu không hợp lệ, trả về null hoặc thông báo lỗi
    }

    const day = String(dateObj.getDate()).padStart(2, '0'); // Đảm bảo 2 chữ số
    const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
    const year = dateObj.getFullYear();

    return `${day}/${month}/${year}`;
}

export function handleError(field, wrapper, errors) {
    if (errors != null) {
        $(field).addClass('border-error');
        $(wrapper + ' .error-input').html(errors.join(', '));
        $(wrapper + ' .error-input').addClass('show-error');
    }
}

// handle remove error effect when click input \\
export function handleRemoveError(wrapper, id_input){
    $(wrapper).on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find(id_input).removeClass('border-error');
    });
}
