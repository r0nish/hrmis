<?php
	/**
	 * Created by PhpStorm.
	 * User: udnbikesh
	 * Date: 2/19/16
	 * Time: 9:30 PM
	 */

	namespace App\Modules\User\Http\Controllers;

	use App\APIHelpers\Transformers\UserTransformer;
	use App\Modules\Foundation\Controllers\AbstractController;
	use App\Modules\User\Services\OauthService;
	use App\Modules\User\Services\UserService;
	use App\Modules\User\Services\UserSessionService;

	class OauthController extends AbstractController
	{

		public function __construct(UserService $service, UserTransformer $userTransformer, OauthService $oauthService, UserSessionService $userSessionService)
		{
			//   $this->middleware('oauth');
			$this->oauthService = $oauthService;
			$this->service = $service;
			$this->userSessionService = $userSessionService;
			$this->userTransformer = $userTransformer;

		}

		/**
		 * GetOAuthToken user name and password of user provided.
		 *
		 * @param Request $request
		 *
		 * @return mixed
		 */
		public function getOAuthToken(Request $request)
		{
			$data = $request->input();
			if (isset($data['username']) && isset($data['password'])) {
				$result = $this->oauthService->setOauthProcess();

				if (array_key_exists('access_token', $result)) {
					return $this->respond(['data' => $result]);
				}

				return $this->respond(['data' => $result]);
			}

			return $this->respondWithError(['login credential not provided']);

		}

	}