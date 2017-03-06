<?php

	namespace App\Modules\User\Entities;

	use App\Modules\Foundation\Entities\BaseModel;

	class UserGroupPermission extends BaseModel implements UserGroupPermissionInterface
	{
		/*
		 *
		  id_user_group_permission       int(10)
		user_group_id       int(10)
		permission_id       int(10)
		module_id       int(10)
		  status            tinyint(4)
		  created_by	int(10)
		  updated_by	int(10)
		  created_at	timestamp
		  updated_at	timestamp
		 */

		protected $table = 'user_group_permission';

		protected $primaryKey = 'id_user_group_permission';

		protected $fillable = ['user_group_id', 'permission_id', 'module_id', 'status'];

		/*
		 * User_Group has many user
		 */

		/* public function user_group()
		 {
			 return $this->belongsTo('User_Group', 'id_user_group');
		 }*/

		/**
		 * The permission that belong to the user_group.Many to many relation.
		 */
		/*public function permissions()
		{
			return $this->belongsToMany('Permission')->withPivot('status', 'module');
		}*/
	}
