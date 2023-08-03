<?php

namespace App\Modules\Users\Requests;

use App\Rules\MinNumber;
use App\Rules\MinUppercase;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\RequestFailedValidationTrait;

class UserRequest extends FormRequest
{
    use RequestFailedValidationTrait;

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
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:5',
                new MinUppercase(),
                new MinNumber(),
            ],
            'group_id' => 'required|integer|exists:App\Modules\Groups\Models\Group,id'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower($this->email)
        ]);
    }
}
