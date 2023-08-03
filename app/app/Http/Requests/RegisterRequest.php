<?php

namespace App\Http\Requests;

use App\Rules\MinNumber;
use App\Rules\MinUppercase;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\RequestFailedValidationTrait;

class RegisterRequest extends FormRequest
{
    use RequestFailedValidationTrait;

    protected $options;
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
                'confirmed',
                new MinUppercase(),
                new MinNumber(1),
            ],
            'group_id' => 'required|integer|exists:groups,id'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower($this->email),
            'group_id' => 1
        ]);
    }
}
