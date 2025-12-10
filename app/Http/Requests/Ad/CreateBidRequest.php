<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

class CreateBidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'amount.min' => 'Bid amount must be at least 1.',
        ];
    }
}
