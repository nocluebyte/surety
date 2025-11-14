<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PanNo implements ValidationRule
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
        $pattern = '/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/';

        if (!preg_match($pattern, $value)) {
            $fail('The :attribute must be a valid PAN number. eg.(ABCDE6789S)');
        }
    }
}
