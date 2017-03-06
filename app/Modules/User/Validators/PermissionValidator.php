<?php

    namespace App\Modules\User\Validators;

    use App\Modules\Foundation\Validation\LaravelValidator;
    use App\Modules\Foundation\Validation\ValidationInterface;

    class PermissionValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new Permission.
         *
         * @var array
         */
        protected $rules = [
            'description' => 'required|min:6',
            'role_name'   => 'required',
            'status'      => 'required',
        ];
    }
