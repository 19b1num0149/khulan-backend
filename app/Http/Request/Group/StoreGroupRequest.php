<?php

namespace App\Http\Request\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'founded_year' => 'required',
            'admin' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'founded_year.required' => trans('form.required'),
            'admin.required' => trans('form.required'),
        ];
    }
}
