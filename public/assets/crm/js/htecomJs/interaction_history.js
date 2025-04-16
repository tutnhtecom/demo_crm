import { baseUrlVoip24, callHistoryApi, callRecordingApi } from '/assets/crm/js/htecomJs/Voip24H/voip24h_api.js';

$(document).ready(()=>{
    let phoneContact = $('.btn_call_voip').attr('data-phone');
    
    var tableInteractionHistory;

    var dataInteractionHistoryInit = function(){
        tableInteractionHistory = new DataTable('#tableInteractionHistory', {
            ajax: {
                url: baseUrlVoip24 + callHistoryApi+'?callee='+phoneContact+"&limit=1000",
                type: "GET",
                data: function(d) {                    
                   
                },
                beforeSend: function(xhr) {
                    var token = localStorage.getItem('token_voip');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
            },
            columns:[
                {   
                    data: null,
                    name: null,
                    className: 'align-middle text-center px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let render = `<div class="p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M11.25 6.75L14.25 3.75M14.25 3.75V6M14.25 3.75H12"
                                    stroke="#7E7E7E" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M7.52819 3.98713L8.01495 4.85933C8.45423 5.64644 8.27789 6.67899 7.58604 7.37085C7.58603 7.37085 7.58603 7.37085 7.58603 7.37085C7.58592 7.37097 6.74694 8.21016 8.26839 9.73161C9.78918 11.2524 10.6283 10.4148 10.6291 10.414C10.6292 10.4139 10.6292 10.414 10.6292 10.4139C11.321 9.72211 12.3536 9.54578 13.1407 9.98505L14.0129 10.4718C15.2014 11.1351 15.3418 12.8019 14.2971 13.8466C13.6693 14.4744 12.9003 14.9629 12.0502 14.9951C10.6191 15.0493 8.18871 14.6872 5.75078 12.2492C3.31285 9.81129 2.95066 7.38092 3.00491 5.94982C3.03714 5.0997 3.5256 4.33068 4.15335 3.70292C5.19807 2.65821 6.86488 2.79858 7.52819 3.98713Z"
                                    fill="#7E7E7E" />
                            </svg>
                        </div>`;
                        return render;
                    }
                },
                {   
                    data: 'extension',
                    name: 'extension',
                    className: 'align-middle text-center px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let render = `<span> ${row.extension} </span>`;
                        return render;
                    }
                },
                {   
                    data: 'status',
                    name: 'status',
                    className: 'align-middle text-center px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let answer = row.status == 'ANSWERED' ? `<span style="color:green;font-size:14px;">Gọi thành công</span>` : `<span style="color:red;font-size:14px;">Gọi không thành công</span>`
                        return answer;
                    }
                },
                {   
                    data: 'callDate',
                    name: 'callDate',
                    className: 'align-middle text-center px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let formattedDate = formatDateTime(data);
                        let billsecs = formatDuration(row.billsec);
                        let render = ` 
                            <div class="fs-6 text-nowrap">${formattedDate}</div>
                            <div class="fs-7 text-muted">${billsecs}</div>
                        `;
                        return render;
                    }
                },
                {   
                    data: null,
                    name: null,
                    className: 'align-middle text-center px-2 px-md-4 py-4 d-flex justify-content-center align-items-center',
                    searchable: false,
                    render: function(data, type, row) {
                        let render;
                        if(row.status == 'ANSWERED'){
                            render = `
                            <div class='btn_play_record_wrapper'>
                                <button data-callId=${row.callId} type="button" class="btn btn-ghost btn_play_record">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                        height="30" viewBox="0 0 30 30" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                            fill="#1EBB79" />
                                    </svg>
                                </button>
                                <audio controls style="display:none;" class="audio_show">
                                    <source src="" type="audio/wav">
                                    <source src="" type="audio/ogg">
                                    Trình duyệt của bạn không hỗ trợ phát âm thanh.
                                </audio>
                            </div>`;
                        } else {
                            render = `<div>
                                <button type="" class="btn btn-ghost" style="visibility:hidden;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                        height="30" viewBox="0 0 30 30" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                            fill="#1EBB79" />
                                    </svg>
                                </button>
                            </div>`;
                        }
                        return render;
                    }
                },
            ],
            layout: {
                topStart: null,
                topEnd: null,
                bottomStart: 'pageLength',
                bottomEnd: 'info',
                bottom3: 'paging'
            },
            autoWidth: true,
            stateSave: true,
            order: []
        });
        
    }
    dataInteractionHistoryInit();

    $(document).on('click', '.btn_play_record_wrapper', function(e) {
        let wrapper = $(this);
        let callid = wrapper.find('.btn_play_record').attr('data-callId');
        let apiRecord = baseUrlVoip24 + callRecordingApi + '?callId=' + callid;
        let token = localStorage.getItem('token_voip');
    
        $.ajax({
            url: apiRecord,
            type: 'GET',
            headers: {
                'Authorization': token
            },
            success: function(res) {
                if (!res.data || !res.data.media) {
                    console.error("API response is missing media data.");
                    return;
                }
    
                let dataOgg = res.data.media.ogg;
                let dataWav = res.data.media.wav;
                let audioElement = wrapper.find("audio");
    
                if (audioElement.length > 0) {
                    // 1. Dừng tất cả audio đang phát trước khi phát mới
                    $("audio").each(function() {
                        this.pause();
                        this.currentTime = 0; // Reset về đầu
                    });
    
                    // 2. Hiển thị lại tất cả nút play trước khi ẩn nút hiện tại
                    $(".btn_play_record").show();
                    
                    // 3. Ẩn tất cả .audio_show trước khi hiển thị cái đang được bấm
                    $(".audio_show").hide();
    
                    // 4. Cập nhật source mới và phát audio
                    audioElement.find("source[type='audio/wav']").attr("src", dataWav);
                    audioElement.find("source[type='audio/ogg']").attr("src", dataOgg);
                    audioElement[0].load();
    
                    wrapper.find('.audio_show').show();
                    wrapper.find('.btn_play_record').hide();
    
                    // 5. Phát audio
                    audioElement[0].play();
    
                    // 6. Khi audio kết thúc, hiển thị lại nút play
                    audioElement.off("ended").on("ended", function() {
                        wrapper.find('.btn_play_record').show();
                        wrapper.find('.audio_show').hide();
                    });
                } else {
                    console.error("No audio element found in the wrapper.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    });
    

    function formatDateTime(dateTime) {
        let date = new Date(dateTime);
    
        let hours = date.getHours().toString().padStart(2, "0");
        let minutes = date.getMinutes().toString().padStart(2, "0");
    
        let day = date.getDate().toString().padStart(2, "0");
        let month = (date.getMonth() + 1).toString().padStart(2, "0");
        let year = date.getFullYear();
    
        return `${hours}:${minutes} • ${day}/${month}/${year}`;
    }

    function formatDuration(seconds) {
        let hours = Math.floor(seconds / 3600); // Lấy số giờ
        let minutes = Math.floor((seconds % 3600) / 60); // Lấy số phút
        let remainingSeconds = seconds % 60; // Lấy số giây còn lại
    
        if (hours > 0) {
            return `${hours} giờ ${minutes} phút ${remainingSeconds} giây`;
        } else if (minutes > 0) {
            return `${minutes} phút ${remainingSeconds} giây`;
        } else {
            return `${remainingSeconds} giây`;
        }
    }
});

$(document).ready(()=>{
    let phoneContact = $('.btn_call_voip').attr('data-phone');
    $.ajax({
        url: baseUrlVoip24 + callHistoryApi+'?callee='+phoneContact,
        type: 'GET',
        headers: {
            'Authorization': localStorage.getItem('token_voip')
        },
        success: (res)=>{
            if(res.status == 200){
                $('.total_data_call').html(res.totalData)
            } else{
                console.log("ERR: ", res);
            }
        },
        error: (jqXHR, textStatus, errorThrown)=>{
            console.log('jqXHR: ', jqXHR);
            console.log('textStatus: ', textStatus);
            console.log('errorThrown: ', errorThrown);
        }
    })
});