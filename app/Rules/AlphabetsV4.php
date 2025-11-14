<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphabetsV4 implements ValidationRule
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
        $alphabetsV4Pattern = '/^[^0-9,.?<>:;"\'|}{\+\*\-=_()`~!@#%\^()& \[ \]]+$/';


        if (!preg_match($alphabetsV4Pattern, $value)) {
            $fail('The :attribute must only contain Alphabets and Special Character');
        }
    }
}
