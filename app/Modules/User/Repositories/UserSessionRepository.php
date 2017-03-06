<?php


	namespace App\Modules\User\Repositories;

	use App\Modules\User\Entities\UserSessionInterface;
	use App\Modules\Foundation\Repositories\AbstractRepository;

	class UserSessionRepository extends AbstractRepository implements UserSessionRepositoryInterface
	{
		protected $model;
		public $currentUser;

		public function __construct(UserSessionInterface $model)
		{
			$this->model = $model;
		}


	}
