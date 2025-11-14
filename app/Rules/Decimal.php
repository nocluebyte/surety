<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Decimal implements ValidationRule
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
        $numbersPattern = '/^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/';
        if (!preg_match($numbersPattern, $value)) {
            $fail('The :attribute must only contain a correct number, format 0.00');
        }
    }
}
