<?php

    namespace App\Modules\User\Validators;

    use App\Modules\Foundation\Validation\LaravelValidator;
    use App\Modules\Foundation\Validation\ValidationInterface;

    class UserGroupPermissionValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new UserGroupPermission.
         *
         * @var array
         */
        protected $rules = [
            'user_group_id' => 'required|integer',
            'permission_id' => 'required|integer',
            'module_id'     => 'required|integer',
            'status'        => 'required',
        ];
    }
