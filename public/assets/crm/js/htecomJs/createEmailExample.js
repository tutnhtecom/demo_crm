import { baseUrl }                from '/assets/crm/js/htecomJs/variableApi.js';
import { createExampleEmailApi }  from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError }            from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError }      from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#email_template_content',
            menubar: true,
            plugins: [
                'lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount',
                'table'
            ],
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media charmap | code preview fullscreen | table',
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
        });
    });

    

    $('#email_template_btn_submit').on('click',()=>{
        const api     = baseUrl+createExampleEmailApi;
        const token   = localStorage.getItem('jwt_token');
        let types_id  = $('#email_template_type').val();
        let title     = $('#email_template_title').val();
        let content   = tinymce.get('email_template_content').getContent();
        let file_name = $('#email_template_fileName').val();
        let is_default = $('#email_template_default').is(':checked') ? 1 : 0;
        let formData  = new FormData();

        formData.append('types_id', types_id);
        formData.append('title', title);
        formData.append('content', content);
        formData.append('file_name', file_name);
        formData.append('is_default', is_default);

        // $('#email_template_btn_submit').html('Đang lưu...');
        $('#email_template_btn_submit').prop('disabled', true).html('Đang lưu...');

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
                        window.location.reload();
                    }, 1000);
                }
                // $('#email_template_btn_submit').html('Lưu');
            },
            error: (xhr, status, error) => {
                console.log(error);
            },
            complete: () => {
                // Enable nút và khôi phục text
                $('#email_template_btn_submit').prop('disabled', false).html('Lưu');
            }
        })
    })

    // $('.btn_guide_key').on('click', function() {
    //     $('.table_note_guide').slideToggle(300); // 300ms là thời gian hiệu ứng
    // });

    // $(document).on("click", ".btn_guide_key", function () {
    //     $(".key_email_template").toggle(); // Ẩn/Hiện modal khi click
    // });

    $(document).on("click", ".btn_guide_key", function () {
        let modalElement = $(".key_email_template");

        if (modalElement.hasClass("show")) {
            modalElement.modal("hide");
        } else {
            modalElement.modal("show");
        }
    });

    document.addEventListener('focusin', (e) => {
        if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
            e.stopImmediatePropagation();
        }
    });
})
