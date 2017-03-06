<?php

    namespace Modules\Security\Validators;

    use Modules\Foundation\Validation\LaravelValidator;
    use Modules\Foundation\Validation\ValidationInterface;

    class MenuPermissionValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new MenuPermission.
         *
         * @var array
         */
        protected $rules = [
            'menu_id'       => 'required',
            'role_id'       => 'required',
            'permission_id' => 'required',
        ];
    }
