<?php

	namespace Modules\Security\Validators;

	use Modules\Foundation\Validation\LaravelValidator;
	use Modules\Foundation\Validation\ValidationInterface;

	class EntityPropertyValidator extends LaravelValidator implements ValidationInterface
	{
		protected $rules = [
			// 'entity_id'  => 'required',
			// 'role_id'    => 'required',
			'field_name' => 'required',
			'label'      => 'required',

		];
	}
