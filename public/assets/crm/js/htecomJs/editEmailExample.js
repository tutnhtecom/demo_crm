import { baseUrl }              from '/assets/crm/js/htecomJs/variableApi.js';
import { editExampleEmailApi }  from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    TI_Util.onDOMContentLoaded(() => {
        document.querySelectorAll('textarea.email_template_edit_content').forEach((textarea) => {
            tinymce.init({
                target: textarea,
                menubar: true,
                plugins: [
                    'lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media charmap | code preview fullscreen',
                toolbar_mode: 'floating',
                height: 500,
                image_advtab: true,
                images_upload_handler: function (blobInfo, success, failure) {
                    const token = localStorage.getItem('jwt_token');
                    const url = baseUrl + '/api/email-templates/upload-image';
                    const formData = new FormData();
                    formData.append('image', blobInfo.blob(), blobInfo.filename());

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        console.log('result', result);
                        if (result && result.location) {
                            success(result.location); // Trả về URL của hình ảnh
                        } else {
                            failure('Upload failed: Invalid response.');
                        }
                    })
                    .catch(error => {
                        failure('Upload failed: ' + error.message);
                    });
                },
                automatic_uploads: true,
                file_picker_types: 'image',
                file_picker_callback: function (callback, value, meta) {
                    if (meta.filetype === 'image') {
                        let input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');

                        input.onchange = function () {
                            let file = this.files[0];
                            let reader = new FileReader();
                            reader.onload = function () {
                                callback(reader.result, {
                                    alt: file.name
                                });
                            };
                            reader.readAsDataURL(file);
                        };

                        input.click();
                    }
                },
                setup: function(editor) {
                    $(document).on('click', '.btn-edit-email', function(){
                        let email_id = $(this).attr('data-id');
                        editor.setContent(JSON.parse(window[`contentEmail`+email_id]));
                    });
                }
            });
        });
    });

    $('.email_template_btn_edit').on('click',(e)=>{
        const idExample = $(e.currentTarget).data('id');
        const api       = baseUrl+editExampleEmailApi+idExample;
        const token     = localStorage.getItem('jwt_token');
        let types_id    = $('#email_template_edit_type_' + idExample).val();
        let title       = $('#email_template_edit_title_' + idExample).val();
        let content     = tinymce.get('email_template_edit_content_'+idExample).getContent();
        let file_name   = $('#email_template_edit_fileName_'+idExample).val();
        let formData    = new FormData();
        $(e.currentTarget).html('Đang lưu...');

        formData.append('types_id', types_id);
        formData.append('title', title);
        formData.append('content', content);
        formData.append('file_name', file_name);

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {
                if(res.code == 422){
                    if(res.data.types_id != null){
                        alert(res.data.types_id);
                    }
                    if(res.data.title != null){
                        alert(res.data.title);
                    }
                } else{
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        document.location.reload();
                        window.location.reload();
                    }, 1000);
                }
                $(e.currentTarget).html('Lưu');
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    })
})
