<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClubRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id|unique:clubs,user_id', // Added unique rule
            'club_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'established_date' => 'required|date',
            'website' => 'nullable|url',
            'contact_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'sport_id' => 'required|exists:sports,id',
            'description' => 'required|string',
            'no_of_players' => 'required|integer|min:0',
            'no_of_coaches' => 'required|integer|min:0',
            'club_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
