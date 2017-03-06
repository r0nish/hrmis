<?php

	namespace Modules\User\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class Permission extends BaseModel implements PermissionInterface
	{
		/*
			id              int(10)
			description	varchar(255)
			role_name	varchar(255)
			status          tinyint(4)
			created_by	int(10)
			updated_by	int(10)
			created_at	timestamp
			updated_at	timestamp
		 */

		protected $table = 'permission';

		protected $primaryKey = 'id_permission';

		protected $fillable = ['description', 'role_name', 'status'];

		/**
		 * Many to many relation.
		 */
		public function usergroups()
		{
			return $this->belongsToMany('UserGroup');
		}
	}
