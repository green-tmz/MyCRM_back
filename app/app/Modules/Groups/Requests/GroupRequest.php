<?php

namespace App\Modules\Groups\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'name' => 'required|string|min:3|unique:groups,name',
            'slug' => 'required|string|min:3|unique:groups,slug',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => strtolower($this->slug)
        ]);
    }
}