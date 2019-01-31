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
    public function rules(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'nik' => 'required|numeric|digits:16',
            'phone' => 'required|numeric|digits_between:10,12',
            'information' => 'nullable|string',
            'username' =>  'required|string|min:6|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'city_id' => 'required|integer',
            ''
        ];

        if ($request->role == 'district-co') {
            $rules[] = ['district_id' => 'required|integer'];
        }

        if ($request->role == 'village-co') {
            $rules[] = [
                ['district_id' => 'required|integer'],
                ['village_id' => 'required|integer']
            ];
        }

        return $rules;
    }
}
