import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { editLeadApi, editStudentApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('submit', '#edit-lead-form', (e) => {
        e.preventDefault();
        $('.edit_lead_btn_submit').prop('disabled', true).html('Đang lưu...');
        const token = localStorage.getItem('jwt_token');
        const idLead = $('#edit_lead_btn_submit').data('id');
        let dataAttr = $(e.currentTarget).attr('data-attr');
        let api;
        if(dataAttr == 'student'){
            api = baseUrl+editStudentApi+idLead;
        } else {
            api = baseUrl+editLeadApi+idLead;
        }
        let code                = $('#edit_lead_code').val();
        let full_name           = $('#edit_lead_fullName').val();
        let phone               = $('#edit_lead_phone').val();
        let email               = $('#edit_lead_email').val();
        let gender              = $('#edit_lead_gender').val();
        let date_of_birth       = formatDate($('#edit_lead_dateOfBirth').val());
        let identification_card = $('#edit_lead_identification_card').val();
        let full_name_father    = $('#edit_lead_name_father').val();
        let phone_number_father = $('#edit_lead_phone_father').val();
        let full_name_mother    = $('#edit_lead_name_mother').val();
        let phone_number_mother = $('#edit_lead_phone_mother').val();
        let provinces_name_hktt = $('#edit_lead_provinces_hktt').val();
        let districts_name_hktt = $('#edit_lead_districts_hktt').val();
        let wards_name_hktt     = $('#edit_lead_wards_hktt').val();
        let address_hktt        = $('#edit_lead_address_hktt').val();
        let provinces_name_dcll = $('#edit_lead_provinces_dcll').val();
        let districts_name_dcll = $('#edit_lead_districts_dcll').val();
        let wards_name_dcll     = $('#edit_lead_wards_dcll').val();
        let address_dcll        = $('#edit_lead_address_dcll').val();
        let lst_status_id       = $('#edit_lead_status').val();
        let marjors_id             = $('#edit_lead_major').val();
        let sources_id          = $('#edit_lead_source').val();
        let tag_value           = $('#edit_lead_tag').val();
        let employees_id        = $('#edit_lead_employees').val();
        let employees_id_old    = $('#edit_lead_employees_old').val();

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
                "employees_id_old"    : employees_id_old,
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
                "tag_value"           : tag_value,
                "address_dcll"        : address_dcll
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#edit_lead_code', '.edit_lead_code_wrapper', res.data.leads_code);
                    handleError('#edit_lead_fullName', '.edit_lead_fullName_wrapper', res.data.full_name);
                    handleError('#edit_lead_phone', '.edit_lead_phone_wrapper', res.data.phone);
                    handleError('#edit_lead_email', '.edit_lead_email_wrapper', res.data.email);
                    handleError('#edit_lead_dateOfBirth', '.edit_lead_dateOfBirth_wrapper', res.data.date_of_birth);
                    handleError('#edit_lead_identification_card', '.edit_lead_identification_card_wrapper', res.data.identification_card);

                    handleError('#edit_lead_status', '.edit_lead_status_wrapper', res.data.lst_status_id);
                    handleError('#edit_lead_major', '.edit_lead_major_wrapper', res.data.marjors_id);
                    handleError('#edit_lead_source', '.edit_lead_source_wrapper', res.data.sources_id);
                    handleError('#edit_lead_employees', '.edit_lead_employees_wrapper', res.data.employeess_id);
                    


                } else {
                    let currentUrl = window.location.href;
                    if(dataAttr == 'student'){
                        let newUrl = currentUrl.split('/edit_student/')[0];
                        setTimeout(function() {
                            window.location.href = newUrl + '/detail_student/' + idLead;
                        }, 100);
                    } else {
                        let newUrl = currentUrl.split('/edit_lead/')[0];
                        setTimeout(function() {
                            window.location.href = newUrl + '/detail_lead/' + idLead;
                        }, 100);
                    }
                    // $('#edit_lead_btn_submit').html('Đăng thông tin');
                    $.notify(res.message, "success");
                }
                setTimeout(function() {
                    $('.edit_lead_btn_submit').prop('disabled', false).html('Đăng thông tin');
                }, 1400);
            },
            error: (xhr, status, error) => {
                console.error(xhr);
            }
        })
    })
    handleRemoveError('.edit_lead_fullName_wrapper', '#edit_lead_fullName');
    handleRemoveError('.edit_lead_phone_wrapper', '#edit_lead_phone');
    handleRemoveError('.edit_lead_email_wrapper', '#edit_lead_email');
    handleRemoveError('.edit_lead_dateOfBirth_wrapper', '#edit_lead_dateOfBirth');
    handleRemoveError('.edit_lead_identification_card_wrapper', '#edit_lead_identification_card');

    handleRemoveError('.edit_lead_status_wrapper', '#edit_lead_status');
    handleRemoveError('.edit_lead_major_wrapper', '#edit_lead_major');
    handleRemoveError('.edit_lead_source_wrapper', '#edit_lead_source');
    handleRemoveError('.edit_lead_employees_wrapper', '#edit_lead_employees');

    var data = window.provincesDataPageEdit;
    var defaultDistrictHktt = $('#edit_lead_provinces_hktt').data('default-district');
    var defaultWardHktt = $('#edit_lead_provinces_hktt').data('default-ward');
    var defaultDistrictDcll = $('#edit_lead_provinces_dcll').data('default-district');
    var defaultWardDcll = $('#edit_lead_provinces_dcll').data('default-ward');

    function handleProvinceChange(provinceSelector, districtSelector, wardSelector, defaultDistrict = '', defaultWard = '') {
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

                if (defaultDistrict) {
                    $(districtSelector).val(defaultDistrict).trigger('change');
                }
            } else {
                $(districtSelector).prop('disabled', true);
            }
        }).trigger('change');
    }

    function handleDistrictChange(districtSelector, wardSelector, defaultWard = '') {
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

                if (defaultWard) {
                    $(wardSelector).val(defaultWard);
                }
            } else {
                $(wardSelector).prop('disabled', true);
            }
        }).trigger('change');
    }


    handleProvinceChange('#edit_lead_provinces_hktt', '#edit_lead_districts_hktt', '#edit_lead_wards_hktt', defaultDistrictHktt, defaultWardHktt);
    handleDistrictChange('#edit_lead_districts_hktt', '#edit_lead_wards_hktt', defaultWardHktt);

    handleProvinceChange('#edit_lead_provinces_dcll', '#edit_lead_districts_dcll', '#edit_lead_wards_dcll', defaultDistrictDcll, defaultWardDcll);
    handleDistrictChange('#edit_lead_districts_dcll', '#edit_lead_wards_dcll', defaultWardDcll);

    $('#edit_lead_identification_card').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#edit_lead_phone_father').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#edit_lead_phone_mother').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
})
