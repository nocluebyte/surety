<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphabetsAndNumbersV9 implements ValidationRule
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
        $alphabetsAndNumbersV8Pattern = '/^[A-Za-z0-9\/\.\-\(\)\s]+$/';

        if (!preg_match($alphabetsAndNumbersV8Pattern, $value)) {
            $fail('The :attribute must only contain Letters, Numbers, spaces, hyphens, brackets(), periods and slashes.');
        }
    }
}
