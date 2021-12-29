<?php

namespace App\Http\Requests;

use App\Helper\Helper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorPasswordRequest extends FormRequest
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
            'old_password' => 'required|min:6|max:100',
            'new_password' => 'required_with:cnew_password|same:cnew_password|min:6|max:100|',
            'cnew_password' => 'required|min:6|max:100',
        ];
    }
}
