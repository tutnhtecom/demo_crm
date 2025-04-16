export function formatDate(inputDate) {
    const dateObj = new Date(inputDate);

    if (isNaN(dateObj.getTime())) {
        return null; // Nếu không hợp lệ, trả về null hoặc thông báo lỗi
    }

    const day = String(dateObj.getDate()).padStart(2, '0'); // Đảm bảo 2 chữ số
    const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
    const year = dateObj.getFullYear();

    return `${day}/${month}/${year}`;
}

