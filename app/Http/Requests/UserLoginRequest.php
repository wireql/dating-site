<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'telephone' => ['required', 'max:20'],
            'sms-code' => ['']
        ];

        if (!empty($this->input('sms-code'))) {
            $rules = [
                'sms-code' => ['required']
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'telephone.required' => 'Номер телефона обязателен для заполнения.',
            'telephone.max' => 'Номер телефона не должен превышать 20 символов.',
            'sms-code.required' => 'СМС код обязателен для заполнения.',
        ];
    }
}
