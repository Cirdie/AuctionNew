<?php

namespace App\Http\Requests\Profile;

use App\Enums\Gender;
use App\Traits\PasswordEnvironments;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateProfileRequest extends FormRequest
{
    use PasswordEnvironments;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
 public function rules(): array
{
    return [
        'first_name' => ['nullable', 'string', 'max:255', 'min:2'],
        'last_name'  => ['nullable', 'string', 'max:255', 'min:2'],

        // Phone format fix (to allow +63 only)
'mobile' => ['nullable', 'regex:/^\+63\s?\d{3}\s?\d{3}\s?\d{4}$/'],

        'gender' => ['nullable', new Enum(Gender::class)],
        'address' => ['nullable', 'string', 'max:255', 'min:2'],

        // NEW PH-only fields
        'country'        => ['required', 'in:PH'],
        'province'       => ['required', 'string'],
        'province_code'  => ['required', 'string'],
        'city'           => ['required', 'string'],
        'city_code'      => ['required', 'string'],
        'barangay'       => ['required', 'string'],
        'barangay_code'  => ['required', 'string'],

        'zip_code' => ['nullable', 'string', 'max:10', 'min:2'],

        'current_password' => $this->passwordRules(app()->environment(), false),
        'password' => [$this->passwordRules(app()->environment(), false), 'required_with:current_password'],
    ];
}


}
