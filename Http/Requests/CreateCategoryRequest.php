<?php

namespace Modules\Product\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'status' => 'required',
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
