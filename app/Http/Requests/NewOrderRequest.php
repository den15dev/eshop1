<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewOrderRequest extends FormRequest
{
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
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'min:2', 'max:100'],
            'phone' => ['required', 'regex:/^\+?[0-9]{0,3}[\s-]{0,2}\(?[0-9]{3}\)?[\s-]{0,2}[0-9]{3}[\s-]?[0-9]{2}[\s-]?[0-9]{2}$/'],
            'email' => ['nullable', 'email:rfc,dns', 'max:100'],
        ];

        if ($this->input('delivery_type') === 'delivery') {
            $rules['delivery_address'] = ['required', 'min:7'];
        }

        return $rules;
    }
}
