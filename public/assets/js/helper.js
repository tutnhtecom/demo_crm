function $post(url, data, method, redirect){         
    $.ajax({
        url: url,
        type: method,
        data: data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        success: function (res) {                                    
            if (res && res.code === 200) {
                $.notify(res.message, "success");                 
                localStorage.setItem('crm.auth', res.data)                
                window.location.replace(redirect);
            } else {                
                $.notify(res.message, "error");
            }
        },
        error: function (error) {
            if(error.status === 422) {
                showErrMessage(error.responseJSON.data);        
            }
        },
    });
}
function error(class_name, id_name, err_msg, str) {
    if(str.length <= 0) {                
        $(class_name).attr('id', id_name);
        $(class_name).html(err_msg);
    } else {        
        $(class_name).removeAttr('id', id_name);
        $(class_name).html('');
    } 
}
function $get(url, method, redirect){  
    let response = null;   
    $.ajax({
        url: url,
        type: method,
        success: function (res) {
            if (res && res.code === 200) {
                $.notify(res.message, "success");
                location.reload();
            } else {
                $.notify(res.message, "error");
            }
        },
        error: function (error) {
            if (error.message) {
                $.notify(res.message, "error");
            }
        },
    });
    return response;
}

// Loading
$(document).ajaxStart(function() {    
    $('#loading').addClass('loading');
    $('#loading-content').addClass('loading-content');
});

$(document).ajaxStop(function() {
    $('#loading').removeClass('loading');
    $('#loading-content').removeClass('loading-content');
});

function showErrMessage(result){
    if(result.email) {
        $.notify(result.email, "error");
    }  
    if(result.email) {
        $.notify(result.password[0], "error");
    }  
}

// format date to dd/mm/yyyy \\
function formatdate(e){
    let date = new Date(e);

    let day = String(date.getDate()).padStart(2, '0');
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let year = date.getFullYear();
    let formattedDate = day + "/" + month + "/" + year;

    return formattedDate;
}

// handle error when submit form \\
function handleError(field, wrapper, errors) {
    if (errors != null) {
        $(field).addClass('border-error');
        $(wrapper + ' .error-input').html(errors.join(', '));
        $(wrapper + ' .error-input').addClass('show-error');
    }
}

// handle remove error effect when click input \\
function handleRemoveError(wrapper, id_input){
    $(wrapper).on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find(id_input).removeClass('border-error');
    });
}

function handleChangeRemoveError(wrapper, id_input) {
    // Lắng nghe sự kiện change trên input trong wrapper
    $(document).on('input', wrapper + ' ' + id_input, function () {
        // Xóa class show-error và nội dung thông báo lỗi
        $(this).closest(wrapper).find('.error-input').removeClass('show-error').html('');

        // Xóa class border-error khỏi input
        $(this).removeClass('border-error');
    });
}



// change subject when select block_adminssions \\
$('#block_adminssions').change(function() {
    var selectedOption = $(this).find('option:selected');
    
    var monsText = selectedOption.data('mons');
    var subjects = monsText.replace(/^[^:]+:\s*/, ''); 
    
    if (subjects) {
        var monsArray = subjects.split(', ');
        $('.subject').each(function(index) {
            $(this).text(monsArray[index] || '');
        });
    } else {
        $('.subject').text('');
    }
});

function calculateAverage() {
    let total = 0;
    let count = 0;
    
    $('input[id^="score-"]').each(function() {
        let value = parseFloat($(this).val()) || 0;
        total += value;
        count++;
    });
    
    let average = count > 0 ? (total / count).toFixed(2) : '0.00';
    
    $('.total-score').text(average);
}
function calculateTotal() {
    let total = 0;
    
    $('input[id^="score-"]').each(function() {
        let value = parseFloat($(this).val()) || 0;
        total += value;
    });
    
    $('.total-score').text(total.toFixed(2)); // Hiển thị tổng với 2 chữ số thập phân
}
$('input[id^="score-"]').on('input', calculateTotal);

['#score-1', '#score-2', '#score-3'].forEach(function(selector) {
    $(selector).on('keydown', function(e) {
        if (e.key === '-' || e.key === 'e') { // Ngăn nhập dấu '-' và 'e'
            e.preventDefault();
        }

        const $input = $(e.target);
        if ($input.val().length >= 4 && 
            e.key !== 'Backspace' && 
            e.key !== 'Delete' && 
            e.key !== 'ArrowLeft' && 
            e.key !== 'ArrowRight') {
            e.preventDefault();
        }
    });
});


// ['father_yearOfBirth', 'mother_yearOfBirth'].forEach(function(id) {
//     document.getElementById(id).addEventListener('keydown', function(e) {
//         if (e.key === '-' || e.key === 'e') {
//             e.preventDefault();
//         }

//         const input = e.target;
//         if (input.value.length >= 4 && 
//             e.key !== 'Backspace' && 
//             e.key !== 'Delete' && 
//             e.key !== 'ArrowLeft' && 
//             e.key !== 'ArrowRight') {
//             e.preventDefault();
//         }
//     });
// });

['#father_yearOfBirth', '#mother_yearOfBirth'].forEach(function(selector) {
    $(selector).on('keydown', function(e) {
        if (e.key === '-' || e.key === 'e') {
            e.preventDefault();
        }

        const $input = $(e.target);
        if ($input.val().length >= 4 && 
            e.key !== 'Backspace' && 
            e.key !== 'Delete' && 
            e.key !== 'ArrowLeft' && 
            e.key !== 'ArrowRight') {
            e.preventDefault();
        }
    });
});

// Ngăn chặn không cho nhập chữ ở CCCD \\
$('#identificationCard').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#home_phone').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#phone').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#yearOfBirth_wifeOrHusband').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#phone_wifeOrHusband').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#year_of_degree_1').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#serial_number_degree_1').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#year_of_degree_2').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#serial_number_degree_2').on('input', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
});

$('#average_score').on('input', function () {
    // Lấy giá trị hiện tại
    let value = $(this).val();

    // Loại bỏ ký tự không phải số hoặc dấu chấm
    value = value.replace(/[^0-9.]/g, '');

    // Chỉ cho phép một dấu chấm
    if ((value.match(/\./g) || []).length > 1) {
        value = value.slice(0, -1);
    }

    // Giới hạn chỉ cho phép 3 chữ số trước dấu chấm
    let parts = value.split('.');
    if (parts[0].length > 3) {
        parts[0] = parts[0].slice(0, 3); // Cắt chuỗi chỉ giữ lại 3 chữ số đầu
    }

    // Nếu có phần thập phân, ghép lại giá trị
    value = parts.length > 1 ? parts[0] + '.' + parts[1] : parts[0];

    // Cập nhật giá trị đã xử lý vào input
    $(this).val(value);
});

// const year_of_degree_1 = document.getElementById('year_of_degree_1');
// year_of_degree_1.addEventListener('input', function() {
//     this.value = this.value.replace(/\D/g, '');
// });

// const serial_number_degree_1 = document.getElementById('serial_number_degree_1');
// serial_number_degree_1.addEventListener('input', function() {
//     this.value = this.value.replace(/\D/g, '');
// });

// const year_of_degree_2 = document.getElementById('year_of_degree_2');
// year_of_degree_2.addEventListener('input', function() {
//     this.value = this.value.replace(/\D/g, '');
// });

// const serial_number_degree_2 = document.getElementById('serial_number_degree_2');
// serial_number_degree_2.addEventListener('input', function() {
//     this.value = this.value.replace(/\D/g, '');
// });

// kiểm tra để chỉ cho nhập năm nhỏ hơn hoặc bằng năm hiện tại \\
function validateYear1() {
    const inputField = document.getElementById('year_of_degree_1');
    const errorMessage = document.getElementById('error_year_of_degree_1');
    const currentYear = new Date().getFullYear();
    
    // Set the max attribute dynamically to the current year
    inputField.max = currentYear;

    if (parseInt(inputField.value, 10) > currentYear) {
        errorMessage.style.display = 'block';
        inputField.value = currentYear; // Optionally reset to the max year
    } else {
        errorMessage.style.display = 'none';
    }
}

function validateYear2() {
    const inputField = document.getElementById('year_of_degree_2');
    const errorMessage = document.getElementById('error_year_of_degree_2');
    const currentYear = new Date().getFullYear();
    
    // Set the max attribute dynamically to the current year
    inputField.max = currentYear;

    if (parseInt(inputField.value, 10) > currentYear) {
        errorMessage.style.display = 'block';
        inputField.value = currentYear; // Optionally reset to the max year
    } else {
        errorMessage.style.display = 'none';
    }
}

// ----- handle login ----- \\


// --- show password --- \\
$('#toggle-password').on('click', function() {
    var passwordField = $('#password-lead-login');
    var passwordFieldType = passwordField.attr('type');
    
    if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
        $('#toggle-password i').removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        passwordField.attr('type', 'password');
        $('#toggle-password i').removeClass('fa-eye-slash').addClass('fa-eye'); 
    }
});

// --- handle input type=date --- \\
var today = new Date().toISOString().split('T')[0];
$('input[type="date"]').attr('max', today);

// --- show name file when upload file --- \\
// $('#support-file').on('change', function() {
//     const fileName = $(this).prop('files')[0].name;
//     $('.placeholder-text').text(fileName);
// });

// fix tab scroll \\
const $tabContainer = $('#tab-container');
$tabContainer.on('scroll', function() {
    const scrollLeft = $tabContainer.scrollLeft();
    const maxScrollLeft = $tabContainer[0].scrollWidth - $tabContainer.outerWidth();

    if (scrollLeft === 0) {
        $tabContainer.css('box-shadow', 'rgba(0, 0, 0, 0.3) -10px 0px 2px -3px inset');
    } else if (scrollLeft === maxScrollLeft) {
        $tabContainer.css('box-shadow', 'rgba(0, 0, 0, 0.3) 10px 0px 2px -3px inset');
    } else {
        $tabContainer.css('box-shadow', 'rgba(0, 0, 0, 0.3) 10px 0px 2px -3px inset');
    }
});

function setupPointGPA(pointGPASelector, averageScoreSelector) {
    let inputField = $(averageScoreSelector);

    // Mặc định khóa ô nhập điểm
    inputField.prop('disabled', true).attr('placeholder', 'Chọn hệ số trước');

    $(pointGPASelector).on('change', function () {
        let selectedValue = $(this).val();

        if (selectedValue === '4' || selectedValue === '10') {
            inputField.prop('disabled', false).val('');
            inputField.attr('maxlength', 4);

            if (selectedValue == '4') {
                inputField.attr('max', '4.0').attr('placeholder', 'Nhập tối đa 4.0');
            } else {
                inputField.attr('max', '10.0').attr('placeholder', 'Nhập tối đa 10.0');
            }
        } else {
            inputField.prop('disabled', true).val('');
            inputField.attr('placeholder', 'Chọn hệ số trước');
        }
    });

    // Kiểm tra giá trị nhập vào
    inputField.on('input', function () {
        let maxVal = parseFloat($(this).attr('max'));
        let currentVal = $(this).val();

        // Chỉ cho phép nhập số và dấu "."
        currentVal = currentVal.replace(/[^0-9.]/g, '');

        // Kiểm tra xem có nhiều hơn một dấu "." không
        let dotCount = (currentVal.match(/\./g) || []).length;
        if (dotCount > 1) {
            currentVal = currentVal.substring(0, currentVal.lastIndexOf('.')); // Giữ lại dấu "." đầu tiên
        }

        // Kiểm tra giới hạn giá trị
        if (parseFloat(currentVal) > maxVal) {
            currentVal = maxVal.toString();
        }

        $(this).val(currentVal);
    });
}

// Áp dụng cho cả hai trường hợp
setupPointGPA('#point_gpa_2', '#average_score_2');
setupPointGPA('#point_gpa_3', '#average_score_3');