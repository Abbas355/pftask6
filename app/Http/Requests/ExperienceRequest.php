<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExperienceRequest extends FormRequest
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
            'experiences' => 'required|array',
            'experiences.*.coach_id' => 'required|exists:coaches,id',
            'experiences.*.role' => 'required|in:head,assistant',
            'experiences.*.club_name' => 'required|string',
            'experiences.*.start_date' => 'nullable|date',
            'experiences.*.end_date' => 'nullable|date|after_or_equal:start_date',
            'experiences.*.description' => 'nullable|string',
            'experiences.*.experience_letter_img' => 'nullable|string',
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
