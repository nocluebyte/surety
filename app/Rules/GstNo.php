<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GstNo implements ValidationRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = false;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $gstinPattern = '/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z1-9]{1}[A-Z]{1}[0-9A-Z]{1}$/';

        if (!preg_match($gstinPattern, $value)) {
            $fail('The :attribute must be a valid GST IN number (e.g., 27ABCDE1234F1Z5).');
        }
    }
}
