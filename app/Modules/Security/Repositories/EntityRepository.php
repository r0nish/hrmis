<?php

	namespace Modules\Security\Repositories;

	use Illuminate\Support\Facades\Cache;
	use Illuminate\Support\Facades\Event;
	use Modules\Foundation\Repositories\AbstractRepository;
	use Modules\Security\Entities\Entity;
	use Modules\Security\Entities\EntityInterface;
	use Modules\Security\Entities\EntityProperty;

	class EntityRepository extends AbstractRepository implements EntityRepositoryInterface
	{
		/**
		 * The Model instance.
		 *
		 * @var EntityInterface
		 */
		protected $model;

		/**
		 * Create a new EntityRepository instance.
		 *
		 * @param EntityInterface $model
		 */
		public function __construct(EntityInterface $model)
		{
			$this->model = $model;

		}

		/**
		 * custom paginated with limit
		 *
		 * @param null $query
		 *
		 * @return mixed
		 *
		 */
		public function getPaginateList($query = null)
		{

			$limit = $query['pagelimit'];

			$entity = Cache::remember('laravel_entity_list_' . serialize($query), 3, function () use ($limit) {
				return $this->model->with('entityProperties')->filtered()->paginate($limit);
			});

			return $entity;
		}

		/**
		 * list entities
		 *
		 * @param null $query
		 *
		 * @return mixed
		 *
		 */
		public function getEntities($query = null)
		{

			$entity = Cache::remember('laravel_entities_' . serialize($query), 30, function () {
				return $this->model->leftjoin('entity_property', 'entity.id_entity', '=', 'entity_property.entity_id')
					->select('entity.menu_id', 'entity_property.id_entity_property', 'entity_property.label')
					->get()->toArray();
			});

			return $entity;


		}

		public function getEntityWithProperties($menuId)
		{
			return $this->model->where('menu_id', $menuId)->with('entity_properties')->get();
		}


	}
