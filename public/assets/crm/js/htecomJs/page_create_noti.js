import { baseUrl }           from '/assets/crm/js/htecomJs/variableApi.js';
import { createNotiApi }     from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError }       from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    $(document).on('submit', '#notification_create_form', (e) => {
        const clickedButton = $(document.activeElement);
        const action = clickedButton.attr('value');

        if(action === 'submit'){
            e.preventDefault();
            $('#create_noti_btn_submit').html('Đang gửi...');

            const token     = localStorage.getItem('jwt_token');
            const api       = baseUrl+createNotiApi;
            const formData  = new FormData();
            let title       = $('#create_noti_title').val();
            let content     = $('#create_noti_content').val();
            let status      = 0;
            let ojb_type    = $('input[name="receiver_type"]:checked').val();
            let send_type   = $('input[name="send_to_type"]:checked').val();
            let topic       = '';
            let email       = '';
            let groupId     = '';
            let file        = $('#file-upload')[0].files[0];

            if(ojb_type == 1 || ojb_type == 2 || ojb_type == 0){
                email = $('#create_noti_user option:selected').map(function() {
                    return $(this).data('email');
                }).get();
            }

            if(ojb_type == 3){
                groupId = $('#create_noti_user option:selected').data('groupid');
            }

            const iframeDocument = $('#create_noti_content_ifr').contents().get(0);
            const bodyIframe     = iframeDocument.body;

            if (file) {
                formData.append('File', file);
            } else if (email && (ojb_type == 1 || ojb_type == 2 || ojb_type == 0)) {
                formData.append('email', email);
            } else if(ojb_type == 3) {
                formData.append('groups_id', groupId);
            }

            formData.append('title', title);
            formData.append('content', content);
            formData.append('status', status);
            // if(ojb_type == 1 || ojb_type == 2 || ojb_type == 0){
            //     formData.append('email', email);
            // }
            formData.append('obj_types', ojb_type);
            formData.append('send_types', send_type);
            formData.append('topic', topic);
            // if(ojb_type == 3){
            //     formData.append('groups_id', groupId);
            // }

            $.ajax({
                url: api,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function(res) {
                    if(res.code == 422){
                        handleError('#create_noti_user', '.create_noti_user_wrapper', res.data.email);
                        handleError('#create_noti_title', '.create_noti_title_wrapper', res.data.title);
                        handleError('#create_noti_content', '.create_noti_content_wrapper', res.data.content);
                        if(res.message){
                            $.notify(res.message, "error");
                        }
                    } else{
                        $('#create_noti_title').val('');
                        $('#create_noti_user').val('').trigger('change');
                        $(bodyIframe).empty();
                        $.notify(res.message, "success");
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                    $('#create_noti_btn_submit').html('Gửi');
                },
                error: function(xhr, status, error) {
                    $('#create_noti_btn_submit').html('Gửi');
                }
            })
        } else if (action === 'save') {
            e.preventDefault();
            $('#create_noti_btn_draft').html('Đang lưu...');

            const token     = localStorage.getItem('jwt_token');
            const api       = baseUrl+createNotiApi;
            const formData  = new FormData();
            let title       = $('#create_noti_title').val();
            let content     = $('#create_noti_content').val();
            let status      = 0;
            let ojb_type    = $('input[name="receiver_type"]:checked').val();
            let send_type   = $('input[name="send_to_type"]:checked').val();
            let topic       = '';
            let email       = '';
            let groupId     = '';
            let file        = $('#file-upload')[0].files[0];

            if(ojb_type == 1 || ojb_type == 2 || ojb_type == 0){
                email = $('#create_noti_user option:selected').map(function() {
                    return $(this).data('email');
                }).get();
            }

            if(ojb_type == 3){
                groupId = $('#create_noti_user option:selected').data('groupid');
            }

            const iframeDocument = $('#create_noti_content_ifr').contents().get(0);
            const bodyIframe     = iframeDocument.body;

            if (file) {
                formData.append('File', file);
            } else if (email && (ojb_type == 1 || ojb_type == 2 || ojb_type == 0)) {
                formData.append('email', email);
            } else {
                console.error('Cần phải có tệp hoặc email hợp lệ với ojb_type');
            }

            formData.append('title', title);
            formData.append('content', content);
            formData.append('status', status);
            // if(ojb_type == 1 || ojb_type == 2 || ojb_type == 0){
            //     formData.append('email', email);
            // }
            formData.append('obj_types', ojb_type);
            formData.append('send_types', send_type);
            formData.append('topic', topic);
            if(ojb_type == 3){
                formData.append('groups_id', groupId);
            }

            $.ajax({
                url: api,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function(res) {
                    if(res.code == 422){
                        handleError('#create_noti_user', '.create_noti_user_wrapper', res.data.email);
                        handleError('#create_noti_title', '.create_noti_title_wrapper', res.data.title);
                        handleError('#create_noti_content', '.create_noti_content_wrapper', res.data.content);
                    } else{
                        $('#create_noti_title').val('');
                        $('#create_noti_user').val('').trigger('change');
                        $(bodyIframe).empty();
                        $.notify(res.message, "success");
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                    $('#create_noti_btn_draft').html('Lưu nháp');
                },
                error: function(xhr, status, error) {
                    $('#create_noti_btn_draft').html('Lưu nháp');
                }
            })
        }

    })

    handleRemoveError('.create_noti_user_wrapper', '#create_noti_user');
    handleRemoveError('.create_noti_title_wrapper', '#create_noti_title');
    handleRemoveError('.create_noti_content_wrapper', '#create_noti_content');

    let students  = window.students;
    let employees = window.employees;
    let leads     = window.leads;
    let group     = window.group;

    $(document).on('change', 'input[name="receiver_type"]', function() {
        const selectedValue = $(this).val();
        const systemWrapper = $('.system_radio_wrapper');
        const button        = $('#button-addon2');

        if (selectedValue === "3") {
            button.css({
                "opacity": "0.5",
                "pointer-events": "none"
            });
        } else {
            button.css({
                "opacity": "1",
                "pointer-events": "auto"
            });
        }

        if (selectedValue !== "2") {
            systemWrapper.css("display", "none");
        } else {
            systemWrapper.css("display", "block");
        }
    });

    function loadOptions(options) {
        if($('#create_noti_user').length){
            $('#create_noti_user').empty();

            if (Array.isArray(options)) {
                options.forEach(function(option) {
                    var newOption;

                    if (options === students || options === leads) {
                        newOption = $('<option></option>')
                                        .attr('data-email', option.email)
                                        .text(option.full_name);
                    } else if(options === group){
                        newOption = $('<option></option>')
                                        .attr('data-groupid', option.id)
                                        .text(option.name);
                    }else {
                        newOption = $('<option></option>')
                                        .attr('data-email', option.email)
                                        .text(option.name);
                    }

                    $('#create_noti_user').append(newOption);
                });
            }

            $('#create_noti_user').trigger('change');
        }
    }
    loadOptions(employees);

    $('input[name="receiver_type"]').on('change', function() {
        if ($(this).val() == '2') {
            loadOptions(employees);
        } else if ($(this).val() == '1') {
            loadOptions(students);
        } else if($(this).val() == '0') {
            loadOptions(leads);
        }  else if($(this).val() == '3') {
            loadOptions(group);
        }
    });

    var tableNoti;
    var dataNotificationInit = function() {
        tableNoti = new DataTable('#notification_table', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            // dom: "lrtip",
            columnDefs: [
                { width: '50px', targets: 0 }
            ]
        });
    };

    var tableNotiSend;
    var dataNotiSendInit = function() {
        tableNotiSend = new DataTable('#notification_table_send', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            // scrollX: true,
            // dom: "lrtip",
            columnDefs: [
                { width: '50px', targets: 0 }
            ]
        });
    };

    var tableNotiDraft;
    var dataNotiDraftInit = function() {
        tableNotiDraft = new DataTable('#notification_table_draft', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            // scrollX: true,
            // dom: "lrtip",
            columnDefs: [
                { width: '50px', targets: 0 }
            ]
        });
    };

    dataNotiDraftInit();
    dataNotificationInit();
    dataNotiSendInit();

    $('#file-upload').on('change', function () {
        const fileName = this.files[0] ? this.files[0].name : 'Không có tệp nào được chọn';
        $('#file-name').text(fileName);
    });

    $(document).on('click', '.btn_import_file_send_noti', function () {
        const customFileUpload   = $('.custom-file-upload');
        const selectWrapper      = $('.create_noti_user_wrapper .select2-selection');
        const radioTypeSendNoti  = $('.radio_type_send_noti');
        const radioBtnSendNoti   = $('.system_radio_wrapper');

        if (customFileUpload.is(':visible')) {
            customFileUpload.slideUp('fast', function () {
                $('#file-upload').val('');
                $('#file-name').text('Không có tệp nào được chọn');
                selectWrapper.css({
                    'cursor': '',
                    'pointer-events': ''
                });
            });
            radioTypeSendNoti.css('visibility', 'visible');
            radioBtnSendNoti.css('display', 'block');
        } else {
            customFileUpload.slideDown('fast', function () {
                selectWrapper.css({
                    'cursor': 'not-allowed',
                    'pointer-events': 'none'
                });
            });
            radioTypeSendNoti.css('visibility', 'hidden');
            radioBtnSendNoti.css('display', 'none');
        }
    });

    $('#file-upload').on('change', function (e) {
        const file = e.target.files[0];
        const fileName = file ? file.name : 'Không có tệp nào được chọn';
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (file && (fileExtension === 'csv' || fileExtension === 'xlsx')) {
            $('#file-name').text(fileName);
        } else {
            $('#file-name').text('Chỉ chấp nhận tệp .csv hoặc .xlsx');
            $('#file-name').val('');
            $('#file-upload').val('');
        }
    });

    $(document).on('click','.btn_import_file_send_noti', function () {
        $(".create_noti_user_wrapper").slideToggle(300); // Hủy rồi khởi tạo lại
    });

})
