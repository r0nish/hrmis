<?php

	namespace Modules\Security\Repositories;

	use Modules\Foundation\Repositories\BaseRepositoryInterface;

	interface EntityRepositoryInterface extends BaseRepositoryInterface
	{
		public function getEntities();

	}
