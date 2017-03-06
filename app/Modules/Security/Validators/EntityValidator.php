<?php

    namespace Modules\Security\Validators;

    use Modules\Foundation\Validation\LaravelValidator;
    use Modules\Foundation\Validation\ValidationInterface;

    class EntityValidator extends LaravelValidator implements ValidationInterface
    {
        protected $rules = [
            'title' => 'required',

        ];
    }
