<?php

namespace Modules\Product\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'slug' => 'required|string',
            'status' => 'required|string',
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
            'slug.required' => trans('product::categories.messages.slug is required'),
            'status.required' => trans('product::categories.messages.status is required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'name.required' => trans('product::categories.messages.name is required'),
        ];
    }
}
