<?php

namespace App\Http\Requests\Admin;


class StorePromoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [];

        if ($this->has('name')) {
            $rules['name'] = ['required', 'min:2', 'max:150'];
            $rules['started_at'] = ['required', 'date'];
            $rules['until'] = ['required', 'date'];
            $rules['description'] = ['required', 'min:10'];
        }

        if ($this->has('image_form')) {
            $rules['image'] = ['required', 'dimensions:width=1296,height=500'];
        }

        if ($this->has('add_products')) {
            $rules['add_products'] = ['nullable', 'regex:/^[0-9,\- ]+$/'];
        }

        return $rules;
    }


    public function attributes(): array
    {
        return [
            'name' => 'Название',
            'started_at' => 'Дата начала',
            'until' => 'Дата окончания',
            'description' => 'Описание',
            'add_products' => 'Список товаров',
        ];
    }
}
