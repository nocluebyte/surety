<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphabetsAndNumbersV1 implements ValidationRule
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
        $alphabetsAndNumbersV1Pattern = '/^[A-Za-z0-9\s]+$/';

        if (!preg_match($alphabetsAndNumbersV1Pattern, $value)) {
            $fail('The :attribute must only contain Alphabets and Numbers.');
        }
    }
}
