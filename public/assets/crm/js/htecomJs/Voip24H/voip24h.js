// Xác thực tài khoản voip24h \\
$(document).ready(function(){
    $.ajax({
        url: "https://api.voip24h.vn/v3/authentication",
        type: "POST",
        data: {
            "apiKey": window.API_KEY,
            "apiSecret": window.API_SECRET,
            "isLonglive": "true"
        },
        success: function(response) {
            if(response.message == 'Success'){
                localStorage.setItem('token_voip', response.data.token);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr, status, error);
        }
    })
})

$(document).ready(function() {
    // ------------------------------------------------------------------------------------------------------ \\
    var callTimerInterval;
    function callTimer(){
        let seconds = 0;
        callTimerInterval = setInterval(function() {
            seconds++;
            let minutes = Math.floor(seconds / 60);
            let secs = seconds % 60;
            let formattedTime = (minutes < 10 ? "0" : "") + minutes + ":" + (secs < 10 ? "0" : "") + secs;
            $("#callTimer").text(formattedTime);
            $('#title_call').text(formattedTime)
        }, 1000);
    }

    $(".btn_call_voip").click(function() {
        var phoneNumber = $(this).attr("data-phone");
        $("#callingNumber").text(phoneNumber);
        $("#callTimer").text("Đang gọi...");

        $("#callScreen").fadeIn();
        centerPopup($("#callScreen"));

        // Reset và bắt đầu bộ đếm thời gian
        clearInterval(callTimerInterval);
        
    });

    $("#endCall").click(function() {
        $("#callScreen").fadeOut();
        clearInterval(callTimerInterval);
    });

    let voipIpStorage =  localStorage.getItem('voip_ip_sip');
    let voipNumberStorage =  localStorage.getItem('voip_number_sip');
    let voipPasswordStorage =  localStorage.getItem('voip_password_sip');
    let isConnected = localStorage.getItem('voip_connected') === 'true';

    $('.btn_connect_voip').prop('disabled', true);
    $('.btn_call_voip').prop('disabled', true);
    
    if(voipIpStorage && voipNumberStorage && voipPasswordStorage){
        $('.btn_connect_voip').addClass('hide_btn');
    }

    let gatewayInitialized = false;
    let voipIp = $('#voip_ip_sip').val();
    let voipNumber = $('#voip_number_sip').val();
    let voipPassword = $('#voip_password_sip').val();
    // let voipPassword = "1111111";

    setTimeout(()=>{
        initGateWay(function(event, data) {
            gatewayInitialized = true;
            if (event === 'init') {
                if(voipIpStorage && voipNumberStorage && voipPasswordStorage){
                    setTimeout(()=>{
                        registerSip(voipIpStorage, voipNumberStorage, voipPasswordStorage);
                    }, 1000)
                }
                $('.btn_connect_voip').prop('disabled', false);
                console.log('Init:', data);
            } else if (event === 'register') {
                if(data == "registration_failed"){
                    $.notify("Kết nối không thành công. Vui lòng kiểm ra máy nhánh hoặc mật khẩu.", "error");
                    localStorage.setItem('voip_connected', 'false');
                    isConnected = false;  
                    return false;
                }

                if (!isConnected) {
                    localStorage.setItem('voip_ip_sip', voipIp);
                    localStorage.setItem('voip_number_sip', voipNumber);
                    localStorage.setItem('voip_password_sip', voipPassword);
                    $.notify("Kết nối thành công", "success");  
                    localStorage.setItem('voip_connected', 'true');
                    // isConnected = true;
                    isConnected = true;
                    setTimeout(()=>{
                        window.location.reload();
                    }, 1500) 
                }
    
                navigator.mediaDevices.enumerateDevices().then(devices => {
                    const hasMicrophone = devices.some(device => device.kind === 'audioinput');
                    if (hasMicrophone) {
                        $('.noti_micro_check_device').html('').hide();
                        setTimeout(()=>{
                            $('.btn_call_voip').prop('disabled', false);
                        },1000)
                    } else {
                        setTimeout(()=>{
                            $('.btn_call_voip').prop('disabled', true);
                        },1000)
                    }
                });
    
                navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    $('.noti_micro_turn_on').html('').hide();
                    setTimeout(()=>{
                        $('.btn_call_voip').prop('disabled', false);
                    },1000)
                    stream.getTracks().forEach(track => track.stop());
                })
                .catch(error => {
                    setTimeout(()=>{
                        $('.btn_call_voip').prop('disabled', true);
                    },1000)
                });
                
                // console.log(data);
            } else if (event === 'incomingcall') {
                $("#answer_modal").fadeIn();
                centerPopup($("#answer_modal"));
                $('#title_call').text('Cuộc gọi đến')
                $('#number_call').text(data[0].phonenumber)
                console.log("incomingcall: ", data);
    
            } else if (event === 'progress') {
                // console.log("progress: ", data);
            } else if (event === 'accepted') {
                callTimer();
                console.log(data);
            } else if(event === 'hangup'){
                clearInterval(callTimerInterval);
                $("#callTimer").html('Kết thúc cuộc gọi');
                $("#title_call").html('Kết thúc cuộc gọi');
                setTimeout(()=>{
                    $("#callScreen").fadeOut();
                    $("#answer_modal").fadeOut();
                }, 1000);
                setTimeout(()=>{
                    window.location.reload();
                }, 1200);
            } else if(event === 'missed'){
                clearInterval(callTimerInterval);
                $("#callTimer").html('Kết thúc cuộc gọi');
                $("#title_call").html('Kết thúc cuộc gọi');
                setTimeout(()=>{
                    $("#callScreen").fadeOut();
                    $("#answer_modal").fadeOut();
                }, 1000);
                setTimeout(()=>{
                    window.location.reload();
                }, 1200);
            }
            console.log('data:', data);
        });
        
        setTimeout(()=>{
            if (!gatewayInitialized) {
                $('.noti_err_voip').append('Không thể thiết lập kết nối với tổng đài. Vui lòng thử lại sau.').show();
            }
        },5000)
    },100)

    $(document).on('click', '.btn_connect_voip', function(){
        if(voipNumber == '' || voipPassword == ''){
            $.notify("Bạn chưa có máy nhánh để kết nối tổng đài.", "error");
            return false;
        }

        setTimeout(()=>{
            registerSip(voipIp, voipNumber, voipPassword);
        },500)

        // isConnected = localStorage.getItem('voip_connected');
        if(isConnected == true){
            setTimeout(()=>{
                $(".btn_connect_voip").addClass('hide_btn');
            }, 1000)
        }
    })

    $(document).on('click', '.btn_call_voip', function(){
        let phoneNumber = $(this).attr('data-phone');
        call(phoneNumber);
    })

    $(document).on('click', '.end-call', function(){
        hangUp();
        setTimeout(()=>{
            $("#callScreen").fadeOut();
            $("#answer_modal").fadeOut();
        }, 1000);
    })

    $(document).on('click', '.btn_mute', function(){
        let btn = $(this); // Chỉ lấy đúng nút được click
        
        toggleMute(); // Gọi hàm tắt/bật mic
    
        setTimeout(() => { // Đợi một chút để chắc chắn trạng thái đã cập nhật
            if (isMute() === true) { // Kiểm tra nếu đang mute
                btn.addClass('mute_mic');
            } else {
                btn.removeClass('mute_mic');
            }
            console.log("Mute status:", isMute());
        }, 200);
    });

    $(document).on('click', '.success-call', function(){
        answer();
        clearInterval(callTimerInterval);
        $("#answer_modal .call-actions").fadeIn();
        $("#answer_modal .pre-call-actions").fadeOut();
    })

    $("#callScreen").draggable({
        handle: ".headerScreen",
        containment: "window",
    });

    $("#answer_modal").draggable({
        handle: ".headerScreen",
        containment: "window",
    });

    function centerPopup(popup) {
        popup.css({
          top: ($(window).height() - popup.outerHeight()) / 2,
          left: ($(window).width() - popup.outerWidth()) / 2,
        });
    }

    navigator.mediaDevices.enumerateDevices().then(devices => {
        const hasMicrophone = devices.some(device => device.kind === 'audioinput');
        if (hasMicrophone) {
            $('.noti_micro_check_device').html('').hide();
        } else {
            $('.noti_micro_check_device').append('Thiết bị không có microphone. Vui lòng kết nối microphone.').show();
        }
    });
    navigator.mediaDevices.getUserMedia({ audio: true })
    .then(stream => {
        $('.noti_micro_turn_on').html('').hide();
        stream.getTracks().forEach(track => track.stop());
    })
    .catch(error => {
        $('.noti_micro_turn_on').append('Vui lòng bật microphone.').show();
    });
});
