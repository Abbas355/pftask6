<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AchievementRequest extends FormRequest
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
        return $this->multipleAchievementsScenario();
        // return [
        //     'player_id' => 'required|exists:players,id',
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'date' => 'required|date|before:today',
        //     'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        // ];
    }

    protected function multipleAchievementsScenario()
    {
        return [
            'achievements' => 'required|array',
            'achievements.*.player_id' => 'required|exists:players,id',
            'achievements.*.title' => 'required|string|max:255',
            'achievements.*.description' => 'nullable|string',
            'achievements.*.date' => 'required|date|before:today',
            'achievements.*.img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
