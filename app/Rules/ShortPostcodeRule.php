<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ShortPostcodeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_numeric($value)) {
            return false;
        }
        return is_integer((int)$value) && $value >= 0 && $value <= 99 && !is_float($value + 0) && strlen($value) === 2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not valid post code. (Ex: "58")';
    }
}
