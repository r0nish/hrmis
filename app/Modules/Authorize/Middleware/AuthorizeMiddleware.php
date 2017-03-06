<?php

	namespace Modules\Authorize\Middleware;

	use Closure;
	use Illuminate\Contracts\Auth\Access\Gate;
	use Illuminate\Contracts\Config\Repository as Config;
	use Illuminate\Contracts\Auth\Guard;
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;
	use Illuminate\Routing\Router;
	use Illuminate\Routing\Route;
	use Illuminate\Support\Facades\Session;
	use Modules\Authorize\Services\AuthorizationService as AuthorizeService;
	use Modules\Foundation\Controllers\ApiController;


	class AuthorizeMiddleware
	{
		/**
		 * @var Guard
		 */
		protected $auth;

		/**
		 * @var Config
		 */
		protected $config;

		/**
		 * @var Router
		 */
		protected $router;

		/**
		 * @var Gate
		 */
		protected $gate;

		/**
		 * Authorize constructor.
		 *
		 * @param Guard  $auth
		 * @param Config $config
		 * @param Router $router
		 * @param Gate   $gate
		 */
		public function __construct(
			Guard $auth,
			Config $config,
			Router $router,
			Gate $gate,
			Route $route,
			AuthorizeService $service,
			ApiController $response
		)
		{
			$this->auth = $auth;
			$this->config = $config;
			$this->router = $router;
			$this->gate = $gate;
			$this->route = $route;
			$this->authorize = $service;
			$this->responseHandler = $response;
		}

		/**
		 * Handle an incoming request.
		 *
		 * @param  Request  $request
		 * @param  \Closure $next
		 *
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{

			/** @var Roleable $user */

			$user_detail = Session::get('currentUser');

			$roleId = ($user_detail) ? $user_detail['user_group'] : '';


			//  return $this->responseHandler->respond(['data' => $roleId]);


			/**
			 * Get the permission for the user  and check the authorization.
			 */

			$url = $this->getFormatedUrl();

			list(, $action) = explode('@', $this->route->getActionName());

			$permissions = $this->authorize->checkAuthorization($action, $roleId, $url);


			/**
			 * Permissions ( places the restrictions ) Lets start we negative
			 * Permissions variable is now Restriction.
			 */


			/*        if(!$permissions)
					{
						return $this->responseHandler->responseUnathorized($this->responseConfig['401']);
					}*/

			$request->merge(['route_url' => $url]);

			if (($permissions) && is_array($permissions)) {
				$request->merge($permissions);
			}

			return $next($request);
		}

		/**
		 * Get guest role name
		 *
		 * @return string
		 */
		protected function getGuestRole()
		{
			return $this->config->get('authorize.guest_role_name');
		}

		/**
		 * Get allowed roles for current route
		 *
		 * @param array $roles
		 *
		 * @return array
		 */
		protected function getAllowedRoles(array $roles)
		{
			// we add here super roles so we don't need to add admin roles each time
			// we add other roles
			return array_values(array_unique(array_merge(
												 $roles,
												 $this->config->get('authorize.super_roles'))));
		}

		/**
		 * Report unauthorized attempt
		 *
		 * @param string  $controller
		 * @param string  $action
		 * @param Request $request
		 * @param array   $bindings
		 */
		protected function reportUnauthorizedAttempt(
			$controller,
			$action,
			$request,
			$bindings
		)
		{
			// by default we don't log anything
		}

		/**
		 * Get error response (for not authorized user)
		 *
		 * @param Request $request
		 *
		 * @return Response
		 */
		protected function errorResponse($request)
		{
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			}
			else {
				return response(view('errors.401'), 401);
			}
		}

		/**
		 * Get current route bindings
		 *
		 * @return array
		 */
		protected function getBindings()
		{
			return array_values($this->router->getCurrentRoute()->parameters());
		}

		/**
		 * Get controller and action from current route
		 *
		 * @return array
		 */
		protected function getControllerAndAction()
		{
			$name = $this->router->getCurrentRoute()->getActionName();

			// don't allow closures for routes protected by this middleware
			if (!str_contains($name, '@')) {
				throw new \LogicException('Closures for routes not allowed in this application');
			}

			return explode('@', $name);
		}

		/** get method constant to check permission
		 * mapping controller method with permission
		 */
		public function getMethodPermission()
		{
			return Config::get('constants.menuWiseControllerMethodPermission');

		}

		/** filter menu id from url.
		 * @return string
		 * normal url to the required url as that of the permissions.
		 *
		 */
		public function getFormatedUrl()
		{


			$mpre = 'api/';  // for mobile urls.. HACK FOR MOBILE @TODO

			$pre = 'api/v2/';

			$url = $this->route->getUri();
			$url = ($url) ? trim($url) : '';

			$url = ($url) ? str_replace($pre, '', $url) : '';

			$url = ($url) ? str_replace($mpre, '', $url) : '';

			$urlCheck = explode('/', $url);

			$url = count($urlCheck) > 0 ? $urlCheck[0] : $urlCheck;
			$url = ($url) ? str_replace($pre, '', $url) : '';

			return ($url);

		}

		/**
		 * user information from
		 *
		 * @param $accessTokenString
		 *
		 * @return string
		 *
		 */
		public function getUserByAccessToken($accessTokenString)
		{
			$accessToken = '';
			if (strpos($accessTokenString, 'Bearer') != -1) {

				$accessToken = explode(' ', $accessTokenString)[1];
				$user_session = UserSession::select('user_id', 'user_group_id', 'email')
					->leftjoin('user', 'user.id_user', '=', 'user_session.user_id')
					->where('token', $accessToken)
					->where('user.status', 1)->get()->first();// dd($user_session);
				$user_session = ($user_session) ? $user_session->toArray() : '';

				return $user_session;
			}

			return $accessToken;
		}


		/** User role wise validate permission of controller method
		 *
		 * @param $action
		 * @param $roleId
		 * @param $menuId
		 */
		public function validatePermisssion($action, $roleId, $menuId)
		{
			$permission = $this->getMethodPermission();
			$menuPermission = $this->menuService->getMenuPermission($roleId, $menuId); //dd($menuPermission);
			$menu = !empty($menuPermission[ $menuId ]['permission']) ? $menuPermission[ $menuId ]['permission'] : '';

			if (!empty($permission) && $action) {

				if (array_key_exists($action, $permission)) {
					$actionPermission = $permission[ $action ];

					if (!empty($menu)) {
						if (!in_array($actionPermission, $menu)) {
							return abort(401, 'Unauthorized Permission action.');
						}
					}

				}
				else {

					return abort(401, 'Permission is not set.');
				}

			}
		}


	}
