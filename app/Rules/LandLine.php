<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LandLine implements ValidationRule
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
        $landlinePattern = '/^(?:\d){1,15}[+]{0,1}[-]{0,1}$/';

        if (!preg_match($landlinePattern, $value)) {
            $fail('The :attribute must valid LandLine No [max(15), + and - are allowed.]');
        }
    }
}
