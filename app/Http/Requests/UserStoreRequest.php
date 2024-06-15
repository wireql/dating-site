<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'gender' => ['required', 'in:1,2'],
            'username' => ['required', 'max:255'],
            'birthday' => ['required', 'date'],
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
            'gender.required' => 'Пол обязателен для заполнения.',
            'gender.in' => 'Пол должен быть корректен.',
            'username.required' => 'ФИО пользователя обязательно для заполнения.',
            'username.max' => 'ФИО пользователя не должно превышать 255 символов.',
            'birthday.required' => 'Дата рождения обязательна для заполнения.',
            'birthday.date' => 'Дата рождения должна быть действительной датой.',
            'telephone.required' => 'Номер телефона обязателен для заполнения.',
            'telephone.max' => 'Номер телефона не должен превышать 20 символов.',
            'sms-code.required' => 'СМС код обязателен для заполнения.',
        ];
    }
}
