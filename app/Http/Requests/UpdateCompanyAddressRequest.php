<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyAddressRequest extends FormRequest
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
            'block' => 'required|string',
            'street' => 'required|string',
            'unitnumber' => 'required|string',
            'postalcode' => 'required|string',
            'buildingtype' => 'required|string',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $company = auth()->user()->ownedcompany;
            if(!$company)
            {
                $validator->errors()->add('Company', 'Please fill in your company information first');
            }
        });
    }
}
