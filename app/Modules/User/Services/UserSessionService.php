<?php

	namespace App\Modules\User\Services;

	use Illuminate\Support\Facades\Session;
	use App\Modules\User\Entities\User;
	use App\Modules\User\Repositories\UserSessionRepositoryInterface;
	use App\Modules\Foundation\Services\AbstractService;
	use App\Modules\User\Validators\UserSessionValidator;

	class UserSessionService extends AbstractService
	{
		protected $repository;
		protected $validator;
		protected $currentUser;

		public function __construct(UserSessionRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new UserSessionValidator();
		}

		/**
		 * @param $token
		 *
		 */

		public function setCurrentUser($userId)
		{

			$this->currentUser = $userId;
			$userProfile = User::getUserProfile($userId);

			/*        if(!Session::has('currentUser') || is_null(Session::get('currentUser'))){
						Session::set('currentUser', $userProfile);
					}*/

			(Session::set('currentUser', $userProfile));

			if ($this->currentUser) {
				return true;
			}

			return false;
		}

		public function getCurrentUser()
		{
			return $this->currentUser;
		}
	}
