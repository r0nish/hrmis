<?php

	namespace Modules\Security\Http\Controllers\Entity;

	use App\APIHelpers\Transformers\EntityTransformer;
	use Illuminate\Support\MessageBag;
	use Modules\Foundation\Controllers\AbstractController;
	use Illuminate\Http\Request;
	use Modules\Security\Entities\Entity;
	use Modules\Security\Services\Entity\EntityService;
	use Modules\Security\Services\EntityProperty\EntityPropertyService;

	class EntityController extends AbstractController

	{
		protected $service;
		protected $entityTransformer;
		protected $dataTransformer;
		protected $primary_key = 'id_entity';
		protected $entityPropertyService;

		/**
		 * EntityController constructor.
		 *
		 * @param EntityService     $service
		 * @param EntityTransformer $entityTransformer
		 */
		public function __construct(
			EntityService $service,
			EntityTransformer $entityTransformer,
			EntityPropertyService $entityPropertyService
		)
		{
			$this->service = $service;
			$this->entityTransformer = $entityTransformer;
			$this->dataTransformer = $entityTransformer;
			$this->entityPropertyService = $entityPropertyService;
		}

		public function getEntitiesByMenu($menuId)
		{
			$permissionfilters = [];
			$data = $this->service->select('menu_id', $menuId); //getEntityWithProperties($menuId);
			return $this->entityTransformer->transformCollection($data, $permissionfilters);
		}

		public function store(Request $request)
		{
			$permissionFilters = [];
			$input = $request->input();
			// dd($input);
			$data = isset($input['detail']) ? $input['detail'] : '';
			$entityData['menu_id'] = $data['menu_id'];
			$entityData['title'] = $data['entity_title'];
			$createData = $this->service->create($entityData);
			foreach ($data['fieldLabel'] as $key => $value) {
				$entityProperty['entity_id'] = $createData->id_entity;
				$entityProperty['field_name'] = $value['field'];
				$entityProperty['label'] = $value['label'];
				if ($createData) {
					$createProperty = $this->entityPropertyService->create($entityProperty);
				}
			}


			/**
			 * Validation Error Section.
			 */
			if ($createData instanceof MessageBag) {
				return $this->responseValidationError($createData);
			}
			if ($createProperty instanceof MessageBag) {
				return $this->responseValidationError($createProperty);
			}

			return $this->respond([
									  'data' => $this->dataTransformer->transform($createData, $permissionFilters),
								  ]);
		}
	}
