<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NegativeDecimal implements ValidationRule
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
        $numbersPattern = '/^-?\d+(\.\d{1,2})?$/';
        if (!preg_match($numbersPattern, $value)) {
            $fail('The :attribute must be a valid number, optionally negative, with up to two decimal places.');
        }
    }
}
