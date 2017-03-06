<?php

	namespace App\Modules\Foundation\Validation;

	interface ValidationInterface
	{
		/**
		 * With.
		 *
		 * @param array
		 *
		 * @return self
		 */
		public function with(array $input);

		/**
		 * Passes.
		 *
		 * @return bool
		 */
		public function passes();

		/**
		 * Errors.
		 *
		 * @return array
		 */
		public function errors();
	}
