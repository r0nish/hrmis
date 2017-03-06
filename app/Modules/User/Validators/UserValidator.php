<?php

    namespace App\Modules\User\Validators;

    use App\Modules\Foundation\Validation\LaravelValidator;
    use App\Modules\Foundation\Validation\ValidationInterface;

    class UserValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new User.
         *
         * @var array
         */
        protected $rules = [
            'email'      => 'required',
            'password'   => 'required|min:6',
            'first_name' => 'required',
            'last_name'  => 'required',
            //'IMEI_number' => 'required',
            ////'mobile_number' => 'required',
            // 'MAC_id' => 'required',
            // 'auth_type' => 'required',
            // 'password_reset_hash' => 'required',
            // 'password_reset_time' => 'required',
            //'status' => 'required',
        ];
    }
