<?php

namespace Database\Seeders;

use App\Models\Permissions;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    use General;
    public function run(): void
    {
        DB::table('permissions')->delete();
        $dem = Permissions::count();
        if($dem <= 0) {
            $data_parent = [                
                ['id' => 1, 'name' => 'Quản lý sinh viên tiềm năng', 'router_name' => 'Leads.data', 'router_web_name' => 'Leads.data' , 'display_name' => 'Quản lý sinh viên tiềm năng', 'slug' => 'Quan_ly_sinh_vien_tiem_nang_1'],
                ['id' => 7, 'name' => 'Quản lý sinh viên chính thức', 'router_name' => 'Students.data', 'router_web_name' => 'Students.data', 'display_name' => 'Quản lý sinh viên chính thức', 'slug' => 'Quan_ly_sinh_vien_chinh_thuc_7'],
                ['id' => 13, 'name' => 'Quản lý thông báo', 'router_name' => 'Notifications.data', 'router_web_name' => 'Notifications.data', 'display_name' => 'Quản lý thông báo', 'slug' => 'Quan_ly_thong_bao_13'],
                ['id' => 19, 'name' => 'Quản lý nhân sự', 'router_name' => 'PriceLists.data', 'router_web_name' => '', 'display_name' => 'Quản lý nhân sự', 'slug' => 'Quan_ly_nhan_su'],
                ['id' => 25, 'name' => 'Quản lý giao việc', 'router_name' => 'Kpis.data', 'router_web_name' => 'Kpis.data', 'display_name' => 'Quản lý giao việc', 'slug' => 'Quan_ly_Kpis_25'],
                ['id' => 31, 'name' => 'Quản lý cấu hình', 'router_name' => 'Configs.data', 'router_web_name' => 'Configs.data', 'display_name' => 'Quản lý cấu hình', 'slug' => 'Quan_ly_cau_hinh_31'],
                ['id' => 42, 'name' => 'Quản lý đơn vị liên kết', 'router_name' => '', 'router_web_name' => '', 'display_name' => 'Quản lý đơn vị liên kết', 'slug' => 'Quan_ly_don_vi_lien_ket'],
                ['id' => 45, 'name' => 'Khóa tuyển sinh', 'router_name' => '', 'router_web_name' => '', 'display_name' => 'Khóa tuyển sinh', 'slug' => 'Quan_ly_nien_khoa'],
                ['id' => 48, 'name' => 'Quản lý nhóm', 'router_name' => '', 'router_web_name' => '', 'display_name' => 'Quản lý nhóm', 'slug' => 'Quan_ly_nhom'],
                ['id' => 51, 'name' => 'Quản lý giao dịch', 'router_name' => '', 'router_web_name' => '', 'display_name' => 'Quản lý giao dịch', 'slug' => 'Quan_ly_giao_dich'],
                ['id' => 55, 'name' => 'Quản lý yêu cầu hỗ trợ', 'router_name' => '', 'router_web_name' => '', 'display_name' => 'Quản lý yêu cầu hỗ trợ', 'slug' => 'Quan_ly_yeu_cau_ho_tro'],
                ['id' => 58, 'name' => 'Quản lý tổng đài', 'router_name' => '', 'router_web_name' => '', 'display_name' => 'Quản lý tổng đài', 'slug' => 'Quan_ly tong đai'],
            ];     
            $data_child = [
                // Quản lý sinh viên tiềm năng
                ['id' => 2, 'name' => 'Xem', 'router_name' => 'Leads.data', 'router_web_name' => 'crm.leads.index', 'display_name' => 'Xem', 'slug' => 'Xem_rieng_2', 'parent_id' => 1],
                ['id' => 3, 'name' => 'Xem chi tiết', 'router_name' => 'Leads.all', 'router_web_name' => 'crm.lead.detail', 'display_name' => 'Xem chi tiết', 'slug' => 'Xem_chung_3', 'parent_id' => 1],
                ['id' => 4, 'name' => 'Tạo', 'router_name' => 'Leads.create', 'router_web_name' => 'crm.lead.create_lead', 'display_name' => 'Tạo', 'slug' => 'Tao_4', 'parent_id' => 1],
                ['id' => 5, 'name' => 'Sửa', 'router_name' => 'Leads.update', 'router_web_name' => 'crm.lead.edit_lead', 'display_name' => 'Sửa', 'slug' => 'Sua_5', 'parent_id' => 1],
                ['id' => 6, 'name' => 'Xóa', 'router_name' => 'Leads.delete', 'router_web_name' => 'crm.leads.delete', 'display_name' => 'Xóa', 'slug' => 'Xoa_6', 'parent_id' => 1],
                // quản lý sinh viên chính thức
                ['id' => 8, 'name' => 'Xem', 'router_name' => 'Students.data', 'router_web_name' => 'crm.official.student', 'display_name' => 'Xem', 'slug' => 'Xem_rieng_8', 'parent_id' => 7],
                ['id' => 9, 'name' => 'Xem chi tiết', 'router_name' => 'Students.all', 'router_web_name' => 'crm.student.detail', 'display_name' => 'Xem chi tiết', 'slug' => 'Xem_chung_9', 'parent_id' => 7],
                ['id' => 10, 'name' => 'Tạo', 'router_name' => 'Students.create', 'router_web_name' => 'crm.student.create', 'display_name' => 'Tạo', 'slug' => 'Tao_10', 'parent_id' => 7],
                ['id' => 11, 'name' => 'Sửa', 'router_name' => 'Students.update', 'router_web_name' => 'crm.student.edit', 'display_name' => 'Sửa', 'slug' => 'Sua_11', 'parent_id' => 7],
                // ['id' => 12, 'name' => 'Xóa', 'router_name' => 'Students.delete', 'router_web_name' => 'crm.student.delete', 'display_name' => 'Xóa', 'slug' => 'Xoa_12', 'parent_id' => 7],
                // Quản lý Thông báo
                ['id' => 14, 'name' => 'Xem', 'router_name' => 'Notifications.data', 'router_web_name' => 'crm.notification.list', 'display_name' => 'Xem', 'slug' => 'Xem_rieng_14', 'parent_id' => 13],
                ['id' => 15, 'name' => 'Xem chi tiết', 'router_name' => 'Notifications.all', 'router_web_name' => 'crm.notification.detail', 'display_name' => 'Xem chi tiết', 'slug' => 'Xem_chung_15', 'parent_id' => 13],
                ['id' => 16, 'name' => 'Tạo', 'router_name' => 'Notifications.create', 'router_web_name' => 'crm.notification.create', 'display_name' => 'Tạo', 'slug' => 'Tao_16', 'parent_id' => 13],
                // ['id' => 17, 'name' => 'Sửa', 'router_name' => 'Notifications.update', 'router_web_name' => 'crm.notification.edit', 'display_name' => 'Sửa', 'slug' => 'Sua_17', 'parent_id' => 13],
                ['id' => 18, 'name' => 'Xóa', 'router_name' => 'Notifications.delete', 'router_web_name' => 'crm.notification.delete', 'display_name' => 'Xóa', 'slug' => 'Xoa_18', 'parent_id' => 13],
                // Quản lý nhân sự
                ['id' => 20, 'name' => 'Xem', 'router_name' => 'employees.index', 'router_web_name' => 'crm.employees.list', 'display_name' => 'Xem', 'slug' => 'Xem_rieng_20', 'parent_id' => 19],
                ['id' => 21, 'name' => 'Xem chi tiết', 'router_name' => 'employees.details', 'router_web_name' => 'crm.employee.detail', 'display_name' => 'Xem chi tiết', 'slug' => 'Xem_chung_21', 'parent_id' => 19],
                ['id' => 22, 'name' => 'Tạo', 'router_name' => 'employees.create', 'router_web_name' => 'crm.employees.create', 'display_name' => 'Tạo', 'slug' => 'Tao_22', 'parent_id' => 19],
                ['id' => 23, 'name' => 'Sửa', 'router_name' => 'employees.update', 'router_web_name' => 'crm.employees.edit', 'display_name' => 'Sửa', 'slug' => 'Sua_23', 'parent_id' => 19],
                ['id' => 24, 'name' => 'Xóa', 'router_name' => 'employees.delete', 'router_web_name' => 'crm.employees.delete', 'display_name' => 'Xóa', 'slug' => 'Xoa_24', 'parent_id' => 19],
                // Quản lý giao việc
                ['id' => 26, 'name' => 'Xem', 'router_name' => 'Task.list', 'router_web_name' => 'crm.task.list', 'display_name' => 'Xem', 'slug' => 'Xem_rieng_26', 'parent_id' => 25],
                // ['id' => 27, 'name' => 'Xem chi tiết', 'router_name' => 'Kpis.all', 'router_web_name' => 'crm.task.target.detail', 'display_name' => 'Xem chi tiết', 'slug' => 'Xem_chung_27', 'parent_id' => 25],
                ['id' => 28, 'name' => 'Tạo', 'router_name' => 'Tasks.create', 'router_web_name' => 'crm.task.target.create', 'display_name' => 'Tạo', 'slug' => 'Tao_28', 'parent_id' => 25],
                ['id' => 29, 'name' => 'Sửa', 'router_name' => 'Tasks.update', 'router_web_name' => 'crm.task.target.edit', 'display_name' => 'Sửa', 'slug' => 'Sua_29', 'parent_id' => 25],
                ['id' => 30, 'name' => 'Xóa', 'router_name' => 'Tasks.delete', 'router_web_name' => 'crm.task.target.delete', 'display_name' => 'Xóa', 'slug' => 'Xoa_30', 'parent_id' => 25],
                // Quản lý Cấu hình hệ thống
                ['id' => 32, 'name' => 'Trình độ học vấn', 'router_name' => '', 'router_web_name' => 'crm.education.type', 'display_name' => 'Xem chi tiết', 'slug' => 'Xem_chung_33', 'parent_id' => 31],
                ['id' => 33, 'name' => 'Phân quyền', 'router_name' => 'Configs.create', 'router_web_name' => 'crm.role.roleList', 'display_name' => 'Tạo', 'slug' => 'Tao_34', 'parent_id' => 31],
                ['id' => 34, 'name' => 'Chỉ tiêu tuyển sinh', 'router_name' => '', 'router_web_name' => 'crm.task.target', 'display_name' => 'Chỉ tiêu tuyển sinh', 'slug' => '', 'parent_id' => 31],
                ['id' => 35, 'name' => 'Thông báo học phí', 'router_name' => '', 'router_web_name' => 'crm.notification.pricelist', 'display_name' => 'Thông báo học phí', 'slug' => '', 'parent_id' => 31],
                ['id' => 36, 'name' => 'Quản lý mẫu mail', 'router_name' => '', 'router_web_name' => 'crm.system.email', 'display_name' => 'Quản lý mẫu mail', 'slug' => '', 'parent_id' => 31],
                ['id' => 37, 'name' => 'Quản lý trạng thái', 'router_name' => '', 'router_web_name' => 'crm.system.status', 'display_name' => 'Quản lý trạng thái', 'slug' => '', 'parent_id' => 31],
                ['id' => 38, 'name' => 'Trường tùy chỉnh', 'router_name' => '', 'router_web_name' => 'crm.custom.field', 'display_name' => 'Trường tùy chỉnh', 'slug' => '', 'parent_id' => 31],
                ['id' => 39, 'name' => 'Nguồn tiếp cận', 'router_name' => '', 'router_web_name' => 'crm.system.sources', 'display_name' => 'Nguồn tiếp cận', 'slug' => '', 'parent_id' => 31],
                ['id' => 40, 'name' => 'Ngành và tổ hợp môn', 'router_name' => '', 'router_web_name' => 'crm.major.subject', 'display_name' => 'Ngành và tổ hợp môn', 'slug' => '', 'parent_id' => 31],
                ['id' => 41, 'name' => 'Cấu hình chung', 'router_name' => '', 'router_web_name' => 'crm.general.configuration', 'display_name' => 'Cấu hình chung', 'slug' => 'Cau_hinh_chung', 'parent_id' => 31],
                // Quản lý đơn vị liên kết
                ['id' => 43, 'name' => 'Xem (Thêm, xóa)', 'router_name' => '', 'router_web_name' => 'crm.affiliate.sources', 'display_name' => 'Xem (Thêm, xóa)', 'slug' => '', 'parent_id' => 42],
                ['id' => 44, 'name' => 'Xem chi tiết (Sửa)', 'router_name' => '', 'router_web_name' => 'crm.affiliate.detail', 'display_name' => 'Xem chi tiết (Sửa)', 'slug' => '', 'parent_id' => 42],
                
                ['id' => 46, 'name' => 'Xem (Thêm, xóa)', 'router_name' => '', 'router_web_name' => 'crm.academic.terms', 'display_name' => 'Xem (Thêm, xóa)', 'slug' => '', 'parent_id' => 45],
                // ['id' => 47, 'name' => 'Xem chi tiết', 'router_name' => '', 'router_web_name' => 'crm.academic.semesters', 'display_name' => 'Xem chi tiết (Sửa)', 'slug' => '', 'parent_id' => 45],
                // Quản lý nhóm
                ['id' => 49, 'name' => 'Xem', 'router_name' => '', 'router_web_name' => 'crm.notification.groups', 'display_name' => 'Xem (Sửa, xóa)', 'slug' => '', 'parent_id' => 48],
                ['id' => 50, 'name' => 'Xem chi tiết', 'router_name' => '', 'router_web_name' => 'crm.notification.groupsDetail', 'display_name' => 'Xem chi tiết (Thêm, xóa)', 'slug' => '', 'parent_id' => 48],
                // Quản lý giao dịch
                ['id' => 52, 'name' => 'Thêm', 'router_name' => 'transactions.create', 'router_web_name' => 'crm.lead.transaction', 'display_name' => 'Thêm', 'slug' => '', 'parent_id' => 51],
                ['id' => 53, 'name' => 'Sửa', 'router_name' => 'transactions.update', 'router_web_name' => 'crm.transaction.detail', 'display_name' => 'Sửa', 'slug' => '', 'parent_id' => 51],
                ['id' => 54, 'name' => 'Xóa', 'router_name' => 'transactions.delete', 'router_web_name' => 'crm.transaction.delete', 'display_name' => 'Xóa', 'slug' => '', 'parent_id' => 51],
                // Quản lý yêu cầu hỗ trợ
                ['id' => 56, 'name' => 'Xem', 'router_name' => 'transactions.delete', 'router_web_name' => 'crm.request.support', 'display_name' => 'Xem', 'slug' => '', 'parent_id' => 55],
                ['id' => 57, 'name' => 'Xem chi tiết', 'router_name' => 'transactions.delete', 'router_web_name' => 'crm.detail.support', 'display_name' => 'Xem chi tiết', 'slug' => '', 'parent_id' => 55],
                // Quản lý tổng đài
                ['id' => 59, 'name' => 'Quản lý tổng đài', 'router_name' => '', 'router_web_name' => 'crm.voip24h.list', 'display_name' => 'Quản lý tổng đài', 'slug' => '', 'parent_id' => 58],

            ];                  
            Permissions::insert($data_parent);
            Permissions::insert($data_child);
        } 
    }
}
