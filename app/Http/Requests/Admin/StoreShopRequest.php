<?php

namespace App\Http\Requests\Admin;


class StoreShopRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [];

        $rules['is_active'] = ['in:0,1'];
        $rules['name'] = ['required', 'min:2', 'max:60'];
        $rules['sort'] = ['required', 'integer'];
        $rules['address'] = ['required', 'min:2', 'max:150'];
        $rules['location'] = ['required', 'regex:/^\[?\s?\d{1,3}\.\d+\s?,\s?\d{1,3}\.\d+\s?\]?$/'];
        $rules['opening_hours'] = ['required', 'min:21', 'max:150'];
        $rules['info'] = ['required', 'min:30'];

        return $rules;
    }


    public function attributes(): array
    {
        return [
            'name' => 'Название',
            'info' => 'Информация',
            'location' => 'Координаты',
            'opening_hours' => 'Часы работы',
        ];
    }
}
