<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $rules = [];

        if ($this->has('name')) {
            $rules['is_active'] = ['in:0,1'];
            $rules['name'] = ['required', 'min:2', 'max:150'];
            $rules['short_descr'] = ['required', 'min:2', 'max:200'];
            $rules['brand_id'] = ['required', 'integer'];
            $rules['sku'] = ['nullable', 'min:2', 'max:150'];
            $rules['price'] = ['required', 'numeric'];
            $rules['discount_prc'] = ['required', 'integer'];
            $rules['final_price'] = ['required', 'numeric'];
            $rules['description'] = ['required', 'min:30'];
            $rules['promo_id'] = ['nullable', 'integer'];
        }

        $image_rules = ['nullable', 'max:5120', 'dimensions:min_width=1400,min_height=1400,max_width=5000,max_height=5000'];

        if ($this->has('images') || $this->hasFile('new_image')) {
            $rules['new_image'] = $image_rules;
            $rules['images'] = ['nullable'];
        }

        if ($this->hasFile('image_files')) {
            $rules['image_files.*'] = $image_rules;
        }

        if ($this->has('specs')) {
            $rules['specs'] = ['required', 'min:3'];
            $rules['category_id'] = ['required', 'integer'];
        }

        return $rules;
    }


    public function attributes(): array
    {
        return [
            'name' => 'Наименование',
            'discount_prc' => 'Скидка',
            'price' => 'Цена',
            'final_price' => 'Итоговая цена',
            'image_files.*' => ':index',
        ];
    }
}
