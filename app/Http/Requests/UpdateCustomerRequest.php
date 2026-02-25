<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('id') ?? $this->route('customer');

        return [
            'full_name'     => 'nullable|string|max:100',
            'email'         => "nullable|email|max:100|unique:customers,email,{$customerId}",
            'phone'         => "nullable|string|max:20|unique:customers,phone,{$customerId}|regex:/^(0|\+84)[0-9]{8,10}$/",
            'password'      => 'nullable|string|min:8',
            'id_card'       => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
            'province'      => 'nullable|string|max:100',
            'customer_type' => 'nullable|in:individual,business',
            'company_name'  => 'nullable|string|max:150',
            'tax_code'      => 'nullable|string|max:20',
        ];
    }
}