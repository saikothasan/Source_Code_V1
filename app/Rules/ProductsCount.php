<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ProductsCount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $expectedCount;

    public function __construct($expectedCount)
    {
        $this->expectedCount = $expectedCount;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return count($value) == $this->expectedCount;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return Str::title(":attribute") . " must have $this->expectedCount items.";
    }
}
