<?php

    namespace Modules\Security\Validators;

    use Modules\Foundation\Validation\LaravelValidator;
    use Modules\Foundation\Validation\ValidationInterface;

    class MenuValidator extends LaravelValidator implements ValidationInterface
    {
        /**
         * Validation for creating a new Menu.
         *
         * @var array
         */
        protected $rules = [
//Top most level menu doesn't have parent, and the value of parent_id is null.
            //'parent_id' => 'required',
            //'menu_code' => 'required',
            'title' => 'required',
            'url'   => 'required'
        ];
    }
