<?php

	namespace App\Modules\User\Entities;

	use App\Modules\Foundation\Entities\BaseModel;

	class UserGroup extends BaseModel implements UserGroupInterface
	{

		/*
		 *
		  id_user_group     int(10)
		  group_name	    varchar(255)
		  parent_group_id	int(10)
		  status            tinyint(4)
		  created_by	    int(10)
		  updated_by	    int(10)
		  created_at    	timestamp
		  updated_at	    timestamp
		 */


		protected $table = 'user_group';

		protected $primaryKey = 'id_user_group';

		protected $fillable = ['group_name', 'parent_group_id', 'status', 'label', 'geo_status'];

		/*
		 * User_Group has many user
		 */
		public function user()
		{
			return $this->belongsTo('Modules\User\Entities\User');
		}

		public function parent_user_group()
		{
			return $this->belongsTo('Modules\User\Entities\UserGroup', 'parent_group_id');
		}

		public function child_user_group()
		{
			return $this->hasMany('Modules\User\Entities\UserGroup', 'parent_group_id');
		}

		/**
		 * The permission that belong to the user_group.Many to many relation.
		 */
		public function permissions()
		{
			return $this->belongsToMany('Permission')->withPivot('status', 'module');
		}
	}
