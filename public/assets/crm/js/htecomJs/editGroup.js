import { baseUrl }              from '/assets/crm/js/htecomJs/variableApi.js';
import { editDetailGroupApi }  from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    const userEmployees = window.userEmployees;
    const userLeads     = window.userLeads;
    const mergedArray   = userEmployees.concat(userLeads);
    const $emailInput   = $('#input_add_email');
    const $nameDisplay  = $('#nameDisplay');

    $emailInput.on('input', function () {
        const email = $emailInput.val().trim().toLowerCase();

        if (email === "") {
            $nameDisplay.text("");
        } else {
            const user = mergedArray.find(user => user.email.toLowerCase() === email);

            if (user) {
                const displayName = user.full_name ? user.full_name : user.name;
                const displayId = user.id;
                let list_ids = [];
                $('.email-item .name_member_group').each(function() {
                    list_ids.push($(this).data('id'));
                });
                if (!list_ids.includes(displayId)) {
                    $nameDisplay.text(`Tên: ${displayName}, ID: ${displayId}`).css('color', 'green');
                    $('.btn_add_info_group').prop('disabled', false);
                }else{
                    $nameDisplay.text(`Tên: ${displayName}, ID: ${displayId} đã tồn tại trong nhóm`).css('color', 'red');
                    $('.btn_add_info_group').prop('disabled', true);
                }

            } else {
                $nameDisplay.text('Email không tồn tại').css('color', 'red');
            }
        }
    });

    $(document).on('click', '.btn_add_info_group', function () {
        const email = $emailInput.val().trim().toLowerCase();
        if (email !== "") {
            const user = mergedArray.find(user => user.email.toLowerCase() === email);
            if(user){
                const idUser = user.id;
                const displayName = user.full_name ? user.full_name : user.name;
                const newItem = `
                <div class="email-item d-flex align-items-center justify-content-between col-md-4 mb-3">
                    <div class="d-flex align-items-center justify-content-between" style="border:1px solid #ccc;border-radius:10px;width:100%;padding: 0 10px;">
                        <span class="name_member_group" data-id="${idUser}">${displayName}</span>
                        <div>
                            <a href="${baseUrl}/crm/leads/detail_lead/${idUser}" class="btn btn-ghost p-1">
                                <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18" height="18">
                            </a>
                            <button type="button" class="btn btn-ghost btn_delete_member" style="padding:10px 5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path opacity="0.3" d="M3.07457 14.6309L2.57129 7.58495H15.4284L14.9252 14.6309C14.8427 15.7852 14.0005 16.7541 12.8535 16.9074C10.2811 17.2512 7.71863 17.2512 5.14624 16.9074C3.99919 16.7541 3.15702 15.7852 3.07457 14.6309Z" fill="#FF5630" />
                                    <path d="M2.57129 7.58495L3.07457 14.6309C3.15702 15.7852 3.99919 16.7541 5.14624 16.9074C7.71863 17.2512 10.2811 17.2512 12.8535 16.9074C14.0005 16.7541 14.8427 15.7852 14.9252 14.6309L15.4284 7.58495" stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M0.963867 4.46799H17.0353" stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5.78516 4.37067L6.4118 2.64741C6.80748 1.5593 7.8416 0.834961 8.99944 0.834961C10.1573 0.834961 11.1914 1.5593 11.5871 2.64741L12.2137 4.37067" stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 8.65566V13.8732" stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.4692 11.0651C10.6233 10.0725 10.1003 9.52244 9.1471 8.71707C9.05314 8.63767 8.91594 8.63491 8.81914 8.71082C7.87442 9.45174 7.34105 10.0055 6.47363 11.0651" stroke="#FF5630" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                `;
                $('.list_member_in_group').append(newItem);
                $('#input_add_email').val('');
                $nameDisplay.text("");
            }
        }
    })

    $(document).on('click', '.btn_delete_member', function () {
        $(this).closest('.email-item').remove();
    });

    $('#btn_edit_group_detail').on('click', (e)=>{
        const idGroup  = $(e.currentTarget).data('id');
        const api      = baseUrl+editDetailGroupApi+idGroup;
        const token    = localStorage.getItem('jwt_token');
        let nameGroup  = $('#name_group').val();
        let list_ids   = [];
        $('.email-item .name_member_group').each(function() {
            list_ids.push($(this).data('id'));
        });
        list_ids = list_ids.filter(id => id && String(id).trim() !== "");
        $(e.currentTarget).html('Đang cập nhật...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"    : nameGroup,
                "list_id" : list_ids
            },
            success: (res) => {
                if(res.code == 422){
                    $.notify(res.message, "error");
                } else{
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                $(e.currentTarget).html('Cập nhật');
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    })

  
})
