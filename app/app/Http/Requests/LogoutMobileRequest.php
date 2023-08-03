<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\RequestFailedValidationTrait;

class LogoutMobileRequest extends FormRequest
{
    use RequestFailedValidationTrait;

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
        ];
    }
}
