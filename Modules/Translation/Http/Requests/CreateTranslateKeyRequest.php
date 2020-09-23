<?php

namespace Modules\Translation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTranslateKeyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text_key' => 'required|string',
            'text_us' => 'required|string',
            'text_ga' => 'required|string',
            'mobile' => 'boolean'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
