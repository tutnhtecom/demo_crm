$(document).ready(function() {
    // const baseUrl = "http://localhost";
    const baseUrl           = window.location.origin;
    const registerLeadApi   = "/api/leads/register-profile";
    const uploadAvatar      = "/api/leads/upload-avatar/";
    const infomationProfile = "/api/leads/information-profile/";
    const contactsApi       = "/api/leads/contacts/";
    const familyApi         = "/api/leads/family/";
    const scoreApi          = "/api/leads/score/";
    const confirmApi        = "/api/leads/confirm/";
    const loginApi          = "/api/auth/login";
    const supportApi        ="/api/leads/supports";
    const checkStatusApi    ="/api/leads/history/";

    var idLead = "";
    var imgUrl = "";

    // ----- handle login ----- \\
    $('#email-lead-login').on('click', () => {
        $('.email-login-lead-wrapper .error-message').html("");
        $('#email-lead-login').removeClass('border-error');
    })

    $('#password-lead-login').on('click', () => {
        $('.password-login-lead-wrapper .error-message').html("");
        $('#password-lead-login').removeClass('border-error');
    })

    $('#email-lead-login').on('keydown', function(event) {
        if (event.key === 'Enter') {
            $('#btn-lead-login').click();
        }
    });
    
    $('#password-lead-login').on('keydown', function(event) {
        if (event.key === 'Enter') {
            $('#btn-lead-login').click();
        }
    });

    $('#btn-lead-login').on('click' ,(e) => {
        e.preventDefault();
        $('.loader-btn-login').show();
        $('#btn-lead-login').html('');

        const api = baseUrl + loginApi;
        let email =  $('#email-lead-login').val();
        let password =  $('#password-lead-login').val();

        data = {
            email: email,
            password: password,
            types: 0
        }
        let convertData = JSON.stringify(data);

        $.ajax({
            url: api,
            type: 'POST',
            data: convertData,
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                if(response.code == 422){
                    if(response.data.email != null){
                        $('.email-login-lead-wrapper .error-message').html(response.data.email);
                        $('#email-lead-login').addClass('border-error');
                    }
                    if(response.data.password != null){
                        $('.password-login-lead-wrapper .error-message').html(response.data.password);
                        $('#password-lead-login').addClass('border-error');
                    }
                    $('.loader-btn-login').hide();
                    $('#btn-lead-login').html('Đăng nhập');
                } else {
                    $('#error-lead-login').html(response.message);
                    $('#error-lead-login').show();
                    $('.loader-btn-login').hide();
                    $('#btn-lead-login').html('Đăng nhập');
                }

                if(response.code == 200){
                    window.location.href = baseUrl + '/register';
                    localStorage.removeItem('data');
                    localStorage.setItem('data', JSON.stringify(response.data_leads));
                    $.notify(response.message, "success");
                    $('.loader-btn-login').hide();
                    $('#btn-lead-login').html('Đăng nhập');
                }
            },
            error: function(xhr, status, error){
                $('.loader-btn-login').hide();
                $('#btn-lead-login').html('Đăng nhập');
                $.notify('Đã xảy ra lỗi, vui lòng thử lại!', "error");

            }
        })
    });

    const loginResponse = localStorage.getItem('data');
    if (loginResponse && loginResponse !== "undefined") {
        var data = JSON.parse(loginResponse);
        function handleLoginForm(data ,step, id_form, tab_step){
            if(data !== "undefined"){
                if(data.steps == step){
                    idLead = data.id;
                    $('#lead_profile_code').html(data.code);
                    $('#lead_full_name').html(data.full_name);
                    if (data.gender == 0) {
                        $('#lead_gender').html("Nữ");
                    } else if (data.gender == 1){
                        $('#lead_gender').html("Nam");
                    } else {
                        $('#lead_gender').html("Khác");
                    }
                    $('#lead_major').html(data.marjors);

                    $('#myForm1').hide();
                    $(id_form).show();
                    $('#banner-welcome').hide();
                    $('#banner-lead').show();
                    $('#tab-step-1').removeClass('active-tab');
                    $(tab_step).addClass('active-tab');
                    if(step == 6){
                        $('#tab-container').css('visibility', 'hidden');
                        $('button-view-info').removeClass('hidden_button');
                    }
                }
            }
        }
        handleLoginForm(data, 1, '#myForm2', '#tab-step-2');
        handleLoginForm(data, 2, '#myForm3', '#tab-step-3');
        handleLoginForm(data, 3, '#myForm4', '#tab-step-4');
        handleLoginForm(data, 4, '#myForm5', '#tab-step-5');
        handleLoginForm(data, 5, '#myForm6', '#tab-step-6');
        handleLoginForm(data, 6, '#step_final', '#tab-step-6');
    }

    $('#btn-register-lead').on('click', ()=>{
        localStorage.removeItem('data');
    })


    // --- Show and hide Admission method --- \\
    // $('#school-scoreboard-content').hide();

    // $('input[name="admission-method"]').change(function() {
    //     if ($('#radio-2-f5').is(':checked')) {
    //         $('#school-records-content').show();
    //         $('#school-scoreboard-content').hide();
    //     } else if ($('#radio-3-f5').is(':checked')) {
    //         $('#school-scoreboard-content').show();
    //         $('#school-records-content').hide();
    //     }
    // });

    // --- Change select to search select --- \\
    $('#placeOfBirth').select2(); 
    $('#placeOfWorkLearn').select2(); 

    // --- remove error effect when click input --- \\
    handleRemoveError('#email-wrapper', '#email');
    handleRemoveError('#fullname-wrapper', '#fullname');
    handleRemoveError('#dateOfBirth-wrapper', '#dateOfBirth');
    handleRemoveError('#gender-wrapper', '#gender');
    handleRemoveError('#phone-wrapper', '#phone');
    handleRemoveError('#identificationCard-wrapper', '#identificationCard');
    handleRemoveError('#placeOfBirth-wrapper', '.select2-selection');
    handleRemoveError('#placeOfWorkLearn-wrapper', '.select2-selection');
    // handleRemoveError('#placeOfWorkLearn-wrapper', '#placeOfWorkLearn');
    handleRemoveError('#source-wrapper', '#source');
    handleRemoveError('#marjor-wrapper', '#marjor');

    $('.avatar-wrapper #avatar-upload').on('click', function(){
        $('.avatar-wrapper .error-input').removeClass('show-error').html('');
        $('.avatar-wrapper #avatar-preview').removeClass('border-error');
    });
    handleRemoveError('#date_of_birth_f2_wrapper', '#date_of_birth_f2');
    handleRemoveError('#place_of_birth_f2_wrapper', '#place_of_birth_f2');
    handleRemoveError('#nations_name_wrapper', '#nations_name');
    handleRemoveError('#ethnics_name_wrapper', '#ethnics_name');
    handleRemoveError('#identification_card_f2_wrapper', '#identification_card_f2');
    handleRemoveError('#date_identification_card_wrapper', '#date_identification_card');
    handleRemoveError('#place_identification_card_wrapper', '#place_identification_card');
    handleRemoveError('.type_id_tdvh_wrapper', '.type_id_tdvh');
    handleRemoveError('.year_of_degree_1_wrapper', '#year_of_degree_1');
    handleRemoveError('.serial_number_degree_1_wrapper', '#serial_number_degree_1');
    handleRemoveError('.date_of_degree_1_wrapper', '#date_of_degree_1');
    handleRemoveError('.place_of_degree_1_wrapper', '#place_of_degree_1');
    handleRemoveError('.year_of_degree_2_wrapper', '#year_of_degree_2');
    handleRemoveError('.serial_number_degree_2_wrapper', '#serial_number_degree_2');
    handleRemoveError('.date_of_degree_2_wrapper', '#date_of_degree_2');
    handleRemoveError('.place_of_degree_2_wrapper', '#place_of_degree_2');

    handleRemoveError('#provinces_name_1_wrapper', '#provinces_name_1');
    handleRemoveError('#provinces_name_2_wrapper', '#provinces_name_2');
    handleRemoveError('#districts_name_1_wrapper', '#districts_name_1');
    handleRemoveError('#districts_name_2_wrapper', '#districts_name_2');
    handleRemoveError('#wards_name_1_wrapper', '#wards_name_1');
    handleRemoveError('#wards_name_2_wrapper', '#wards_name_2');
    handleRemoveError('#address_1_wrapper', '#address_1');
    handleRemoveError('#address_2_wrapper', '#address_2');

    handleRemoveError('#father_full_name_wrapper', '#father_full_name');
    handleRemoveError('#father_phone_wrapper', '#father_phone');
    handleRemoveError('#mother_full_name_wrapper', '#mother_full_name');
    handleRemoveError('#mother_phone_wrapper', '#mother_phone');
    handleRemoveError('#father_yearOfBirth_wrapper', '#father_yearOfBirth');
    handleRemoveError('#father_education_wrapper', '#father_education');
    handleRemoveError('#mother_yearOfBirth_wrapper', '#mother_yearOfBirth');
    handleRemoveError('#mother_education_wrapper', '#mother_education');

    // form 5 \\
    $('#provinces_name_f5_1_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#provinces_name_f5_1').removeClass('border-error');
    });

    $('#school_name_1_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#school_name_1').removeClass('border-error');
    });

    $('#marjor_f5_1_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#marjor_f5_1').removeClass('border-error');
    });

    $('#block_adminssions_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#block_adminssions').removeClass('border-error');
    });

    $('#provinces_name_f5_2_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#provinces_name_f5_2').removeClass('border-error');
    });

    $('#school_name_2_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#school_name_2').removeClass('border-error');
    });

    $('#marjor_f5_2_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#marjor_f5_2').removeClass('border-error');
    });

    $('#average_score_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#average_score').removeClass('border-error');
    });

    $('#score-1').on('click', function() {
        $('#score-error-1').removeClass('show-error');
    });
    $('#score-2').on('click', function() {
        $('#score-error-2').removeClass('show-error');
    });
    $('#score-3').on('click', function() {
        $('#score-error-3').removeClass('show-error');
    });

    function formatDate(inputDate) {
        const dateObj = new Date(inputDate);
        
        if (isNaN(dateObj.getTime())) {
            return null;
        }
    
        const day = String(dateObj.getDate()).padStart(2, '0'); 
        const month = String(dateObj.getMonth() + 1).padStart(2, '0'); 
        const year = dateObj.getFullYear();
    
        return `${day}/${month}/${year}`;
    }

    // --- handle submit form 1 --- \\
    $(document).on('submit', '#myForm1', function(e) {
        e.preventDefault();
        $('.screen-loading').show();

        let email               = $('#email').val();
        let fullname            = $('#fullname').val();
        let dateOfBirth         = formatDate($('#dateOfBirth').val());
        let gender              = $('#gender').val();
        let phone               = $('#phone').val();
        let identificationCard  = $('#identificationCard').val();
        let placeOfBirth        = $('#placeOfBirth').val();
        let placeOfWorkLearn    = $('#placeOfWorkLearn').val();
        let source              = $('#source').val();
        let marjor              = $('#marjor').val();
          
        $.ajax({
            url: baseUrl + registerLeadApi,
            method: 'POST',
            data: {
                "email"                 : email,
                "full_name"             : fullname,
                "date_of_birth"         : dateOfBirth,
                "gender"                : gender,
                "phone"                 : phone,
                "identification_card"   : identificationCard,
                "place_of_birth"        : placeOfBirth,
                "place_of_wrk_lrn"      : placeOfWorkLearn,
                "sources_id"            : source,
                "marjors_id"            : marjor,
                // "types"                 : 0
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                let data = response.data;

                if(data){
                    if(response.code == 422){
                        handleError('#email', '#email-wrapper', data.email);
                        handleError('#fullname', '#fullname-wrapper', data.full_name);
                        handleError('#dateOfBirth', '#dateOfBirth-wrapper', data.date_of_birth);
                        handleError('#gender', '#gender-wrapper', data.gender);
                        handleError('#phone', '#phone-wrapper', data.phone);
                        handleError('#identificationCard', '#identificationCard-wrapper', data.identification_card);
                        handleError('#placeOfBirth-wrapper .select2-selection', '#placeOfBirth-wrapper', data.place_of_birth);
                        handleError('#placeOfWorkLearn-wrapper .select2-selection', '#placeOfWorkLearn-wrapper', data.place_of_wrk_lrn);
                        // handleError('#placeOfWorkLearn', '#placeOfWorkLearn-wrapper', data.place_of_wrk_lrn);
                        handleError('#source', '#source-wrapper', data.sources_id);
                        handleError('#marjor', '#marjor-wrapper', data.marjors_id);

                        $('.screen-loading').hide();
                    }

                    if(response.code == 200){
                        idLead = response.data.id
                        $('#lead_profile_code').html(data.code);
                        $('#lead_full_name').html(data.full_name);
                        if (data.gender == 0) {
                            $('#lead_gender').html("Nữ");
                        } else if (data.gender == 1){
                            $('#lead_gender').html("Nam");
                        } else {
                            $('#lead_gender').html("Khác");
                        }
                        $('#lead_major').html(data.marjors);

                        $('.screen-loading').hide();
                        $('#myForm1').hide();
                        $('#myForm2').show();
                        $('#banner-welcome').hide();
                        $('#banner-lead').show();
                        $('#tab-step-1').removeClass('active-tab');
                        $('#tab-step-2').addClass('active-tab');

                        localStorage.removeItem('data');
                        localStorage.setItem('data', JSON.stringify(response.data));
                    }
                }
            },
            error: function (xhr, status, error) {
                $('.screen-loading').hide();
                $.notify('Có lỗi xảy ra: ' + xhr.responseText, "error");                
            }
        });
    });

    // --- handle submit form 2 --- \\
    $(document).on('change', '#avatar-upload', function(e){
        var file = e.target.files[0];
        let api = baseUrl + uploadAvatar + idLead;
        // const api = baseUrl + uploadAvatar + "93";

        $(".avatar-wrapper").find(".error-input").html("Đang tải ảnh lên, vui lòng chờ chút").show();

        if (file) {
            var formData = new FormData();
            formData.append('image', file);

            $.ajax({
                url: api,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.code === 200) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#avatar-preview').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);

                        imgUrl = response.data.image_url;

                        $(".avatar-wrapper").find(".error-input").html("Tải lên thành công");
                        setTimeout(function() {
                            $(".avatar-wrapper").find(".error-input").hide();
                        }, 4000);
                    } else {                                                
                        $.notify('Có lỗi xảy ra: ' + (response.data.image[0] || 'Không rõ lỗi'), "error");  
                        $(".avatar-wrapper").find(".error-input").html("Đang tải ảnh lên, vui lòng chờ chút").hide();
                    }
                },
                error: function(xhr, status, error) {
                    $.notify('Có lỗi xảy ra: ' + (xhr.responseText || error) , "error");                    
                }
            });
        } else {
            $.notify('Vui lòng chọn một tệp để tải lên.' , "error");   
            
        }
    });

    $(document).on('submit', '#myForm2', function(e){
        e.preventDefault();
        $('.screen-loading').show();
        const api = baseUrl + infomationProfile + idLead;
        // const api = baseUrl + infomationProfile + "52";

        let date_of_birth                   = $("#date_of_birth_f2").val() ? formatdate($("#date_of_birth_f2").val()) : "";
        let place_of_birth                  = $("#place_of_birth_f2").val();
        let nations_name                    = $("#nations_name").val();
        let ethnics_name                    = $("#ethnics_name").val();
        let identification_card             = $("#identification_card_f2").val();
        let date_identification_card        = $("#date_identification_card").val() ? formatdate($("#date_identification_card").val()) : "";
        let place_identification_card       = $("#place_identification_card").val();
        let date_of_join_youth_union        = $("#date_of_join_youth_union").val() ? formatdate($("#date_of_join_youth_union").val()) : "";
        let date_of_join_communist_party    = $("#date_of_join_communist_party").val() ? formatdate($("#date_of_join_communist_party").val()) : "";
        let email                           = $("#email_f2").val();
        let company_name                    = $("#company_name").val();
        let company_address                 = $("#company_address").val();

        let type_id_1                       = $("#type_id_1").val();
        let year_of_degree_1                = $("#year_of_degree_1").val();
        let date_of_degree_1                = $("#date_of_degree_1").val() ? formatdate($("#date_of_degree_1").val()) : "";
        let serial_number_degree_1          = $("#serial_number_degree_1").val();
        let place_of_degree_1               = $("#place_of_degree_1").val();

        let type_id_2                       = $('input[name="type_id_2"]:checked').val();
        let year_of_degree_2                = $("#year_of_degree_2").val();
        let date_of_degree_2                = $("#date_of_degree_2").val() ? formatdate($("#date_of_degree_2").val()) : "";
        let serial_number_degree_2          = $("#serial_number_degree_2").val();
        let place_of_degree_2               = $("#place_of_degree_2").val();

        data = {
            avatar                      : imgUrl,
            date_of_birth               : date_of_birth,
            place_of_birth              : place_of_birth,
            nations_name                : nations_name,
            ethnics_name                : ethnics_name,
            identification_card         : identification_card,
            date_identification_card    : date_identification_card,
            place_identification_card   : place_identification_card,
            date_of_join_youth_union    : date_of_join_youth_union,
            date_of_join_communist_party: date_of_join_communist_party,
            email                       : email,
            company_name                : company_name,
            company_address             : company_address,
            title_tdvh                  : "tdvh",
            type_id_tdvh                : type_id_1,
            year_of_degree_tdvh         : year_of_degree_1,
            date_of_degree_tdvh         : date_of_degree_1,
            serial_number_degree_tdvh   : serial_number_degree_1,
            place_of_degree_tdvh        : place_of_degree_1,
            title_tdcm                  : "tdcm",
            type_id_tdcm                : type_id_2,
            year_of_degree_tdcm         : year_of_degree_2,
            date_of_degree_tdcm         : date_of_degree_2,
            serial_number_degree_tdcm   : serial_number_degree_2,
            place_of_degree_tdcm        : place_of_degree_2
        }
        let convertData = JSON.stringify(data);

        $.ajax({
            url: api,
            type: 'POST',
            data: convertData,
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                let data = response.data;

                if(response.code == 422){
                    handleError('.avatar-wrapper #avatar-preview', '.avatar-wrapper', data.avatar);
                    handleError('#date_of_birth_f2', '#date_of_birth_f2_wrapper', data.date_of_birth);
                    handleError('#place_of_birth_f2', '#place_of_birth_f2_wrapper', data.place_of_birth);
                    handleError('#nations_name', '#nations_name_wrapper', data.nations_name);
                    handleError('#ethnics_name', '#ethnics_name_wrapper', data.ethnics_name);
                    handleError('#identification_card_f2', '#identification_card_f2_wrapper', data.identification_card);
                    handleError('#date_identification_card', '#date_identification_card_wrapper', data.date_identification_card);
                    handleError('#place_identification_card', '#place_identification_card_wrapper', data.place_identification_card);

                    handleError('.type_id_tdvh', '.type_id_tdvh_wrapper', data.type_id_tdvh);
                    handleError('#year_of_degree_1', '.year_of_degree_1_wrapper', data.year_of_degree_tdvh);
                    handleError('#serial_number_degree_1', '.serial_number_degree_1_wrapper', data.serial_number_degree_tdvh);
                    handleError('#date_of_degree_1', '.date_of_degree_1_wrapper', data.date_of_degree_tdvh);
                    handleError('#place_of_degree_1', '.place_of_degree_1_wrapper', data.place_of_degree_tdvh);

                    handleError('#year_of_degree_2', '.year_of_degree_2_wrapper', data.year_of_degree_tdcm);
                    handleError('#serial_number_degree_2', '.serial_number_degree_2_wrapper', data.serial_number_degree_tdcm);
                    handleError('#date_of_degree_2', '.date_of_degree_2_wrapper', data.date_of_degree_tdcm);
                    handleError('#place_of_degree_2', '.place_of_degree_2_wrapper', data.place_of_degree_tdcm);

                    $('.screen-loading').hide();
                }

                if(response.code == 200){
                    $('.screen-loading').hide();
                    $('#myForm2').hide();
                    $('#myForm3').show();
                    $('#tab-step-2').removeClass('active-tab');
                    $('#tab-step-3').addClass('active-tab');
                }
            },
            error: function(xhr, status, error) {
                $('.screen-loading').hide();                
                $.notify('Có lỗi xảy ra: ' + (xhr.responseText || error) , "error");     
            }
        })
    })

    $('#prevStep2').on('click', function() {
        $('#myForm2').hide();
        $('#myForm1').show();
        $('#tab-step-2').removeClass('active-tab');
        $('#tab-step-1').addClass('active-tab');
        $('#banner-welcome').show();
        $('#banner-lead').hide();
        $('.btn_next_form').removeClass('hidden_button');
        $('.btn_register_f1').addClass('hidden_button');
    });

    $('.btn_next_form').on('click', function(){
        $('.screen-loading').hide();
        $('#myForm1').hide();
        $('#myForm2').show();
        $('#banner-welcome').hide();
        $('#banner-lead').show();
        $('#tab-step-1').removeClass('active-tab');
        $('#tab-step-2').addClass('active-tab');
    })

    // --- handle submit form 3 --- \\
    $(document).on('submit', '#myForm3', function(e){
        e.preventDefault();
        $('.screen-loading').show();

        const api = baseUrl + contactsApi + idLead;
        // const api = baseUrl + contactsApi + "15";

        let provinces_name_1    = $("#provinces_name_1").val();
        let districts_name_1    = $("#districts_name_1").val();
        let wards_name_1        = $("#wards_name_1").val();
        let address_1           = $("#address_1").val();

        let provinces_name_2    = $("#provinces_name_2").val();
        let districts_name_2    = $("#districts_name_2").val();
        let wards_name_2        = $("#wards_name_2").val();
        let address_2           = $("#address_2").val();

        data = {
            title_hktt          : "HKTT",
            provinces_name_hktt : provinces_name_1,
            districts_name_hktt : districts_name_1,
            wards_name_hktt     : wards_name_1,
            address_hktt        : address_1,
            title_dcll          : "DCLL",
            provinces_name_dcll : provinces_name_2,
            districts_name_dcll : districts_name_2,
            wards_name_dcll     : wards_name_2,
            address_dcll        : address_2
        }
        let convertData = JSON.stringify(data);

        $.ajax({
            url: api,
            type: 'POST',
            data: convertData,
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                let data = response.data;

                if(response.code == 422){
                    $('.screen-loading').hide();

                    handleError('#provinces_name_1', '#provinces_name_1_wrapper', data.provinces_name_hktt);
                    handleError('#districts_name_1', '#districts_name_1_wrapper', data.districts_name_hktt);
                    handleError('#wards_name_1', '#wards_name_1_wrapper', data.wards_name_hktt);
                    handleError('#address_1', '#address_1_wrapper', data.address_hktt);

                    handleError('#provinces_name_2', '#provinces_name_2_wrapper', data.provinces_name_dcll);
                    handleError('#districts_name_2', '#districts_name_2_wrapper', data.districts_name_dcll);
                    handleError('#wards_name_2', '#wards_name_2_wrapper', data.wards_name_dcll);
                    handleError('#address_2', '#address_2_wrapper', data.address_dcll);
                } else {
                    $('.screen-loading').hide();
                    $('#myForm3').hide();
                    $('#myForm4').show();
                    $('#tab-step-3').removeClass('active-tab');
                    $('#tab-step-4').addClass('active-tab');
                }
            },
            error: function(xhr, status, error){
                $('.screen-loading').hide();                
                $.notify('Có lỗi xảy ra: ' + (xhr.responseText || error) , "error");     
            }
        })

    })

    $('#prevStep3').on('click', function() {
        $('#myForm3').hide();
        $('#myForm2').show();
        $('#tab-step-3').removeClass('active-tab');
        $('#tab-step-2').addClass('active-tab');
    });

    // --- handle submit form 4 --- \\
    $(document).on('submit', '#myForm4', function(e){
        e.preventDefault();
        $('.screen-loading').show();

        const api = baseUrl + familyApi + idLead;
        // const api = baseUrl + familyApi + "88";

        let full_name_father        = $('#father_full_name').val();
        let phone_number_father     = $('#father_phone').val();
        let year_of_birth_father    = parseInt($('#father_yearOfBirth').val());
        let jobs_father             = $('#father_job').val();
        let education_id_father     = parseInt($('#father_education').val());

        let full_name_mother        = $('#mother_full_name').val();
        let phone_number_mother     = $('#mother_phone').val();
        let year_of_birth_mother    = parseInt($('#mother_yearOfBirth').val());
        let jobs_mother             = $('#mother_job').val();
        let education_id_mother     = parseInt($('#mother_education').val());

        let full_name_wife          = $('#name_wifeOrHusband').val();
        let phone_number_wife       = $('#phone_wifeOrHusband').val();
        let year_of_birth_wife      = parseInt($('#yearOfBirth_wifeOrHusband').val());
        let jobs_wife               = $('#job_wifeOrHusband').val();
        let education_id_wife       = parseInt($('#wifeOrHusband_education').val());

        data = {
            title_father            : "Cha",
            full_name_father        : full_name_father,
            phone_number_father     : phone_number_father,
            year_of_birth_father    : year_of_birth_father,
            jobs_father             : jobs_father,
            education_id_father     : education_id_father,
            title_mother            : "Mẹ",
            full_name_mother        : full_name_mother,
            phone_number_mother     : phone_number_mother,
            year_of_birth_mother    : year_of_birth_mother,
            jobs_mother             : jobs_mother,
            education_id_mother     : education_id_mother,
            title_wife              : "Vợ",
            full_name_wife          : full_name_wife,
            phone_number_wife       : phone_number_wife,
            year_of_birth_wife      : year_of_birth_wife,
            jobs_wife               : jobs_wife,
            education_id_wife       : education_id_wife
        }
        let convertData = JSON.stringify(data);

        $.ajax({
            url: api,
            type: 'POST',
            data: convertData,
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                let data = response.data;

                if(response.code == 422){
                    $('.screen-loading').hide();

                    handleError('#father_full_name', '#father_full_name_wrapper', data.full_name_father);
                    handleError('#father_phone', '#father_phone_wrapper', data.phone_number_father);

                    handleError('#mother_full_name', '#mother_full_name_wrapper', data.full_name_mother);
                    handleError('#mother_phone', '#mother_phone_wrapper', data.phone_number_mother);

                    handleError('#name_wifeOrHusband', '#name_wifeOrHusband_wrapper', data.full_name_wife);
                    handleError('#phone_wifeOrHusband', '#phone_wifeOrHusband_wrapper', data.phone_number_wife);

                    handleError('#father_yearOfBirth', '#father_yearOfBirth_wrapper', data.year_of_birth_father);
                    handleError('#father_education', '#father_education_wrapper', data.education_id_father);

                    handleError('#mother_yearOfBirth', '#mother_yearOfBirth_wrapper', data.year_of_birth_mother);
                    handleError('#mother_education', '#mother_education_wrapper', data.education_id_mother);
                } else {
                    $('.screen-loading').hide();
                    $('#myForm4').hide();
                    $('#myForm5').show();
                    $('#tab-step-4').removeClass('active-tab');
                    $('#tab-step-5').addClass('active-tab');
                }
            },
            error: function(xhr, status, error){
                $('.screen-loading').hide();
                $.notify('Có lỗi xảy ra: ' + (xhr.responseText || error) , "error");     
            }
        })
    })

    $('#prevStep4').on('click', function() {
        $('#myForm4').hide();
        $('#myForm3').show();
        $('#tab-step-4').removeClass('active-tab');
        $('#tab-step-3').addClass('active-tab');
    });

    // --- handle submit form 5 --- \\
    $(document).on('submit', '#myForm5', function(e){
        e.preventDefault();
        $('.screen-loading').show();

        const api = baseUrl + scoreApi + idLead;
        // const api = baseUrl + scoreApi + "91";

        let form_adminssions_id = parseInt($('input[name="admission-system"]:checked').val());
        let method_adminssions_id = parseInt($('input[name="admission-method"]:checked').val());

        let province_name_1 = $('#provinces_name_f5_1').val();
        let school_name_1 = $('#school_name_1').val();
        let marjors_id_1 = parseInt($('#marjor_f5_1').val());
        let block_adminssions_id = parseInt($('#block_adminssions').val());
        let score1 = parseFloat($('#score-1').val());
        let score2 = parseFloat($('#score-2').val());
        let score3 = parseFloat($('#score-3').val());

        let province_name_2 = $('#provinces_name_f5_2').val();
        let school_name_2 = $('#school_name_2').val();
        let marjors_id_2 = parseInt($('#marjor_f5_2').val());
        let averageScore2 = $('#average_score_2').val();
        let point_gpa_2 = $('#point_gpa_2').val();

        let dataCount = $('input[name="admission-method"]:checked').attr('data-count');
        // $(document).on('change', '.admission-method-radio', function() {
        //     dataCount = $(this).attr('data-count');
        // });
        let province_name_3 = $('#provinces_name_f5_3').val();
        let school_name_3 = $('#school_name_3').val();
        let marjors_id_3 = parseInt($('#marjor_f5_3').val());
        let averageScore3 = $('#average_score_3').val();
        let point_gpa_3 = $('#point_gpa_3').val();

        if(dataCount == 1){
            data = {
                form_adminssions_id : form_adminssions_id,
                method_adminssions_id : method_adminssions_id,
                province_name : "Thành phố Hồ Chí Minh",
                school_name : "Trường 1",
                marjors_id : marjors_id_1,
                score_avg : "",
                block_adminssions_id : block_adminssions_id,
                score1 : score1,
                score2 : score2,
                score3 : score3
            };
        } else if(dataCount == 2){
            data = {
                form_adminssions_id : form_adminssions_id,
                method_adminssions_id : method_adminssions_id,
                province_name : "Thành phố Hồ Chí Minh",
                school_name : "Trường 1",
                marjors_id : marjors_id_2,
                score_avg : averageScore2,
                point_gpa: point_gpa_2
            };
        } else if(dataCount == 3){
            data = {
                form_adminssions_id : form_adminssions_id,
                method_adminssions_id : method_adminssions_id,
                province_name : "Thành phố Hồ Chí Minh",
                school_name : "Trường 1",
                marjors_id : marjors_id_3,
                score_avg : averageScore3,
                point_gpa: point_gpa_3
            };
        }  
        let convertData = JSON.stringify(data);

        $.ajax({
            url: api,
            type: 'POST',
            data: convertData,
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                let data = response.data;

                if(response.code == 422){
                    if(dataCount == 1){
                        handleError('#provinces_name_f5_1', '#provinces_name_f5_1_wrapper', data.province_name);
                        handleError('#school_name_1', '#school_name_1_wrapper', data.school_name);
                        handleError('#marjor_f5_1', '#marjor_f5_1_wrapper', data.marjors_id);
                        handleError('#block_adminssions', '#block_adminssions_wrapper', data.block_adminssions_id);

                        if(data.score1 != null){
                            $('#score-error-1').addClass('show-error').html(data.score1)
                        }
                        if(data.score2 != null){
                            $('#score-error-2').addClass('show-error').html(data.score2)
                        }
                        if(data.score3 != null){
                            $('#score-error-3').addClass('show-error').html(data.score3)
                        }
                        $('.screen-loading').hide();
                        
                    } else if(dataCount == 2) {
                        handleError('#provinces_name_f5_2', '#provinces_name_f5_2_wrapper', data.province_name);
                        handleError('#school_name_2', '#school_name_2_wrapper', data.school_name);
                        handleError('#marjor_f5_2', '#marjor_f5_2_wrapper', data.marjors_id);
                        handleError('#average_score_2', '#average_score_2_wrapper', data.score_avg);
                        handleError('#point_gpa_2', '#point_gpa_2_wrapper', data.point_gpa);
                        $('.screen-loading').hide();
                    } else if(dataCount == 3) {
                        handleError('#provinces_name_f5_3', '#provinces_name_f5_3_wrapper', data.province_name);
                        handleError('#school_name_3', '#school_name_3_wrapper', data.school_name);
                        handleError('#marjor_f5_3', '#marjor_f5_3_wrapper', data.marjors_id);
                        handleError('#average_score_3', '#average_score_3_wrapper', data.score_avg);
                        handleError('#point_gpa_3', '#point_gpa_3_wrapper', data.point_gpa);
                        $('.screen-loading').hide();
                    }
                } else {
                    $('.screen-loading').hide();
                    $('#myForm5').hide();
                    $('#myForm6').show();
                    $('#tab-step-5').removeClass('active-tab');
                    $('#tab-step-6').addClass('active-tab');
                    $('.button-view-info').removeClass('hidden_button');
                    $("#preview_file_register").attr("href", baseUrl+"/view_application_form/"+idLead);
                }
            },
            error: function(xhr, status, error){
                $('.screen-loading').hide();
                $.notify('Có lỗi xảy ra: ' + (xhr.responseText || error) , "error");     
            }
        })
    })
    handleRemoveError('#average_score_2_wrapper','#average_score_2');
    handleRemoveError('#point_gpa_2_wrapper','#point_gpa_2');

    handleRemoveError('#provinces_name_f5_3_wrapper','#provinces_name_f5_3');
    handleRemoveError('#school_name_3_wrapper','#school_name_3');
    handleRemoveError('#marjor_f5_3_wrapper','#marjor_f5_3');
    handleRemoveError('#average_score_3_wrapper','#average_score_3');
    handleRemoveError('#point_gpa_3_wrapper','#point_gpa_3');

    $('#prevStep5').on('click', function() {
        $('#myForm5').hide();
        $('#myForm4').show();
        $('#tab-step-5').removeClass('active-tab');
        $('#tab-step-4').addClass('active-tab');
    });

    let $fileInput = $('#input-upload-f6');
    const $uploadWrapper = $('.upload-img-wrapper');
    let uploadedFiles = []; // Mảng lưu thông tin file đã upload

    // Xử lý khi chọn file
    // $fileInput.on('change', function() {
    //     const files = this.files;
    //     if (files.length > 0) {
    //         $.each(files, function(index, file) {
    //             const mimeType = file.type;
    //             const allowedMimeTypes = [
    //                 'image/png', 'image/jpeg', 'image/jpg', // Ảnh
    //                 'application/pdf',                     // PDF
    //                 'application/zip', 'application/x-zip-compressed', // ZIP
    //                 'application/x-rar-compressed'         // RAR
    //             ];

    //             // Kiểm tra loại file
    //             if (!allowedMimeTypes.includes(mimeType)) {
    //                 alert(`File ${file.name} không được hỗ trợ. Chỉ chấp nhận ảnh, PDF, ZIP, RAR.`);
    //                 return true; // Tiếp tục vòng lặp
    //             }

    //             // Kiểm tra file đã tồn tại chưa (dựa trên tên và kích thước)
    //             const fileIdentifier = `${file.name}-${file.size}`;
    //             if (uploadedFiles.includes(fileIdentifier)) {
    //                 alert(`File ${file.name} đã được upload trước đó.`);
    //                 return true; // Bỏ qua file trùng
    //             }

    //             // Tạo phần tử preview
    //             const $previewItem = $('<div>').addClass('preview-item');

    //             if (mimeType.startsWith('image/')) {
    //                 // Hiển thị ảnh xem trước
    //                 const reader = new FileReader();
    //                 reader.onload = function(e) {
    //                     const $img = $('<img>').attr('src', e.target.result);
    //                     $previewItem.append($img);
    //                     addRemoveButton($previewItem, fileIdentifier);
    //                     uploadedFiles.push(fileIdentifier); // Thêm vào danh sách đã upload
    //                 };
    //                 reader.readAsDataURL(file);
    //             } else {
    //                 // Hiển thị tên file cho PDF, ZIP, RAR
    //                 const $fileName = $('<span>').addClass('file-name').text(file.name);
    //                 $previewItem.append($fileName);
    //                 addRemoveButton($previewItem, fileIdentifier);
    //                 uploadedFiles.push(fileIdentifier); // Thêm vào danh sách đã upload
    //             }

    //             // Thêm preview vào wrapper (trước fileUpload)
    //             $uploadWrapper.find('.fileUpload').before($previewItem);
    //         });
    //     }
    // });

    // function addRemoveButton($previewItem, fileIdentifier) {
    //     const $removeBtn = $('<button>').addClass('remove-btn').text('X');
    //     $removeBtn.on('click', function() {
    //         $previewItem.remove();
    //         // Xóa file khỏi danh sách uploadedFiles
    //         const index = uploadedFiles.indexOf(fileIdentifier);
    //         if (index > -1) {
    //             uploadedFiles.splice(index, 1);
    //         }
    //     });
    //     $previewItem.append($removeBtn);
    // }

    $(".btn_add_input_upload").on("click", function () {
        $(".upload").removeClass("input_lastest");
        let newFileUpload = `
            <div class="fileUpload">
                <input name="images[]" type="file" class="upload input_lastest" accept="image/*,.zip,.rar,.pdf"/>
                <span class="file-preview" style="text-align: center;font-size: 14px;">
                    Nhấn vào đây để tải file
                </span>
                <button type="button" class="btn_remove_upload"><i class="fa fa-times"></i></button>
            </div>
        `;
        $(this).before(newFileUpload);
        $(`.input_lastest`).click();
    });

    // Xóa fileUpload khi nhấn vào nút xóa
    $(document).on("click", ".btn_remove_upload", function () {
        $(this).closest(".fileUpload").remove();
    });

    let arrfile = [];
    $(document).on("change", ".upload", function () {
        let input = this;
        let file = input.files[0];
        let previewContainer = $(this).siblings(".file-preview");
    
        // Danh sách đuôi file hợp lệ
        let validExtensions = ["jpg", "jpeg", "png", "gif", "zip", "rar", "pdf"];
    
        if (file) {
            let fileName = file.name.toLowerCase();
            let fileExt = fileName.split('.').pop(); // Lấy phần mở rộng của file
    
            // Kiểm tra xem file có phải là 1 trong các định dạng hợp lệ không
            if (!validExtensions.includes(fileExt)) {
                alert("Chỉ được phép tải lên các file ảnh, ZIP, RAR hoặc PDF!");
                $(this).val(""); // Xóa file đã chọn
                previewContainer.html(`<img src="/assets/image/img-example.png" alt="Preview">`);
                return;
            }
    
            // Nếu file hợp lệ, thêm vào mảng
            arrfile.push(file);
            let reader = new FileReader();
    
            if (fileExt.match(/(jpg|jpeg|png|gif)/)) {
                // Nếu là ảnh, hiển thị preview
                reader.onload = function (e) {
                    previewContainer.html(`<img src="${e.target.result}" alt="Preview">`);
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu không phải ảnh, hiển thị tên file
                previewContainer.html(`<span class="file-name">${file.name}</span>`);
            }
        } else {
            // Nếu không có file, hiển thị ảnh mặc định
            previewContainer.html(`<img src="/assets/image/img-example.png" alt="Preview">`);
        }
    });

    $(document).on('submit', '#myForm6', function(e) {
        e.preventDefault();
        $('.screen-loading').show();
    
        const api = baseUrl + confirmApi + idLead;
        // const api = baseUrl + confirmApi + "56";
        const formData = new FormData(this);

        if (arrfile.length) {
            $.ajax({
                url: api,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code == 200) {
                        $('.screen-loading').hide();
                        $('#myForm6').hide();
                        $('#step_final').show();
                        $('#tab-container').css('visibility', 'hidden');
                        checkStatusStudent();
                    } else {
                        $('.screen-loading').hide();
                        $.notify('Đã xảy ra lỗi, vui lòng thử lại!', "error");
                    }
                },
                error: function (xhr, status, error) {
                    $('.screen-loading').hide();
                    $.notify('Có lỗi xảy ra: Quá dung lượng cho phép. Vui lòng tải lại.', "error");
                }
            });
        } else {
            $('.screen-loading').hide();
            $.notify('Vui lòng tải các file yêu cầu', "error");
        }
    });

    $('#prevStep6').on('click', function() {
        $('#myForm6').hide();
        $('#myForm5').show();
        $('#tab-step-6').removeClass('active-tab');
        $('#tab-step-5').addClass('active-tab');
    });

    // ------------ Validate upload file ----------------- \\
    $("#support-file").on("change", function () {
        let files = this.files;
        let allowedTypes = {
            "image/jpeg": "JPG, JPEG",
            "image/png": "PNG",
            "image/gif": "GIF",
            "application/pdf": "PDF",
            // "application/vnd.ms-excel": "XLS",
            // "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": "XLSX",
            "application/zip": "ZIP",
            "application/x-zip-compressed": "ZIP",
            "application/x-rar": "RAR",
            "application/x-rar-compressed": "RAR",
            "application/octet-stream": "RAR, ZIP" // Thêm để xử lý MIME type không chuẩn
        };
    
        let allowedExtensions = [".jpg", ".jpeg", ".png", ".gif", ".pdf", ".zip", ".rar"];
        let invalidFiles = [];
    
        for (let i = 0; i < files.length; i++) {
            const fileType = files[i].type;
            const fileName = files[i].name.toLowerCase();
            const fileExtension = "." + fileName.split('.').pop();
    
            // Kiểm tra MIME type hoặc phần mở rộng
            if (!allowedTypes.hasOwnProperty(fileType) && !allowedExtensions.includes(fileExtension)) {
                invalidFiles.push(files[i].name);
            }
        }
    
        if (invalidFiles.length > 0) {
            alert("Các file không hợp lệ: " + invalidFiles.join(", ") +
                  "\nChỉ chấp nhận các loại: " + Object.values(allowedExtensions).join(", "));
            $(this).val(""); // Xóa file nếu có file không hợp lệ
        } else {
            const fileName = $(this).prop('files')[0].name;
            $('.placeholder-text').text(fileName);
            $('.upload-icon').hide();
            $('.delete-icon').show();
        }
    });

    $(document).on('click', '.upload-icon', ()=>{
        $("#support-file").click();
    })

    $(document).on('click', '.delete-icon', ()=>{
        $("#support-file").val('');
        $('.support-file-input .placeholder-text').html('Tải lên');
        $('.upload-icon').show();
        $('.delete-icon').hide();
    })

    // ----- handle form support ----- \\
    $(document).on('submit', '#form-support', function(e){
        e.preventDefault();
        $('.support-submit-wrapper .support-btn-text').hide();
        $('.support-submit-wrapper .support-loader').show();

        const api           = baseUrl + supportApi;
        let full_name       = $('#support-fullname').val();
        let email           = $('#support-email').val();
        let phone           = $('#support-phone').val();
        let descriptions    = $('#support-question').val();
        const TYPE_LEAD     = 0;
        let formData        = new FormData();

        formData.append('subject', "Form hỗ trợ");
        formData.append('full_name', full_name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('descriptions', descriptions);
        formData.append('types', TYPE_LEAD);
        formData.append('priority_level', 1);
        let fileInput = $("#support-file")[0]; 
        if (fileInput.files.length > 0) {
            let file = fileInput.files[0];
            formData.append('File', file);
        }

        $.ajax({
            url: api,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                let data = response.data;
                if(response.code == 422){
                    handleError('#support-fullname', '.support-fullname-wrapper', data.full_name);
                    handleError('#support-email', '.support-email-wrapper', data.email);
                    handleError('#support-phone', '.support-phone-wrapper', data.phone);
                    handleError('#support-question', '.support-question-wrapper', data.descriptions);

                    $('.support-submit-wrapper .support-btn-text').show();
                    $('.support-submit-wrapper .support-loader').hide();
                } else {
                    $('.success-form-wrapper').show();
                    $('.success-form-wrapper .success-form').html(response.message);
                    setTimeout(function() {
                        $('.success-form-wrapper').fadeOut();
                    }, 5000);

                    $('#support-fullname').val('');
                    $('#support-email').val('');
                    $('#support-phone').val('');
                    $('#support-question').val('');
                    $('#support-file').val('');
                    $('.support-file-input .placeholder-text').html('Tải lên');
                    $('.upload-icon').show();
                    $('.delete-icon').hide();

                    $('.support-submit-wrapper .support-btn-text').show();
                    $('.support-submit-wrapper .support-loader').hide();
                }
            },
            error: function(xhr, status, error){
                $('.support-submit-wrapper .support-btn-text').show();
                $('.support-submit-wrapper .support-loader').hide();                
                console.log('Error:', error);
            }
        })
    });
    handleRemoveError('.support-fullname-wrapper', '#support-fullname');
    handleRemoveError('.support-email-wrapper', '#support-email');
    handleRemoveError('.support-phone-wrapper', '#support-phone');
    handleRemoveError('.support-question-wrapper', '#support-question');

    function checkStatusStudent(){
        let api;
        if (idLead) {
            api = baseUrl + checkStatusApi + idLead;
        }
        $('.status_step_1').html(`<span style="color:red;">Chưa</span>`);
        $('.status_step_2').html(`<span style="color:red;">Chưa</span>`);
        $('.status_step_3').html(`<span style="color:red;">Chưa</span>`);

        $.ajax({
            url: api,
            type: 'GET',
            success: function(res){
                if(res[0] == 'Đăng ký hồ sơ'){
                    $('.status_step_1').html(`<span style="color:green;">Hoàn thành</span>`);

                    $("<style>")
                        .prop("type", "text/css")
                        .html(".s_step_1::before { background-color: #034EA2 !important; }")
                        .appendTo("head");
                }
                if(res[1] == 'Đã nộp hồ sơ'){
                    $('.status_step_1').html(`<span style="color:green;">Hoàn thành</span>`);
                    $('.status_step_2').html(`<span style="color:green;">Hoàn thành</span>`);

                    $("<style>")
                        .prop("type", "text/css")
                        .html(".s_step_1::before { background-color: #034EA2 !important; }")
                        .appendTo("head");
                    $("<style>")
                        .prop("type", "text/css")
                        .html(".s_step_2::before { background-color: #034EA2 !important; }")
                        .appendTo("head");
                }
                if(res[2] == 'Đã đóng học phí'){
                    $('.status_step_1').html(`<span style="color:green;">Hoàn thành</span>`);
                    $('.status_step_2').html(`<span style="color:green;">Hoàn thành</span>`);
                    $('.status_step_3').html(`<span style="color:green;">Hoàn thành</span>`);

                    $("<style>")
                        .prop("type", "text/css")
                        .html(".s_step_1::before { background-color: #034EA2 !important; }")
                        .appendTo("head");
                    $("<style>")
                        .prop("type", "text/css")
                        .html(".s_step_2::before { background-color: #034EA2 !important; }")
                        .appendTo("head");
                    $("<style>")
                        .prop("type", "text/css")
                        .html(".s_step_3::before { background-color: #034EA2 !important; }")
                        .appendTo("head");
                }
            },
            error: function(xhr, status, error){
                console.log('Error:', error);
            }
        })
    }
    checkStatusStudent();

    $('#block_adminssions').prop('disabled', true).css('background-color', 'rgba(204, 204, 204,0.4)');
    $('#marjor_f5_1').on('change', function() {
        var selectedMajorId = $(this).val();
        
        $('#block_adminssions').prop('disabled', false).css('background-color', 'rgba(255, 255, 255,1)');
        $('#block_adminssions option').each(function() {
            var majorId = $(this).data('id-major');
            if (majorId == selectedMajorId || !selectedMajorId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Reset the block_adminssions dropdown to the default option
        $('#block_adminssions').val('');
        $('.subject').text('');
    });

    let today = new Date();
    today.setDate(today.getDate() - 1); // Lùi lại 1 ngày để không chọn được ngày hiện tại
    let maxDate = today.toISOString().split("T")[0];

    $("#dateOfBirth").attr("max", maxDate);
});


$(document).ready(function () {
    let today = new Date();
    today.setDate(today.getDate() - 1); // Lấy ngày hôm qua
    let maxDate = today.toISOString().split("T")[0]; // Chuyển sang định dạng yyyy-mm-dd

    $("#date_of_join_youth_union").attr("max", maxDate); // Thiết lập giá trị max
    $("#date_of_join_communist_party").attr("max", maxDate); // Thiết lập giá trị max

    // Ngăn chọn ngày không hợp lệ
    $("#date_of_join_youth_union").on("change", function () {
        if ($(this).val() >= maxDate) {
            alert("Bạn chỉ được chọn ngày trong quá khứ!");
            $(this).val(""); // Xóa giá trị nếu không hợp lệ
        }
    });
    $("#date_of_join_communist_party").on("change", function () {
        if ($(this).val() >= maxDate) {
            alert("Bạn chỉ được chọn ngày trong quá khứ!");
            $(this).val(""); // Xóa giá trị nếu không hợp lệ
        }
    });
});
