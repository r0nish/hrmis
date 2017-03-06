<?php

    namespace App\Modules\Foundation\Validation;

    abstract class AbstractValidator
    {
        /**
         * Validator.
         *
         * @var object
         */
        protected $validator;

        /**
         * Data to be validated.
         *
         * @var array
         */
        protected $data = [];

        /**
         * Validation Rules.
         *
         * @var array
         */
        protected $rules = [];

        /**
         * Validation errors.
         *
         * @var array
         */
        protected $errors = [];

        /**
         * Set data to validate.
         *
         * @param array $data
         *
         * @return self
         */
        public function with(array $data)
        {
            $this->data = $data;

            return $this;
        }

        /**
         * Return errors.
         *
         * @return array
         */
        public function errors()
        {
            return $this->errors;
        }

        /**
         * Pass the data and the rules to the validator.
         *
         * @return bool
         */
        abstract public function passes();
    }
