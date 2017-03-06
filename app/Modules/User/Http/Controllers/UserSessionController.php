<?php

	namespace App\Modules\User\Http\Controllers;

	use App\APIHelpers\Transformers\UserSessionTransformer;
	use App\Modules\Foundation\Controllers\AbstractController;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\App;
	use App\Modules\User\Entities\UserSession;
	use App\Modules\User\Services\UserSessionService;

	class UserSessionController extends AbstractController
	{

		protected $service;

		protected $dataTransformer;

		protected $primary_key = 'id_user_session';

		/**
		 * UserSessionController constructor.
		 *
		 * @param UserSessionService     $service
		 * @param UserSessionTransformer $userSessionTransformer
		 */
		public function __construct(UserSessionService $service, UserSessionTransformer $userSessionTransformer)
		{
			$this->service = $service;
			$this->dataTransformer = $userSessionTransformer;

		}

	}
