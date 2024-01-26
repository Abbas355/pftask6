<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InjurieRequest extends FormRequest
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
        return $this->multipleInjuriesScenario();
        // return [
        //     'player_id' => 'required|exists:players,id',
        //     'injury' => 'required|string',
        //     'date' => 'required|date',
        //     'expected_recovery_time' => 'nullable|integer|min:0',
        // ];
    }

    protected function multipleInjuriesScenario()
    {
        return [
            'injuries' => 'required|array',
            'injuries.*.player_id' => 'required|exists:players,id',
            'injuries.*.injury' => 'required|string',
            'injuries.*.date' => 'required|date',
            'injuries.*.expected_recovery_time' => 'nullable|integer|min:0',
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
