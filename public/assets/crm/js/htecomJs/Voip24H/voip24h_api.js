export const baseUrlVoip24 = "https://api.voip24h.vn";

// --- Tìm kiếm cuộc gọi --- \\
export const callHistoryApi = "/v3/call/history";
    // ---------------------------------------------------------------------------------- 
    // dateStart    : Ngày bắt đầu lấy dữ liệu
    // dateEnd      : Ngày kết thúc lấy dữ liệu
    // status       : Trạng thái cuộc gọi(các trạng thái ngăn cách nhau bởi dấu ' , ')
    // type         : Loại cuộc gọi(các loại cuộc gọi ngăn cách nhau bởi dấu ',')
    // extension    : Chuỗi máy nhánh(các máy nhánh ngăn cách nhau bởi dấu ' , ')
    // did          : Đầu số gọi
    // callid       : Mã cuộc gọi trên tổng đài
    // id           : Mã id của cuộc gọi
    // offset       : Vị trí bắt đầu lấy dữ liệu
    // limit        : Số lượng dữ liệu được lấy
    // caller	    : Số điện thoại gọi
    // callee	    : Số điện nhận cuộc gọi
    // ---------------------------------------------------------------------------------- 
    // *** Ex: GET https://api.voip24h.vn/v3/call/history?offset=0&limit=2&extension=205 *** \\

// --- Nghe ghi âm --- \\
export const callRecordingApi = "/v3/call/recording";
    // callId : Mã id của cuộc gọi
    // *** Ex: GET https://api.voip24h.vn/v3/recording?callId=65f9b4aa4336cbd1158b4567 *** \\

