<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'     => 'required|string|max:100',
            'email'         => 'required|email|max:100|unique:customers,email',
            'phone'         => 'required|string|max:20|unique:customers,phone|regex:/^(0|\+84)[0-9]{8,10}$/',
            'password'      => 'required|string|min:8',
            'id_card'       => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
            'province'      => 'nullable|string|max:100',
            'customer_type' => 'nullable|in:individual,business',
            'company_name'  => 'nullable|required_if:customer_type,business|string|max:150',
            'tax_code'      => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'  => 'Họ và tên là bắt buộc',
            'email.required'      => 'Email là bắt buộc',
            'email.unique'        => 'Email đã được sử dụng',
            'phone.required'      => 'Số điện thoại là bắt buộc',
            'phone.unique'        => 'Số điện thoại đã được sử dụng',
            'phone.regex'         => 'Số điện thoại không đúng định dạng Việt Nam',
            'password.required'   => 'Mật khẩu là bắt buộc',
            'password.min'        => 'Mật khẩu phải có ít nhất 8 ký tự',
            'company_name.required_if' => 'Tên công ty là bắt buộc với khách hàng doanh nghiệp',
        ];
    }
}