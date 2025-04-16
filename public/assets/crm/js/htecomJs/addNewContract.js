import { baseUrl, createContractApi }      from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate }                       from '/assets/crm/js/htecomJs/lead.js';
import { handleError, handleRemoveError }   from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('click', '#contract_btn_create', (e)=>{
        const btn        = $(e.currentTarget);
        const idContract = btn.attr('data-id');
        const api        = baseUrl+createContractApi;
        const token      = localStorage.getItem('jwt_token');
        btn.html('Đang lưu...');

        let contract_name           = $('#contract_signed_document').val();
        let contract_description    = $('#contract_signed_content').val();
        let contract_start_date     = formatDate($('#contract_date_start').val());
        let contract_end_date       = formatDate($('#contract_date_end').val());

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "sources_id"        : idContract,
                "signed_document"   : contract_name,
                "signed_content"    : contract_description,
                "signed_from_date"  : contract_start_date,
                "signed_to_date"    : contract_end_date
            },
            success: (res)=>{
                if(res.code == 422){
                    handleError('#contract_signed_content', '.contract_signed_content_wrapper', res.data.signed_content);
                    handleError('#contract_date_start', '.contract_date_start_wrapper', res.data.signed_from_date);
                    handleError('#contract_date_end', '.contract_date_end_wrapper', res.data.signed_to_date);
                    handleError('#contract_signed_document', '.contract_signed_document_wrapper', res.data.signed_document);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        // window.location.reload();
                        document.location.reload();
                    }, 1000);
                }
                btn.html('Lưu');
            },
            error: (res)=>{
                console.log(res);
            }
        })
    })
    handleRemoveError('.contract_signed_content_wrapper', '#contract_signed_content');
    handleRemoveError('.contract_date_start_wrapper', '#contract_date_start');
    handleRemoveError('.contract_date_end_wrapper', '#contract_date_end');
    handleRemoveError('.contract_signed_document_wrapper', '#contract_signed_document');
})
