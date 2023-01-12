<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthForm extends FormRequest
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
        if(request("form_type") == "login"){
            return [
                //
                "email" => "required|email",
                "password" => "required"
            ];
        }
        if(request("form_type") == "register"){
            return [
                'email' => 'required|unique:tabel_user,email|email',
                'password' => [
                    'required',
                    'string',
                    Password::min(6)->letters()->mixedCase()->numbers()->symbols()
                ],
                'c_password' => 'required|min:6|same:password'
            ];
        }
        return [
            'form_type' => "required"
        ];
    }
}
