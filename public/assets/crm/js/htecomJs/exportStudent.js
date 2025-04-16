import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { exportStudentApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    let rm_fields =  [];
    let fields = [
        {'field_name' : 'id',  'display_name'                  :'ID'},
        {'field_name' : 'full_name','display_name'             :'Họ và tên'},                
        {'field_name' : 'students_code','display_name'         :'Mã số sinh viên'},
        {'field_name' : 'phone','display_name'                 :'Số điện thoại'},
        {'field_name' : 'email','display_name'                 :'Email'},
        {'field_name' : 'gender','display_name'                :'Giới tính'},
        {'field_name' : 'date_of_birth','display_name'         :'Ngày sinh'},
        {'field_name' : 'identification_card','display_name'   :'CMND/CCCD'},
        {'field_name' : 'lst_status_id','display_name'         :'Tình trạng tư vấn'},
        {'field_name' : 'sources_id','display_name'            :'Nguồn'},
        {'field_name' : 'tags_id','display_name'               :'Gắn thẻ'},
        {'field_name' : 'created_time','display_name'          :'Ngày tạo'},
        {'field_name' : 'marjors_name','display_name'          :'Ngành học quan tâm'},
        {'field_name' : 'assignments_id','display_name'        :'Tư vấn viên phụ trách'},
        {'field_name' : 'contacts_dcll','display_name'         :'Địa chỉ liên lạc'},                
        {'field_name' : 'contacts_hktt','display_name'         :'Hộ khẩu thường trú'},   
        {'field_name' : 'father_name','display_name'           :'Họ và tên Cha'},
        {'field_name' : 'father_phone','display_name'          :'Số điện thoại Cha'},
        {'field_name' : 'mother_name','display_name'           :'Họ và tên Mẹ'},
        {'field_name' : 'mother_phone','display_name'          :'Số điện thoại Mẹ'},
        {'field_name' : 'method_name','display_name'           :'Phương thức xét tuyển'},     
        {'field_name' : 'academy_list_name','display_name'     :'Khóa tuyển sinh'},     
        {'field_name' : 'total_price_lists','display_name'     :'Tổng học phí phải đóng'},
        {'field_name' : 'total_transactions','display_name'    :'Tổng học phí đã đóng'}
    ];
    $('#btn_export_students').click(function(){
        const api = baseUrl+exportStudentApi;
        const token = localStorage.getItem('jwt_token');          
        let keywords = $('#search-table-students').val();
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var file_name = 'danh_sach_sinh_vien_chinh_thuc_' + d.getFullYear() +
        (month<10 ? '0' : '') + month +
        (day<10 ? '0' : '') + day;     
        
        let from_date = $('#filter-start-date').html() ? $('#filter-start-date').html() : "";
        let to_date = $('#filter-end-date').html() ? $('#filter-end-date').html() : "";
        let sources_id = $('#sources-filter').val();
        let lst_status_id = $('#status-filter').val();
        let tags_id = $('#tags-filter').val();
        let marjors_id = $('#marjor-filter').val();
        let assignments_id = $('#assignment-filter').val();

        let data = {
            "keyword"       : keywords,
            "sources_id"    : sources_id,
            "lst_status_id" : lst_status_id,
            "tags_id"       : tags_id,
            "marjors_id"    : marjors_id,
            "assignments_id": assignments_id,
            "from_date"     : from_date,
            "to_date"       : to_date,
            "fields"        : fields,
            "rm_fields"     : rm_fields
        }    
        
        if(rm_fields.length >= fields.length) {
            $.notify("Vui lòng chọn tối thiểu 1 trường dữ liệu để xuất file", "error");
            return false;   
        }

        $.ajax({
            url: api,
            type: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
                'Authorization': 'Bearer '+token
            },
            data:data,
            success: function(res){
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(res);
                a.href = url;
                a.download = file_name;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            },
            error: function(error){
                // Handle the error here
            }
        });
    });
    $(document).on('change', 'input[name="check-field"]', function(){ 
        const fieldValue = this.getAttribute("data-field");
        if (!this.checked) {
            // Nếu checkbox được chọn, thêm giá trị vào mảng (nếu chưa có)
            if (!rm_fields.includes(fieldValue)) {
                rm_fields.push(fieldValue);
            }
        } else {
            // Nếu bỏ chọn, xóa giá trị khỏi mảng
            rm_fields = rm_fields.filter(field => field !== fieldValue);
        }        
    });

    $(document).on('click', '#s_selectAll', (e)=>{
        const idForm = $(e.currentTarget).attr('data-id-form');
        $(`#form-checkout-fields .checkbox`).prop('checked', true);
        rm_fields = [];
    })
    $(document).on('click', '#s_unSelectAll', (e)=>{        
        const idForm = $(e.currentTarget).attr('data-id-form');
        $(`#form-checkout-fields .checkbox`).prop('checked', false);
        rm_fields = [];
        fields.forEach(e => {
            rm_fields.push(e.field_name);
        });
    })
})