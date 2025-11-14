<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphabetsV3 implements ValidationRule
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
        $alphabetsV3Pattern = '/^[A-Za-z-\/\s]+$/';

        if (!preg_match($alphabetsV3Pattern, $value)) {
            $fail('The :attribute must only contain letters, hyphens, slashes, and spaces.');
        }
    }
}
