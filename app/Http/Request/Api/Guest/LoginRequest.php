<?php

namespace App\Http\Request\Api\Guest;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Утасны дугаар оруулна уу.',
            'password.required' => 'Нууц үг оруулна уу.',
            'device_name.required' => 'Төхөөрөмжийн нэр байхгүй байна.',
        ];
    }
}
