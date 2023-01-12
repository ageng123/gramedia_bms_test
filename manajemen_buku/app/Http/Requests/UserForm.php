<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserForm extends FormRequest
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
        
        $id = !empty($this->id) ? ','.$this->id : '';
        $validation = [
            'with_password' => [
                'email' => 'required|unique:tabel_user,email'.$id.'|email',
                'password' => [
                    'required',
                    'string',
                    Password::min(6)->letters()->mixedCase()->numbers()->symbols()
                ],
                'c_password' => 'required|min:6|same:password'
            ],
            'no_password' => [
                'email' => 'required|unique:tabel_user,email|email',
            ]
        ];
        if(request()->isMethod("put")):
            if(empty(request("password"))):
                return $validation['no_password'];
            else:
                return $validation["with_password"];
            endif;
        else:
            return $validation["with_password"];
        endif;
       
    }
}
