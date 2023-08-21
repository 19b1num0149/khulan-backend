<?php

namespace App\Http\Request\Api\Private;

use Illuminate\Foundation\Http\FormRequest;

class UserProfilePostRequest extends FormRequest
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
            'name' => 'required|max:10',
            'phone' => 'required|max:255',
            'address' => 'nullable',
            'age' => 'nullable|integer|min:18|max:150',
            'gender' => 'nullable|in:male,female,other',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'event_off.required' => 'Утасны дугаар оруулна уу.',
    //         'content_on.required' => 'Нууц үг оруулна уу.',
    //         'coupon.required' => 'Төхөөрөмжийн нэр байхгүй байна.',
    //     ];
    // }
}
