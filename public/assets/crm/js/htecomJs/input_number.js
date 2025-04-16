export function isNumber(event) {
    const charCode = event.which ? event.which : event.keyCode;
    // Chỉ cho phép nhập số (0-9)
    if (charCode < 48 || charCode > 57) return false;
    return true;
}