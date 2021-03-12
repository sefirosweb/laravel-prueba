<?php

namespace App\Http\Requests;

use App\Rules\ShortPostcodeRule;
use Illuminate\Foundation\Http\FormRequest;

class TownRequest extends FormRequest
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
            'town_name' => [
                'required',
                'max:255',
                'unique:App\Models\Town,town_name,' . $this->id
            ],
            'short_postcode' => [
                'required',
                'numeric',
                'min:0',
                'max:99',
                new ShortPostcodeRule,
                'unique:App\Models\Town,short_postcode,' . $this->id
            ]
        ];
    }
}
