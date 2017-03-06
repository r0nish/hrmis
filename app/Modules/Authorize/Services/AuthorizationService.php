<?php

	namespace Modules\Authorize\Services;

	use Modules\Foundation\Services\AbstractService;
	use Modules\Security\Services\Menu\MenuService;
	use Illuminate\Support\Facades\Config;

	class AuthorizationService extends AbstractService
	{
		/**
		 * AuthorizationService constructor.
		 *
		 * @param MenuService $menuService
		 */
		public function __construct(MenuService $menuService)
		{
			$this->menuService = $menuService;
		}

		/**
		 * Get the permissions of the role. For authentication checkouts.
		 */
		public function getPermission($action, $roleId, $menuId)
		{

			/*var_dump( $this->validatePermisssion($action, $roleId, $menuId));
			exit;*/

			return $this->validatePermisssion($action, $roleId, $menuId);


			/*
							var_dump($url);
							exit;
	
							$data = $this->menuService->select('url', $url);
	
							$dataArray = !empty($data) ? $data->toArray() : '';
							$menuId = !empty($dataArray) ? $dataArray[0]['id_menu'] : '';
	
							$this->menuId = $menuId;
							return $menuId;
	
							return true;*/
		}

		/**
		 * Set the permissions for the user. Store the role based permissions in the cache..
		 * If possible generate a view in the backend . So that the reference would be easier.
		 *
		 */

		public function setPermission()
		{

		}


		/**
		 * Authorization if the user is able to access the provided section.
		 * if is authorized please provide all the permissions parameters for further process.
		 * Permission parameters are easier for further processing and contextual sql.
		 *
		 */
		public function checkAuthorization($action, $roleId, $url)
		{

			// Get the permission of the role with respect to the $url
			// true pass the permission of the role and url with all
			// permissions.

			$data = $this->menuService->select('url', $url);

			$dataArray = !empty($data) ? $data->toArray() : '';

			$menuId = !empty($dataArray) ? $dataArray[0]['id_menu'] : '';

			return $this->getPermission($action, $roleId, $menuId);

			if ($this->getPermission($action, $roleId, $menuId)) {

				return true;

			}

			return false;
		}

		/**
		 *
		 */


		/** User role wise validate permission of controller method
		 *
		 * @param $action
		 * @param $roleId
		 * @param $menuId
		 */
		public function validatePermisssion($action, $roleId, $menuId)
		{

			//get permission configurations READ and WRITE conditions.
			$permission = $this->getMethodPermission();

			$menuPermission = $this->menuService->getAllPermissions($roleId);


			/*
					var_dump($menuPermission);
					exit;*/

			/* All the permissions are available.
			* Now we would require to check if the menuId fits the permission
			*
			* Get the permission field lists according to the action of the url.
			* Route Url...
			*/


			$filterArray = [];

			foreach ($menuPermission as $urlPermission) {
				if ($urlPermission->id_menu == $menuId && strtoupper($urlPermission->description) == strtoupper($permission[ $action ])) {
					$filterArray[ $urlPermission->url ][] = $urlPermission->field_name;
				}
			}


			/** Now we have the list of permissions the current url could provide.
			 *  AND consists of the UI entity for security to apply.
			 *  IF not UI entity is present then no need to Provide security to apply.
			 *  Now get the fields of the url .
			 * Field List is generated to $filterArray */

			if (count($filterArray)) {
				return $filterArray;
			}


			/** If false means we have no security applied to it. Means we have all features to apply for. no hesitation to use. */
			return false;


			/*        var_dump($filterArray);
					exit;
			
			
			
			
			
			
			
			
			
			
					var_dump($menuPermission);
					exit;
			
			
					$menu = !empty($menuPermission[$menuId]['permission']) ? $menuPermission[$menuId]['permission'] : '';
			
					if (!empty($permission) && $action) {
			
						if (array_key_exists($action, $permission)) {
			
							$actionPermission = $permission[$action];
			
							if (!empty($menu)) {
								if (!in_array($actionPermission, $menu)) {
									return abort(401, 'Unauthorized Permission action.');
								}
							}
			
						} else {
			
							return abort(401, 'Permission is not set.');
						}
					}*/

		}


		/** get method constant to check permission
		 * mapping controller method with permission
		 */
		public function getMethodPermission()
		{
			return Config::get('constants.menuWiseControllerMethodPermission');

		}
	}

