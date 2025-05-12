<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'radius' => 'required',
            'address' => 'required',
        ];

        if ($this->isMethod('POST')) {
            $rules['name'] .= '|unique:offices,name';
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] .= '|unique:offices,name,' . $this->route('office');
        }

        return $rules;
    }
}
