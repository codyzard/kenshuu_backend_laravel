<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|min:6|max:255|email|unique:authors,email',
            'username' => 'required|min:6|max:255|unique:authors,username',
            'fullname' => 'required',
            'password' => 'required_with:cpassword|same:cpassword|min:6|max:100|',
            'cpassword' => 'min:6|max:100',
        ];
    }
}
