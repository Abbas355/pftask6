<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SignupUserRequest extends FormRequest
{
    // protected $redirectRoute = 'error';
    // public $validator = null;

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
            'email' => 'required|unique:users|max:50',
            'name' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ];
    }

    //  /**
    //  * Handle a failed validation attempt.
    //  *
    //  * @param  \Illuminate\Contracts\Validation\Validator  $validator
    //  * @return void
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // protected function failedValidation(Validator $mvalidator)
    // {
    //     return redirect()->route('error', ['data']);
    // }
    


}
