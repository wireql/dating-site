<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileStoreRequest extends FormRequest
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
        return [
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'nationality' => ['required', 'string'],
            'profession' => ['required', 'string'],
            'work_place' => ['required', 'string'],
            'status' => ['required', 'string'],
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],
            'education' => ['required', 'string'],

            'instagram' => ['nullable', 'string'],
            'telegram' => ['nullable', 'string'],
            'facebook' => ['nullable', 'string'],

            'image' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'message' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'country.required' => 'Страна обязательна для заполнения.',
            'city.required' => 'Город обязателен для заполнения.',
            'nationality.required' => 'Национальность обязательна для заполнения.',
            'profession.required' => 'Профессия обязательна для заполнения.',
            'work_place.required' => 'Место работы обязательно для заполнения.',
            'status.required' => 'Статус обязателен для заполнения.',
            'height.required' => 'Рост обязателен для заполнения.',
            'height.numeric' => 'Рост должен быть числом.',
            'weight.required' => 'Вес обязателен для заполнения.',
            'weight.numeric' => 'Вес должен быть числом.',
            'education.required' => 'Образование обязательно для заполнения.',

            'instagram.string' => 'Instagram должен быть строкой.',
            'telegram.string' => 'Telegram должен быть строкой.',
            'facebook.string' => 'Facebook должен быть строкой.',

            'image.required' => 'Изображение обязательно для загрузки.',
            'image.image' => 'Файл должен быть изображением.',
            'image.mimes' => 'Изображение должно быть формата: jpeg, png, jpg.',
            'image.max' => 'Размер изображения не должен превышать 2 МБ.',

            'message.string' => 'Сообщение должно быть строкой.',
            'message.max' => 'Сообщение не должно превышать 255 символов.',
        ];
    }
}
