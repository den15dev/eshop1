<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // All authorization checks are performed in the 'admin' middleware
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [];
    }


    public function flashMessage($message): void
    {
        if ($message) {
            $this->session()->flash('message', [
                'type' => 'info',
                'content' => $message,
                'align' => 'center',
            ]);
        }
    }
}
