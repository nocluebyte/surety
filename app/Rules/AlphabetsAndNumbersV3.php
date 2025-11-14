<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphabetsAndNumbersV3 implements ValidationRule
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
        $alphabetsAndNumbersV3Pattern = '/^[A-Za-z0-9,.\&\(\)\-\/\s]+$/';

        if (!preg_match($alphabetsAndNumbersV3Pattern, $value)) {
            $fail('The :attribute must only contain letters, brackets(), numbers, commas (,), hyphens (-), slashes (/), periods (.), ampersands (&), and spaces.');
        }
    }
}
