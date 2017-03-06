<?php

	namespace App\Modules\User\Entities;

	use App\Modules\Foundation\Entities\BaseModel;

	class UserSession extends BaseModel implements UserSessionInterface
	{
		/*
		  id                int(10)
		  user_id           int(10)
		  token             varchar(90)
		  latitude          varchar(255)
		  longitude         varchar(255)
		  expired_on	timestamp
		  created_by	int(10)
		  updated_by	int(10)
		  created_at	timestamp
		  updated_at	timestamp
		 */

		protected $table = 'user_session';

		protected $primaryKey = 'id';

		protected $fillable = ['user_id', 'token', 'latitude', 'longitude', 'created_on', 'expired_on', 'status'];

		public function user()
		{
			return $this->belongsTo('Modules\User\Entities\User');
		}

        public static function create(array $input = []){

        }

	}
