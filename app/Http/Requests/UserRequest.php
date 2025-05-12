<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->route('employee');

        return [
            'nip' => 'required|unique:users,nip' . ($id ? ",$id" : ''),
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'office_id' => 'required',
            'address' => 'required',
        ];
    }
}
