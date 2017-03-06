<?php

	namespace App\APIHelpers\Transformers;

	class UserHierarchyTransformer extends Transformer
	{
		public function transform($user, $permission)
		{
			$data = [
				'id_user'         => isset($user['id_user']) ? ($user['id_user']) : '-',
				'user_group_id'   => isset($user['user_group_id']) ? ($user['user_group_id']) : '-',
				'user_group_name' => isset($user['userGroup']['group_name']) ? $user['userGroup']['group_name'] : '',
				'email'           => isset($user['email']) ? ($user['email']) : '-',
				'password'        => isset($user['password']) ? ($user['password']) : '-',
				'remember_token'  => isset($user['remember_token']) ? ($user['remember_token']) : '-',
				'title'           => isset($user['first_name']) ? ($user['first_name'] . " " . $user['last_name']) : '-',
				'first_name'      => isset($user['first_name']) ? ($user['first_name']) : '-',
				'last_name'       => isset($user['last_name']) ? ($user['last_name']) : '-',
				'IMEI_number'     => isset($user['IMEI_number']) ? (float)$user['IMEI_number'] : '0',
				'mobile_number'   => isset($user['mobile_number']) ? (int)$user['mobile_number'] : '-',
				'MAC_id'          => isset($user['MAC_id']) ? ($user['MAC_id']) : '-',
				'auth_type'       => isset($user['auth_type']) ? ($user['auth_type']) : '-',
				'status'          => isset($user['status']) ? (boolean)$user['status'] : '-',
				'updated_by'      => isset($user['updated_by']) ? ($user['updated_by']) : '-',
				'updated_at'      => isset($user['updated_at']) ? ($user['updated_at']) : '-',
				'created_by'      => isset($user['created_by']) ? ($user['created_by']) : '-',
				'created_at'      => isset($user['created_at']) ? ($user['created_at']) : '-',
				'children'        => !empty($user['children']) ? $this->transformCollection($user['children'], $permission) : '',
			];

			return $data;
//        return $this->filterPermissionTransform($data);
		}
	}
