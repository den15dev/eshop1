<?php

namespace App\Http\Requests\Admin;

use Closure;

class StoreProductRequest extends BaseRequest
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

        $image_rules = [
            'nullable',
            'max:5120',
            'dimensions:max_width=5000,max_height=5000',
            function (string $attribute, mixed $value, Closure $fail) {
                $min_size = 1400;
                $img_index = explode('.', $attribute)[1];
                if (getimagesize($value->getPathname())[0] < $min_size && getimagesize($value->getPathname())[1] < $min_size) {
                    $fail("Размер изображения {$img_index} должен быть минимум {$min_size} px по одной из сторон.");
                }
            },
        ];

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
