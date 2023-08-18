<?php

namespace App\Http\Request\Api\Private;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_off' => 'required',
            'content_on' => 'required',
            'coupon' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'event_off.required' => 'Утасны дугаар оруулна уу.',
            'content_on.required' => 'Нууц үг оруулна уу.',
            'coupon.required' => 'Төхөөрөмжийн нэр байхгүй байна.',
        ];
    }
}
