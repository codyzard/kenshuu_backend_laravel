<?php

namespace App\Http\Requests;

use App\Helper\Helper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Helper::isLogged();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname' => 'required',
            'address' => 'required',
            'birthday' => 'required',
            'phone' => 'required|min:10|max:14'
        ];
    }
}
