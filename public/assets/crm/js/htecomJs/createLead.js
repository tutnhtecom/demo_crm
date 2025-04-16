import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { createLeadApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('submit', '#create-lead-form', (e) => {
        e.preventDefault();
        $('#create_lead_btn_submit').html('Đang tạo...');

        const token = localStorage.getItem('jwt_token');
        const api = baseUrl+createLeadApi;
        let code                = $('#create_lead_code').val();
        let full_name           = $('#create_lead_fullName').val();
        let phone               = $('#create_lead_phone').val();
        let email               = $('#create_lead_email').val();
        let gender              = $('#create_lead_gender').val();
        let date_of_birth       = formatDate($('#create_lead_dateOfBirth').val());
        let identification_card = $('#create_lead_identification_card').val();
        let full_name_father    = $('#create_lead_name_father').val();
        let phone_number_father = $('#create_lead_phone_father').val();
        let full_name_mother    = $('#create_lead_name_mother').val();
        let phone_number_mother = $('#create_lead_phone_mother').val();
        let provinces_name_hktt = $('#create_lead_provinces_hktt').val();
        let districts_name_hktt = $('#create_lead_districts_hktt').val();
        let wards_name_hktt     = $('#create_lead_wards_hktt').val();
        let address_hktt        = $('#create_lead_address_hktt').val();
        let provinces_name_dcll = $('#create_lead_provinces_dcll').val();
        let districts_name_dcll = $('#create_lead_districts_dcll').val();
        let wards_name_dcll     = $('#create_lead_wards_dcll').val();
        let address_dcll        = $('#create_lead_address_dcll').val();
        let lst_status_id       = $('#create_lead_status').val();
        let marjors_id          = $('#create_lead_major').val();
        let sources_id          = $('#create_lead_source').val();
        let employees_id        = $('#create_lead_employees').val();

        const iframeDocument = $('#create_lead_note_ifr').contents().get(0);
        const bodyIframe = iframeDocument.body;

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "leads_code"          : code,
                "full_name"           : full_name,
                "phone"               : phone,
                "email"               : email,
                "gender"              : gender,
                "date_of_birth"       : date_of_birth,
                "identification_card" : identification_card,
                "lst_status_id"       : lst_status_id,
                "sources_id"          : sources_id,
                "employees_id"        : employees_id,
                "marjors_id"          : marjors_id,
                "title_father"        : "Cha",            
                "full_name_father"    : full_name_father,
                "phone_number_father" : phone_number_father,    
                "title_mother"        : "Mẹ",            
                "full_name_mother"    : full_name_mother,
                "phone_number_mother" : phone_number_mother,  
                "title_hktt"          : "HKTT",            
                "provinces_name_hktt" : provinces_name_hktt,
                "districts_name_hktt" : districts_name_hktt,
                "wards_name_hktt"     : wards_name_hktt,
                "address_hktt"        : address_hktt,   
                "title_dcll"          : "DCLL",            
                "provinces_name_dcll" : provinces_name_dcll,
                "districts_name_dcll" : districts_name_dcll,
                "wards_name_dcll"     : wards_name_dcll,
                "address_dcll"        : address_dcll   
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#create_lead_fullName', '.create_lead_fullName_wrapper', res.data.full_name);
                    handleError('#create_lead_phone', '.create_lead_phone_wrapper', res.data.phone);
                    handleError('#create_lead_code', '.create_lead_code_wrapper', res.data.leads_code);
                    handleError('#create_lead_email', '.create_lead_email_wrapper', res.data.email);
                    handleError('#create_lead_dateOfBirth', '.create_lead_dateOfBirth_wrapper', res.data.date_of_birth);
                    handleError('.create_lead_status_wrapper .select2-selection', '.create_lead_status_wrapper', res.data.lst_status_id);
                    handleError('.create_lead_major_wrapper .select2-selection', '.create_lead_major_wrapper', res.data.marjors_id);
                    handleError('.create_lead_source_wrapper .select2-selection', '.create_lead_source_wrapper', res.data.sources_id);
                    handleError('.create_lead_employees_wrapper .select2-selection', '.create_lead_employees_wrapper', res.data.employees_id);


                    handleError('#create_lead_identification_card', '.create_lead_identification_card_wrapper', res.data.identification_card);

                    $('#create_lead_btn_submit').html('Đăng thông tin');
                } else {
                    $('#create_lead_btn_submit').html('Đăng thông tin');
                    $('#create_lead_fullName').val('');
                    $('#create_lead_code').val('');
                    $('#create_lead_phone').val('');
                    $('#create_lead_email').val('');
                    $('#create_lead_gender').val('');
                    $('#create_lead_dateOfBirth').val('');
                    $('#create_lead_identification_card').val('');
                    $('#create_lead_name_father').val('');
                    $('#create_lead_phone_father').val('');
                    $('#create_lead_name_mother').val('');
                    $('#create_lead_phone_mother').val('');
                    $('#create_lead_provinces_hktt').val('');
                    $('#create_lead_districts_hktt').val('');
                    $('#create_lead_wards_hktt').val('');
                    $('#create_lead_address_hktt').val('');
                    $('#create_lead_provinces_dcll').val('');
                    $('#create_lead_districts_dcll').val('');
                    $('#create_lead_wards_dcll').val('');
                    $('#create_lead_address_dcll').val('');
                    $('#create_lead_status').val('').trigger('change');
                    $('#create_lead_major').val('').trigger('change');
                    $('#create_lead_source').val('').trigger('change');
                    $('#create_lead_employees').val("").trigger('change');
                    $(bodyIframe).empty(); 
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.href = baseUrl+'/crm/leads/detail_lead/'+res.data.id;
                    }, 2000);
                }
            },
            error: (xhr, status, error) => {
                console.error(xhr);
            }
        })
    })
    handleRemoveError('.create_lead_fullName_wrapper', '#create_lead_fullName');
    handleRemoveError('.create_lead_phone_wrapper', '#create_lead_phone');
    handleRemoveError('.create_lead_email_wrapper', '#create_lead_email');
    handleRemoveError('.create_lead_dateOfBirth_wrapper', '#create_lead_dateOfBirth');
    handleRemoveError('.create_lead_identification_card_wrapper', '#create_lead_identification_card');
    handleRemoveError('.create_lead_status_wrapper', '.select2-selection');
    handleRemoveError('.create_lead_major_wrapper', '.select2-selection');
    handleRemoveError('.create_lead_source_wrapper', '.select2-selection');
    handleRemoveError('.create_lead_employees_wrapper', '.select2-selection');

    var data = window.provincesData;
    function handleProvinceChange(provinceSelector, districtSelector, wardSelector) {
        $(provinceSelector).on('change', function() {
            var cityName = $(this).val();
            var districts = [];

            $.each(data, function(index, city) {
                if (city.name == cityName) {
                    districts = city.districts;
                }
            });

            $(districtSelector).empty().append('<option value="">Chọn Quận / Huyện</option>');
            $(wardSelector).empty().append('<option value="">Chọn Phường / Xã</option>').prop('disabled', true);

            if (cityName) {
                $.each(districts, function(index, district) {
                    $(districtSelector).append('<option value="'+district.name+'">'+district.name+'</option>');
                });
                $(districtSelector).prop('disabled', false);
            } else {
                $(districtSelector).prop('disabled', true);
            }
        });
    }

    function handleDistrictChange(districtSelector, wardSelector) {
        $(districtSelector).on('change', function() {
            var districtName = $(this).val();
            var wards = [];

            $.each(data, function(index, city) {
                $.each(city.districts, function(dIndex, district) {
                    if (district.name == districtName) {
                        wards = district.wards;
                    }
                });
            });

            $(wardSelector).empty().append('<option value="">Chọn Phường / Xã</option>');

            if (districtName) {
                $.each(wards, function(index, ward) {
                    $(wardSelector).append('<option value="'+ward.name+'">'+ward.name+'</option>');
                });
                $(wardSelector).prop('disabled', false);
            } else {
                $(wardSelector).prop('disabled', true); 
            }
        });
    }

    handleProvinceChange('#create_lead_provinces_hktt', '#create_lead_districts_hktt', '#create_lead_wards_hktt');
    handleDistrictChange('#create_lead_districts_hktt', '#create_lead_wards_hktt');

    handleProvinceChange('#create_lead_provinces_dcll', '#create_lead_districts_dcll', '#create_lead_wards_dcll');
    handleDistrictChange('#create_lead_districts_dcll', '#create_lead_wards_dcll');

    $('#create_lead_identification_card').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#create_lead_phone_father').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#create_lead_phone_mother').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
})