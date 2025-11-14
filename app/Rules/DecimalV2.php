<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DecimalV2 implements ValidationRule
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
        $decimalV2Pattern = '/^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1}))))$/';
        if (!preg_match($decimalV2Pattern, $value)) {
            $fail('The :attribute must only contain Positive numbers and 1 Decimal point value.');
        }
    }
}
