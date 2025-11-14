<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Remarks implements ValidationRule
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
        $remarksPattern = '/^[A-Za-z0-9\-\/&\.\_\,\%\s*\#\"\'\’\“\‘\(\)\:\;\$\₹\[\]]+$/';

        if (!preg_match($remarksPattern, $value)) {
            $fail('The :attribute must only contain letters, numbers, hyphens, periods, ampersands, slashes, percent, hashes, asterisks, underscore, brackets () and [], colon, semicolon, dollar, rupee, single quotes, double quotes, Asterisk, apostrophe(’) and spaces.');
        }
    }
}
