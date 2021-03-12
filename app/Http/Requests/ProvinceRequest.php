<?php

namespace App\Http\Requests;

use App\Models\Town;
use App\Rules\PostcodeRule;
use App\Rules\PostCodeSameHasParentRule;
use Illuminate\Foundation\Http\FormRequest;

class ProvinceRequest extends FormRequest
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
        $town = Town::find($this->towns_id);
        return [
            'province_name' => [
                'required',
                'max:255',
                'unique:App\Models\Province,province_name,' . $this->id
            ],
            'postcode' => [
                'required',
                'unique:App\Models\Province,postcode,' . $this->id,
                new PostcodeRule,
                new PostCodeSameHasParentRule($town)
            ]
        ];
    }
}
