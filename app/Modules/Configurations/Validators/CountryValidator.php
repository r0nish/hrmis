<?php

namespace App\Modules\Configurations\Validators;

use App\Modules\Foundation\Validation\LaravelValidator;
use App\Modules\Foundation\Validation\ValidationInterface;

class CountryValidator extends LaravelValidator implements ValidationInterface
{
    /**
     * Validation for creating a new User.
     *
     * @var array
     */
    protected $rules = array(
        'desc' => 'required|min:5'
    );
}
