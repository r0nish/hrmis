<?php

	namespace Modules\ApiLog\Transformers;

	use App\APIHelpers\Transformers\Transformer;

	class ApiLogTransformer extends Transformer
	{
		public function transform($data, $permission)
		{

			return $data;

		}
	}
