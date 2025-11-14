<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PercentageV1 implements ValidationRule
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
        $percentageV1Pattern = '/^((100(\.0{1,2})?)|([1-9]?[0-9](\.\d{1,2})?))$/';

        if (!preg_match($percentageV1Pattern, $value)) {
            $fail('The :attribute must only contain Positive [0-100] Numbers and 2 decimal point value.');
        }
    }
}
