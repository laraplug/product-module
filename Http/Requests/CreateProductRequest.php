<?php

namespace Modules\Product\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateProductRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'shops' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'name' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'type.required' => trans('product::products.messages.type is required'),
            'category_id.required' => trans('product::products.messages.category_id is required'),
            'price.required' => trans('product::products.messages.price is required'),
            'shops.required' => trans('product::products.messages.shop is required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'name.required' => trans('product::products.messages.name is required'),
        ];
    }
}
