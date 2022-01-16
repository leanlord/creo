<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class UpdateAccountRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize(): bool {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules(): array {
            return [
                'email' => 'email',
                'password' => 'nullable|min:7|confirmed',
                'first_name' => 'nullable',
                'last_name' => 'nullable',
                'number' => 'nullable',
            ];
        }

        public function messages(): array {
            return [
                'email' => 'Вы ввели не адрес электронной почты.',
                'password.min' => 'Пароль должен содержать не менее 7 символов.',
                'password.confirmed' => 'Подтвержденный пароль не соответствует введенному.',
            ];
        }
    }
