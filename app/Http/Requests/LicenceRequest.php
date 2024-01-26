<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LicenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'licences' => 'required|array', // Ensures presence and array format
            'licences.*.coach_id' => 'required|exists:coaches,id', // Validates coach ID
            'licences.*.licence_name' => 'required|string', // Requires license name
            'licences.*.issuing_authority' => 'required|string', // Requires issuing authority
            'licences.*.issue_date' => 'required|date', // Mandates issue date
            'licences.*.expire_date' => 'nullable|date|after:issue_date', // Optional, but must be after issue_date
            'licences.*.licence_img' => 'nullable|string', // Optional image path/URL
        ];
        
    }


          /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => false
          ], 422));
    }
}
