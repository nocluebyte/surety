<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphabetsV2 implements ValidationRule
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
        $alphabetsV2Pattern = '/^[A-Za-z,.\&\-\/\s]+$/';

        if (!preg_match($alphabetsV2Pattern, $value)) {
            $fail('The :attribute must only contain letters, commas, hyphens, slashes, periods, ampersands, and spaces.');
        }
    }
}
