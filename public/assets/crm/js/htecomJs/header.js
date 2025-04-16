import { baseUrl, getPopupNotiApi, updateIsOpenNotiApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    // remove_logout_btn_on_mobile();
    const api           = baseUrl+getPopupNotiApi;
    const token         = localStorage.getItem('jwt_token');
    
    $.ajax({
        url: api,
        type: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`
        },
        success: (res) => {
            if(res.code == 200){
                res.data.forEach(function(item) {
                    var backgroundColor = item.is_open === 0 ? 'rgba(230, 238, 246, 1)' : '#fff';
                    var menuItem = `<div class="menu-link px-5 notification-card" style="background: ${backgroundColor};">
                                        <a href="${baseUrl}/crm/notification/detail/${item.id}" class="link_detail_noti" data-id="${item.id}">
                                            <h4 class="mb-0 text-primary">${item.title}</h4>
                                            <div class="notification-card-content" style="color:#000;">
                                                ${item.content}
                                            </div>
                                            <span class="d-flex align-items-center gap-1 text-muted">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                    <path
                                                        d="M6.99984 3.5V7L9.33317 8.16666M12.8332 7C12.8332 10.2217 10.2215 12.8333 6.99984 12.8333C3.77818 12.8333 1.1665 10.2217 1.1665 7C1.1665 3.77834 3.77818 1.16666 6.99984 1.16666C10.2215 1.16666 12.8332 3.77834 12.8332 7Z"
                                                        stroke="#7E7E7E" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                ${item.created_at}
                                            </span>
                                        </a>
                                    </div>
                                    <div class="separator my-2"></div>`
                    $('.header-notification').prepend(menuItem);
                });
            }
        },
        error: (err) => {
            console.log('res:', err);
        }
    })

    $(document).on('click', '.link_detail_noti', (e)=>{
        const btn = $(e.currentTarget);
        const idNoti = btn.attr('data-id');
        const api = baseUrl+updateIsOpenNotiApi+idNoti;
        const token = localStorage.getItem('jwt_token');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data:{
                "is_open": 1
            },
            success: (res) => {
                if(res.code == 422){
                    console.log(res);
                } else{
                    console.log(res);
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    });

    function remove_logout_btn_on_mobile(){
        let isMobile = false;
        isMobile = localStorage.getItem('is_mobile');
        if(isMobile){
            $('.btn_logout_crm').remove();
        }

    }
})

