<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ChekInRequest extends FormRequest
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
        return [
            'date' => 'required|date',
            'checkin' => 'required|date_format:H:i',
            'checkin_long' => 'required',
            'checkin_lat' => 'required',
            'checkin_photo' => 'required'
        ];
    }
}
