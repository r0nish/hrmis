<?php

	namespace App\APIHelpers\Transformers;

	class UserGroupTransformer extends Transformer
	{
		public function transform($userGroup, $restrictions)
		{

			// dump($userGroup->parent_user_group);
			$data = ['id_user_group'        => $userGroup['id_user_group'],
					 'parent_user_group_id' => (int)$userGroup['id_user_group'],
					 'label'                => $userGroup['label'],
					 'geo_status'           => $userGroup['geo_status'],
					 'group_name'           => $userGroup['group_name'],
					 'parent_group_id'      => (int)$userGroup['parent_group_id'],
					 'parent_group_title'   => (isset($userGroup->parent_user_group) ? $userGroup->parent_user_group->group_name : 'null'),
					 'status'               => (boolean)$userGroup['status'],
					 'updated_by'           => $userGroup['updated_by'],
					 'updated_at'           => $userGroup['updated_at'],
					 'created_by'           => $userGroup['created_by'],
					 'created_at'           => $userGroup['created_at'],
			];

			if ($restrictions) {
				foreach ($restrictions as $restriction) {
					unset ($data[ $restriction ]);
				}
			}

			return $data;
			// return $this->filterPermissionTransform($data);
		}
	}
