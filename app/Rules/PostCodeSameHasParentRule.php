<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PostCodeSameHasParentRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($town)
    {
        $this->town = $town;
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
        return !strncmp($this->town->short_postcode, $value, 2);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute is not same has parent: {$this->town->short_postcode}";
    }
}
