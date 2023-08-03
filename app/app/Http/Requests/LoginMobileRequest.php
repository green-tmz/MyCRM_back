<?php

namespace App\Http\Requests;

use App\Rules\MinNumber;
use App\Rules\MinUppercase;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\RequestFailedValidationTrait;

class LoginMobileRequest extends FormRequest
{
    use RequestFailedValidationTrait;

    protected $options;

    /**
     * Определите, авторизован ли пользователь для выполнения этого запроса
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules()
    {
        return [
            'registration_id' => 'required|string',
            'email' => 'required|string|email',
            'password' => [
                'required',
                'min:5',
                new MinUppercase(),
                new MinNumber(),
            ]
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower($this->email)
        ]);
    }
}
