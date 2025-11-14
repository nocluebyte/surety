<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateExtensions implements ValidationRule
{
    protected $allowedExts;
    public function __construct($allowedExts)
    {
        $this->allowedExts = $allowedExts;
    }
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
        $allowed = $this->allowedExts;
        $ext = strtolower($value->getClientOriginalExtension());
        if (!in_array($ext, $allowed)) {
            $fail("The file extension .$ext is not allowed.");
        }
    }
}
