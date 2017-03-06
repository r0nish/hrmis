<?php


	namespace App\Modules\User\Repositories;

	use Illuminate\Support\Facades\Cache;
	use App\Modules\User\Entities\UserGroupInterface;
	use App\Modules\Foundation\Repositories\AbstractRepository;

	class UserGroupRepository extends AbstractRepository implements UserGroupRepositoryInterface
	{
		protected $model;

		public function __construct(UserGroupInterface $model)
		{
			$this->model = $model;
		}

		public function getPaginateList($query = null)
		{

			$limit = $query['pagelimit'];

			$users = Cache::remember('laravel_user_list_' . serialize($query), 3, function () use ($limit) {
				return $this->model->with('parent_user_group')->filtered()->paginate($limit);
			});

			return $users;
		}
	}
