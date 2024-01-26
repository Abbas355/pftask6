<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SkillRequest extends FormRequest
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
        return $this->multipleSkillsScenario();
        // return [
        //     'player_id' => 'required|exists:players,id',
        //     'skill_name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'skill_level' => 'required|in:beginner,intermediate,expert',
        // ];
    }

    protected function multipleSkillsScenario()
    {
        return [
            'skills' => 'required|array',
            'skills.*.player_id' => 'required|exists:players,id',
            'skills.*.skill_name' => 'required|string|max:255',
            'skills.*.description' => 'nullable|string',
            'skills.*.skill_level' => 'required|in:beginner,intermediate,expert',
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
