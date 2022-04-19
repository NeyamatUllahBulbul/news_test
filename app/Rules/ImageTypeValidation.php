<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageTypeValidation implements Rule
{
    protected $extension;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->extension = ['jpg','png','jpeg','svg'];
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value->getClientOriginalExtension(), $this->extension );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The file type is not supported! Supported types: png, jpg, jpeg, svg';
    }
}
