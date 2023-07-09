<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Models\Brand;

class StoreBrandRequest extends BaseRequest
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
            $rules['name'] = ['required', 'min:2', 'max:50'];
            $rules['slug'] = ['required', 'regex:/^[a-z0-9-]+$/', 'min:2', 'max:50', Rule::unique(Brand::class)->ignore($this->route('id'))];
            $rules['description'] = ['required', 'min:10'];
        }

        if ($this->has('image_form')) {
            $rules['image'] = ['required', 'dimensions:min_width=260'];
        }

        return $rules;
    }


    public function attributes(): array
    {
        return [
            'name' => 'Название',
            'slug' => 'Slug',
            'description' => 'Описание',
        ];
    }
}
