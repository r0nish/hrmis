<?php

    namespace App\Modules\User\Validators;

    use App\Modules\Foundation\Validation\LaravelValidator;
    use App\Modules\Foundation\Validation\ValidationInterface;

    class UserGroupValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new UserGroup.
         *
         * @var array
         */
        protected $rules = [
            'group_name'      => 'required|min:6',
            'parent_group_id' => 'required|integer',
            // 'status' => 'required',
        ];
    }
