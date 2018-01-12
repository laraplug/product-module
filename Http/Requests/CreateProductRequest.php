<?php

namespace Modules\Product\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateProductRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'productable_type' => 'required',
            'category_id' => 'required',
            'sale_price' => 'required',
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
            'productable_type.required' => trans('product::products.messages.productable_type is required'),
            'category_id.required' => trans('product::products.messages.category_id is required'),
            'sale_price.required' => trans('product::products.messages.sale_price is required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'name.required' => trans('product::products.messages.name is required'),
        ];
    }
}
