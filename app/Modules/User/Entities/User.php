<?php

	namespace App\Modules\User\Entities;

	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\DB;
	use  App\Modules\Foundation\Entities\BaseModel;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Auth\Authenticatable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Auth\Passwords\CanResetPassword;
	use Illuminate\Foundation\Auth\Access\Authorizable;
	use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
	use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
	use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Database\Eloquent\SoftDeletes;


	class User extends BaseModel implements UserInterface, AuthenticatableContract,
		AuthorizableContract,
		CanResetPasswordContract
	{
		use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

		/* Model database structure
		  id_user                        int(10)
		  user_group_id             int(10)
		  email                     varchar(255)
		  password                  varchar(60)
		  remember_token            varchar(100)
		  first_name                varchar(255)
		  last_name                 varchar(255)
		  IMEI_number               varchar(255)
		  mobile_number             varchar(255)
		  MAC_id                    varchar(255)
		  auth_type                 varchar(255)
		  password_reset_hash	varchar(255)
		  password_reset_time	timestamp
		  status                    tinyint(4)
		  created_by                int(10)
		  updated_by                int(10)
		  created_at                timestamp
		  updated_at                timestamp
		 */



        protected $table = 'user';

		protected $guarded = [];
		protected $primaryKey = 'id_user';

		protected $fillable = ['id_user', 'user_group_id', 'email', 'password', 'remember_token', 'first_name', 'last_name',
			'IMEI_number', 'mobile_number', 'MAC_id', 'auth_type', 'status', 'parent_user_id'];

        public static function create(array $input = []){

        }

    }


