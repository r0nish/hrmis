<?php

	namespace app\Http\Middleware;

	use Closure;
//use Illuminate\Support\Facades\App;
	use Illuminate\Contracts\Auth\Guard;
	use Illuminate\Support\Facades\App;
	use Modules\User\Repositories\OAuthRepository;
	use App\Modules\User\Services\OauthService;
	use OAuth2\HttpFoundationBridge\Request as OAuthRequest;
	use OAuth2\HttpFoundationBridge\Response;

	use App\APIHelpers\Transformers\UserSessionTransformer;
	use App\Http\Controllers\API\ApiController;


	use Modules\User\Services\UserSessionService;


	class OauthMiddleware
	{

		protected $service;

		protected $oauthRepository;

		/**
		 * The Guard implementation.
		 *
		 * @var Guard
		 */
		protected $auth;

		/**
		 * Create a new filter instance.
		 *
		 * @param Guard              $auth
		 * @param OauthService       $oauthService
		 * @param UserSessionService $service
		 * @param  OAuthRepository   $oauthRepository
		 */
		public function __construct(
			Guard $auth,
			OauthService $oauthService,
			UserSessionService $service,
			OAuthRepository $oauthRepository
		)
		{

			$this->service = $service;
			$this->oauthRepository = $oauthRepository;
			$this->oauthService = $oauthService;
			$this->auth = $auth;
		}

		/**
		 * Check User Session.
		 *
		 * @param token
		 *
		 * @return mixed
		 */

		public function userSesssionByToken($token)
		{
			$userSession = $this->service->select('token', $token);

			if (!$userSession) {
				return false;
			}

			return $userSession->toArray();
		}

		/**
		 * Check Token Expiry.
		 *
		 * @param date
		 *
		 * @return bool
		 */

		public function checkTokenExpiry($token)
		{
			if ($token == "The access token provided has expired") {
				return true;
			}
			else {
				return false;
			}

		}

		/**
		 * Regerneate Token .
		 *
		 * @param old token
		 *
		 * @return bool
		 */

		public function regenerateToken($access_token)
		{
			$expires_time = strtotime(date('Y-m-d H:i:s')) + 3600;
			$tokenDetail = $this->oauthRepository->getAccessTokenDetail($access_token);
			$result = $this->oauthRepository->setAccessToken($access_token, $tokenDetail['client_id'],
															 $tokenDetail['user_id'], $expires_time, $tokenDetail['scope']);

			return $result;
		}

		/*
		* check invalid Token .
		*
		* @param  token
		*
		* @return bool
		*/

		public function checkInvalidToken($token)
		{
			if ($token === "Invalid Token.") {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * Handle an incoming request.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \Closure                 $next
		 *
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{

			/**
			 * Procedure to be executed while Authentication with OAuth2.
			 *
			 * 1. All the routes requires Authenticated to get the respose ( except user login)
			 *        So the mechanism is to check the access key all the time.
			 *
			 * 2. The middleware has to check for the authorization key all the time
			 *        if no authorization block the request and set the request flow.
			 *
			 * 3. So Login section login is to be handled in the login section.
			 *
			 *
			 * My Task is to
			 * check if the access token is provided or not.
			 * if true..
			 *            check its expiry.
			 *                if true
			 *                        check the user session
			 *                            if true
			 *                                regenerate the key and pass to the response
			 *                            else
			 *                                redirect to the login Section
			 *               else
			 *                        allow the access
			 * else
			 *        error for access_key.
			 *
			 */

			if ($request->header('AUTHORIZATION')) {

				$access_token = $this->getAccessToken($request->header('AUTHORIZATION'));


				// $access_token = $request->header('AUTHORIZATION');

				$token = $this->oauthService->getOauthProcess();

				if (is_object($token)) {

					if ($token->original === "Invalid Token.") {

						return "Invalid Token.";

					}
					else {

						if ($token->original === "The access token provided has expired") {
							$hasUserSession = $this->userSesssionByToken($access_token);
							if ($hasUserSession) {
								$result = $this->regenerateToken($access_token);
							}
							else {
								return abort(403, 'Unauthorized action.');
							}
						}
					}

				}
				else {

					$hasUserSession = $this->userSesssionByToken($access_token);

					if (!$hasUserSession) {
						return abort(403, 'Unauthorized action.');
					}
				}

				return $next($request);
			}
			else {
				return abort(401, 'Unauthorized action.');
			}
		}


		public function getAccessToken($accessTokenString)
		{
			$accessToken = '';
			if (strpos($accessTokenString, 'Bearer') != -1) {
				$accessToken = explode(' ', $accessTokenString)[1];
			}

			return $accessToken;
		}
	}

