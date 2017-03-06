<?php
	/**
	 * Created by PhpStorm.
	 * User: udnbikesh
	 * Date: 1/20/16
	 * Time: 4:54 PM.
	 */

	namespace App\Modules\Foundation\Validation;

	use Illuminate\Validation\Factory;
	use Validator;

	abstract class LaravelValidator extends AbstractValidator
	{
		/**
		 * Validator.
		 *
		 * @var \Illuminate\Validation\Factory
		 */
		protected $validator;


		/**
		 * Construct.
		 *
		 * @param \Illuminate\Validation\Factory $validator
		 */
		public function __construct(Factory $validator = null)
		{
			$this->validator = $validator;
		}

		/**
		 * Pass the data and the rules to the validator.
		 *
		 * @return bool
		 */
		public function passes()
		{

			if (!is_null($this->validator)) {
				$validator = $this->validator->make($this->data, $this->rules);
			}
			else {
				$validator = Validator::make($this->data, $this->rules);
			}


			if ($validator->fails()) {
				$this->errors = $validator->messages();

				return false;
			}

			return true;
		}
	}
