<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MultipleFile implements ValidationRule
{
    protected $maxSize;
    protected $maxFile;

    public function __construct($maxSize, $maxFile)
    {
        $this->maxSize = $maxSize;
        $this->maxFile = $maxFile;
    }

    public $implicit = false;

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_array($value)) {
            if (count($value) > $this->maxFile) {
                $fail("The number of files for {$attribute} must not exceed {$this->maxFile}.");
                return;
            }

            $totalSize = 0;

            foreach ($value as $file) {
                $totalSize += $file->getSize();
            }

            if ($totalSize > $this->maxSize) {
                $fail("The total file size for {$attribute} must not exceed " . ($this->maxSize / 1024 / 1024) . ' MB.');
                return;
            }
        }
    }
}
