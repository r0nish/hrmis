<?php

    namespace Modules\Security\Validators;

    use Modules\Foundation\Validation\LaravelValidator;
    use Modules\Foundation\Validation\ValidationInterface;

    class EntityPermissionValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new EntityPermission.
         *
         * @var array
         */
        protected $rules = [
            'entity_property_id' => 'required',
            'role_id'            => 'required',
            'permission_id'      => 'required',
        ];
    }
