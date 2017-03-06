<?php

	namespace app\Http\Middleware;

	use Closure;
	use Illuminate\Contracts\Auth\Guard;
	use Modules\User\Repositories\OAuthRepository;
	use Modules\User\Services\OauthService;

	use App\Http\Controllers\API\ApiController;

	use Modules\User\Services\UserSessionService;
	use Illuminate\Support\Facades\Config;


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
		protected $responseHandler;

		/**
		 * Create a new filter instance.
		 *
		 * @param Guard              $auth
		 * @param OauthService       $oauthService
		 * @param UserSessionService $service
		 * @param  OAuthRepository   $oauthRepository
		 * @param ApiController      $response
		 */
		public function __construct(
			Guard $auth,
			OauthService $oauthService,
			UserSessionService $service,
			OAuthRepository $oauthRepository,
			ApiController $response,
			Config $responseConfig
		)
		{

			$this->service = $service;
			$this->oauthRepository = $oauthRepository;
			$this->oauthService = $oauthService;
			$this->auth = $auth;
			$this->responseHandler = $response;
			$this->responseConfig = Config::get('responseCodes');
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
			$expires_time = strtotime(date('Y-m-d H:i:s')) + 0;
			$tokenDetail = $this->oauthRepository->getAccessTokenDetail($access_token);
			$result = $this->oauthRepository->setAccessToken($access_token, $tokenDetail['client_id'],
															 $tokenDetail['user_id'], $expires_time, $tokenDetail['scope']);

			if ($result) {
				return $tokenDetail;

			}
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
			 * OAUTH 2 .. [ AUTHORIZATION HEADER. ]
			 *
			 */

			if ($request->header('AUTHORIZATION')) {

				$access_token = $this->getAccessToken($request->header('AUTHORIZATION'));

				/**
				 * check the authorization in the oauth Process.
				 */

				$token = $this->oauthService->getOauthProcess($access_token);


				/**
				 * IF Token not found in the Oauth Service..
				 * So OauthProcess returns the error object
				 * else have send array of credentials.
				 *
				 */

				if (is_object($token)) {

					if ($token->original === "Invalid Token.") {

						return $this->responseHandler->responseForbidden($this->responseConfig['403']);

					}
					else {
						if ($token->original === "The access token provided has expired") {

							$hasUserSession = $this->userSesssionByToken($access_token);

							if ($hasUserSession) {

								$token = $this->regenerateToken($access_token);

							}
							else {
								return $this->responseHandler->responseForbidden($this->responseConfig['1403']);
							}
						}
					}

				}
				else {

					/**
					 *
					 * Access Token is correct.. We have access Token here.
					 * But the condition could be user have been logged out.
					 * But the Access  token may not yet been expired.
					 * Exceptional Condition.
					 *
					 */

					$hasUserSession = $this->userSesssionByToken($access_token);

					if (!$hasUserSession) {

						return $this->responseHandler->responseUnathorized($this->responseConfig['401']);

					}
				}

				/***
				 *
				 * Set the current user for the each request. Since its a rest API.
				 *
				 */

				if ($this->service->setCurrentUser($token['user_id'])) {

					return $next($request);
				}

			}
			else {

				return $this->responseHandler->responseUnathorized($this->responseConfig['401']);

			}
		}


		/**
		 *
		 * Handling the access token Bearer.. AUTHORIZATION.
		 *
		 * @param $accessTokenString
		 *
		 * @return string
		 */
		public function getAccessToken($accessTokenString)
		{

			$accessToken = '';

			if (strpos($accessTokenString, 'Bearer') === false) {
				$accessToken = $accessTokenString;
			}
			elseif (strpos($accessTokenString, 'Bearer') != -1) {
				$accessToken = explode(' ', $accessTokenString)[1];
			}

			return $accessToken;
		}
	}

