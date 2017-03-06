<?php

	namespace App\APIHelpers\Transformers;

	class UserGroupPermissionTransformer extends Transformer
	{
		public function transform($userGroupPermission)
		{
			$data = ['id_user_group_permission' => $userGroupPermission['id_user_group_permission'],
					 'user_group_id'            => $userGroupPermission['user_group_id'],
					 'permission_id'            => $userGroupPermission['permission_id'],
					 'module_id'                => $userGroupPermission['module_id'],
					 'status'                   => (boolean)$userGroupPermission['status'],
					 'updated_by'               => $userGroupPermission['updated_by'],
					 'updated_at'               => $userGroupPermission['updated_at'],
					 'created_by'               => $userGroupPermission['created_by'],
					 'created_at'               => $userGroupPermission['created_at'],
			];

			return $this->filterPermissionTransform($data);
		}
	}
