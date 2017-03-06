<?php

    namespace App\Modules\User\Validators;

    use App\Modules\Foundation\Validation\LaravelValidator;
    use App\Modules\Foundation\Validation\ValidationInterface;

    class UserSessionValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new UserSession.
         *
         * @var array
         */
        protected $rules = [
            'token'   => 'required|min:6',
            'user_id' => 'required|integer',
            'status'  => 'required',
        ];
    }
