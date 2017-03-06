<?php

	namespace App\APIHelpers\Transformers;

	class MenuPermissionTransformer extends Transformer
	{
		public function transform($menuPermission, $permissionfilter)
		{
			$data = [
				'id_menu_permission' => $menuPermission['id_menu_permission'],
				'menu_id'            => $menuPermission['menu_id'],
				'role_id'            => $menuPermission['role_id'],
				'permission_id'      => $menuPermission['permission_id'],
				'status'             => (boolean)$menuPermission['status'],
				'updated_by'         => $menuPermission['updated_by'],
				'updated_at'         => $menuPermission['updated_at'],
				'created_by'         => $menuPermission['created_by'],
				'created_at'         => $menuPermission['created_at'],
			];

			return $data; //$this->filterPermissionTransform($data);
		}
	}
