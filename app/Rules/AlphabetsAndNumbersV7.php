<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphabetsAndNumbersV7 implements ValidationRule
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
        $alphabetsAndNumbersV7Pattern = '/^[A-Za-z0-9\s+-]+$/';

        if (!preg_match($alphabetsAndNumbersV7Pattern, $value)) {
            $fail('The :attribute must only contain Alphabets and Numbers, hyphens, spaces and (+).');
        }
    }
}
