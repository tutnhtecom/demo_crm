import { baseUrl, updateSourcesApi }        from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate }                       from '/assets/crm/js/htecomJs/lead.js';
import { handleError, handleRemoveError }   from '/assets/crm/js/htecomJs/lead.js';

$(document).on('click', '.contract_edit_modal', function(){
    // Lấy giá trị từ data-signed-document
    const signedDocument = $(this).attr('data-signed-document');
    const signedContent = $(this).attr('data-signed-content');
    const signedFromDate = $(this).attr('data-signed-from-date');
    const signedToDate = $(this).attr('data-signed-to-date');
    const dataId = $(this).attr('data-id');

    // Gán giá trị vào input với id là 'contract_edit_signed_document'    
    $('#contract_edit_signed_document').val(signedDocument);
    $('#contract_edit_signed_content').val(signedContent);
    $('#contract_edit_date_start').val(signedFromDate);
    $('#contract_edit_date_end').val(signedToDate);
    $('#contract_btn_edit').attr('data-id', dataId);
});

$(document).on('click', '#contract_btn_edit', (e)=>{
    const btn               = $(e.currentTarget);
    const idContract        = btn.attr('data-id');
    const api               = baseUrl+updateSourcesApi+idContract;
    const token             = localStorage.getItem('jwt_token');

    let sources_id          = btn.attr('data-sources-id');
    let signed_document     = $('#contract_edit_signed_document').val();
    let signed_content      = $('#contract_edit_signed_content').val();
    let signed_from_date    = formatDate($('#contract_edit_date_start').val());
    let signed_to_date      = formatDate($('#contract_edit_date_end').val());
    btn.prop('disabled', true).html('Đang lưu...');

    $.ajax({
        url: api,
        type: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`
        },
        data: {
            "sources_id"        : sources_id,
            "signed_document"   : signed_document,
            "signed_content"    : signed_content,
            "signed_from_date"  : signed_from_date,
            "signed_to_date"    : signed_to_date
        },
        success: function (res) {
            if(res.code == 422){
                handleError('#contract_edit_signed_document', '.contract_edit_signed_document_wrapper', res.data.signed_document);
                handleError('#contract_edit_signed_content', '.contract_edit_signed_content_wrapper', res.data.signed_content);
                handleError('#contract_edit_date_start', '.contract_edit_date_start_wrapper', res.data.signed_from_date);
                handleError('#contract_edit_date_end', '.contract_edit_date_end_wrapper', res.data.signed_to_date);
            } else {
                $.notify(res.message, "success");
                setTimeout(function() {
                        window.location.reload();
                    }, 1000);
            }
            btn.prop('disabled', false).html('Lưu');
        },
        error: function (xhr, status, error) {
            btn.html('Lưu');
            console.log(xhr.responseText);
        }
    })
})
handleRemoveError('.contract_edit_signed_document_wrapper', '#contract_edit_signed_document');
handleRemoveError('.contract_edit_signed_content_wrapper', '#contract_edit_signed_content');
handleRemoveError('.contract_edit_date_start_wrapper', '#contract_edit_date_start');
handleRemoveError('.contract_edit_date_end_wrapper', '#contract_edit_date_end');
