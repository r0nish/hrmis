<?php

	namespace App\APIHelpers\Transformers;

	class UserDetailTransformer extends Transformer
	{
		public function transform($user, $permission)
		{
			$data = [
				'id_user'          => isset($user['id_user']) ? (int)$user['id_user'] : null,
				'user_group_id'    => isset($user['user_group_id']) ? (int)$user['user_group_id'] : null,
				'user_group_name'  => isset($user['user_group']['group_name']) ? $user['user_group']['group_name'] : '',
				'email'            => isset($user['email']) ? $user['email'] : null,
				'password'         => isset($user['password']) ? ($user['password']) : null,
				'remember_token'   => isset($user['remember_token']) ? ($user['remember_token']) : null,
				'title'            => isset($user['first_name']) ? $user['first_name'] . " " . $user['last_name'] : null,
				'first_name'       => isset($user['first_name']) ? ($user['first_name']) : null,
				'last_name'        => isset($user['last_name']) ? ($user['last_name']) : null,
				'IMEI_number'      => isset($user['IMEI_number']) ? (float)$user['IMEI_number'] : null,
				'mobile_number'    => isset($user['mobile_number']) ? (int)$user['mobile_number'] : null,
				'MAC_id'           => isset($user['MAC_id']) ? ($user['MAC_id']) : null,
				'auth_type'        => isset($user['auth_type']) ? ($user['auth_type']) : null,
				'status'           => isset($user['status']) ? (boolean)$user['status'] : null,
				'user_group_label' => isset($user['user_group']['label']) ? $user['user_group']['label'] : null,
				'user_group_name'  => isset($user['user_group']['group_name']) ? $user['user_group']['group_name'] : null,
				'parent_user_id'   => isset($user['parent_user_id']) ? (int)($user['parent_user_id']) : null,
				'parent_title'     => isset($user->parent) ? $user->parent->title : null,
			];

			return $data;
//        return $this->filterPermissionTransform($data);
		}
	}
