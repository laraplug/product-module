<?php

namespace Modules\Product\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateProductRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'category_id' => 'required',
            'type' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'name' => 'required',
            'sale_price' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'category_id.required' => trans('product::products.messages.category_id is required'),
            'type.required' => trans('product::products.messages.type is required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'name.required' => trans('product::products.messages.name is required'),
            'sale_price.required' => trans('product::products.messages.sale_price is required'),
        ];
    }
}
