<?php

namespace App\Modules\Organizations\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationsRequest extends FormRequest
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
                'name' => 'required|string|min:3|unique:main_settings,organization_name',
                'form' => 'required|integer|exists:App\Models\OrganizationForm,id',
                'director' => 'required|string|min:3|unique:users,name',
                'logo' => 'required|nullable|image|max:10000|mimes:jpg,jpeg,png',
                'start_at' => 'required',
                'end_at' => 'required',
                'days' => 'required|array',
            ];
        }

        return [
            'name' => 'required|string|min:3',
            'form' => 'required|integer|exists:App\Models\OrganizationForm,id',
            'director' => 'required|string|min:3|unique:users,name',
            'logo' => 'required|image|max:10000|mimes:jpg,jpeg,png',
            'start_at' => 'required',
            'end_at' => 'required',
            'days' => 'required|array',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'form' => strtolower($this->organization_form),
            'days' => is_string($this->days) ? json_decode($this->days) : $this->days,
        ]);
    }
}
