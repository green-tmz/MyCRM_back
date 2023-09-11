<?php

namespace App\Modules\Services\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        if ($this->method() == "Post") {
            return [
                'name' => 'required|string|min:3|unique:services,name',
                'slug' => 'required|string|min:3|unique:services,slug',
                'desc' => 'string|min:3',
                'duration' => 'required',
                'active' => 'required',
            ];
        }
        return [
            'name' => 'required|string|min:3',
            'slug' => 'required|string|min:3',
            'desc' => 'string|min:3',
            'duration' => 'required',
            'active' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => strtolower($this->slug)
        ]);
    }
}
