<?php

	namespace Modules\Security\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class MenuPermission extends BaseModel implements MenuPermissionInterface
	{

		protected $table = 'menu_permission';

		protected $primaryKey = 'id_menu_permission';

		protected $fillable = ['menu_id', 'role_id', 'permission_id'];

		public function menu()
		{
			return $this->belongsToMany('Modules\Security\Entities\Menu', 'menu_id');
		}


	}
