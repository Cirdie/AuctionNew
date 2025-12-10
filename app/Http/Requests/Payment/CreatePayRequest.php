<?php


namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class CreatePayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method'  => ['required', 'in:COD,GCASH'],
            'address_details' => ['required', 'string', 'max:500'],
            'country'         => ['nullable', 'string', 'max:100'],
            'province'        => ['nullable', 'string', 'max:150'],
            'province_code'   => ['nullable', 'string', 'max:50'],
            'city'            => ['nullable', 'string', 'max:150'],
            'city_code'       => ['nullable', 'string', 'max:50'],
            'barangay'        => ['nullable', 'string', 'max:150'],
            'barangay_code'   => ['nullable', 'string', 'max:50'],
            'proof_image'     => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
                'required_if:payment_method,GCASH',
            ],
        ];
    }
}
