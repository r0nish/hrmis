<?php

	namespace App\APIHelpers\Transformers;

	class LoggingTransformer extends Transformer
	{
		public function transform($logging)
		{
			$data = [
				'id_logging'  => $logging['id_logging'],
				'module_name' => $logging['module_name'],
				'label'       => $logging['label'],
				'value'       => $logging['value'],
				'status'      => (boolean)$logging['status'],
				'updated_by'  => $logging['updated_by'],
				'updated_at'  => $logging['updated_at'],
				'created_by'  => $logging['created_by'],
				'created_at'  => $logging['created_at'],
			];

			return $this->filterPermissionTransform($data);
		}
	}
