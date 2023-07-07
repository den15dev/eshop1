<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Models\Category;

class StoreCategoryRequest extends BaseRequest
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
            $rules['slug'] = ['required', 'regex:/^[a-z0-9-]+$/', 'min:2', 'max:50', Rule::unique(Category::class)->ignore($this->route('id'))];
            $rules['parent_id'] = ['integer'];
            $rules['sort'] = ['required', 'integer'];
        }

        if ($this->has('specs')) {
            $rules['specs'] = ['nullable', 'min:3'];
        }

        if ($this->has('image_form')) {
            $rules['image'] = ['required', 'dimensions:width=484,height=242'];
        }

        return $rules;
    }


    public function attributes(): array
    {
        return [
            'name' => 'Название',
            'slug' => 'Slug',
            'parent_id' => 'Родительская категория',
        ];
    }
}
