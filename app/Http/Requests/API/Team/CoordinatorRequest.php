<?php

namespace App\Http\Requests\API\Team;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CoordinatorRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'nik' => 'required|numeric|digits:16',
            'phone' => 'required|numeric|digits_between:10,12',
            'information' => 'nullable|string',
            'role' => 'required|string',
            'city_id' => 'required|integer',
        ];

        if ($this->isMethod('POST')) {
            $rules['username'] = 'required|string|min:6|unique:users,username';
            $rules['email'] = 'required|string|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:6';
        }

        if (request()->role == 'district-co' || request()->role == 'village-co') {
            $rules['district_id'] = 'required|integer';
        }

        if (request()->role == 'village-co') {
            $rules['village_id'] = 'required|integer';
        }

        return $rules;
    }
}
