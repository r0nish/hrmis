<?php

	namespace App\APIHelpers\Transformers;

	class UserTransformer extends Transformer
	{
		public function transform($user, $restrictions)
		{

			// dd($user['user_group']);

			$data = [
				'id_user'          => (int)$user['id_user'],
				'user_group_id'    => isset($user['user_group_id']) ? (int)$user['user_group_id'] : null,
				'userGrp'          => isset($user['user_group']['group_name']) ? $user['user_group']['group_name'] : null,
				'user_group_label' => isset($user['user_group']['label']) ? $user['user_group']['label'] : null,
				'geo_status'       => isset($user['user_group']['geo_status']) ? $user['user_group']['geo_status'] : null,
				//'user_group_title'=>isset($user->user_group->group_name)?strtoupper($user->user_group->group_name):null,
				'email'            => isset($user['email']) ? ($user['email']) : null,
				'password'         => isset($user['password']) ? ($user['password']) : null,
				'remember_token'   => isset($user['remember_token']) ? ($user['remember_token']) : null,
				'title'            => isset($user['first_name']) ? $user['first_name'] . " " . $user['last_name'] : null,
				'first_name'       => isset($user['first_name']) ? ($user['first_name']) : null,
				'last_name'        => isset($user['last_name']) ? ($user['last_name']) : null,
				'IMEI_number'      => isset($user['IMEI_number']) ? (float)$user['IMEI_number'] : null,
				'mobile_number'    => isset($user['mobile_number']) ? (int)$user['mobile_number'] : null,
				'MAC_id'           => isset($user['MAC_id']) ? $user['MAC_id'] : null,
				'auth_type'        => isset($user['auth_type']) ? $user['auth_type'] : null,
				'status'           => isset($user['status']) ? (boolean)$user['status'] : null,
				'updated_by'       => isset($user['updated_by']) ? $user['updated_by'] : null,
				'updated_at'       => isset($user['updated_at']) ? $user['updated_at'] : null,
				'created_by'       => isset($user['created_by']) ? $user['created_by'] : null,
				'created_at'       => isset($user['created_at']) ? $user['created_at'] : null,
				'children'         => !empty($user['children']) ? $this->transformCollection($user['children'], $restrictions) : null,
			];

			if ($restrictions) {

				foreach ($restrictions as $restriction) {

					unset ($data[ $restriction ]);

				}

			}

			return $data;
		}

		public function transformCollection($items, $permissionFilters)
		{
			$collectionArray = [];

			if (!is_array($items)) {
				$items[] = $items;
			}
			if (is_array($items)) {
				foreach ($items as $user) {
					$distributorTransformer = new  DistributorTransformer();
					$data = [
						'id_user'                   => (int)$user['id_user'],
						'user_group_id'             => isset($user['user_group_id']) ? (int)$user['user_group_id'] : null,
						'userGrp'                   => isset($user['user_group']['group_name']) ? $user['user_group']['group_name'] : null,
						'user_group_label'          => isset($user['user_group']['label']) ? $user['user_group']['label'] : null,
						'geo_status'                => isset($user['user_group']['geo_status']) ? $user['user_group']['geo_status'] : null,
						//'user_group_title'=>isset($user->user_group->group_name)?strtoupper($user->user_group->group_name):null,
						'email'                     => isset($user['email']) ? ($user['email']) : null,
						'password'                  => isset($user['password']) ? ($user['password']) : null,
						'remember_token'            => isset($user['remember_token']) ? ($user['remember_token']) : null,
						'title'                     => isset($user['first_name']) ? $user['first_name'] . " " . $user['last_name'] : null,
						'first_name'                => isset($user['first_name']) ? ($user['first_name']) : null,
						'last_name'                 => isset($user['last_name']) ? ($user['last_name']) : null,
						'IMEI_number'               => isset($user['IMEI_number']) ? (float)$user['IMEI_number'] : null,
						'mobile_number'             => isset($user['mobile_number']) ? (int)$user['mobile_number'] : null,
						'MAC_id'                    => isset($user['MAC_id']) ? $user['MAC_id'] : null,
						'auth_type'                 => isset($user['auth_type']) ? $user['auth_type'] : null,
						'status'                    => isset($user['status']) ? (boolean)$user['status'] : null,
						'updated_by'                => isset($user['updated_by']) ? $user['updated_by'] : null,
						'updated_at'                => isset($user['updated_at']) ? $user['updated_at'] : null,
						'created_by'                => isset($user['created_by']) ? $user['created_by'] : null,
						'created_at'                => isset($user['created_at']) ? $user['created_at'] : null,
						'children'                  => !empty($user['children']) ? $this->transformCollection($user['children'], $permissionFilters) : null,
						'children_user'             => !empty($user['children_recursive']) ? $this->transformCollection($user['children_recursive'], $permissionFilters) : null,
						'geographic_location'       => !empty($user['geographic_location']) ? ($user['geographic_location'][0]['title']) : null,
						'sales_officer_distributor' => !empty($user['sales_officer_distributor']) ? $distributorTransformer->transformCollection($user['sales_officer_distributor'], $permissionFilters) : null,

					];

					if ($permissionFilters) {
						foreach ($permissionFilters as $restriction) {
							unset($data[ $restriction ]);
						}
					}

					$collectionArray[] = $data;

				}
			}

			return $collectionArray;
		}

	}
