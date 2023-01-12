<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksForm extends FormRequest
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
        if(request()->isMethod('put')){
            return [
                //
                'judul' => 'required',
                'stok' => 'required|numeric',
                'gambar' => 'mimes: jpg,jpeg,png'
            ];
        }else{
            return [
                //
                'judul' => 'required',
                'stok' => 'required|numeric',
                'gambar' => 'required|mimes: jpg,jpeg,png'
            ];
        }
        
    }
}
