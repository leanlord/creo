<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'email' => 'email',
            'password' => 'min:7',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'number' => 'nullable',
        ];
    }

    public function messages() {
        return [
            'email' => 'Вы ввели не адрес электронной почты.',
            'password.min' => 'Пароль должен содержать не менее 7 символов.',
        ];
    }
}
