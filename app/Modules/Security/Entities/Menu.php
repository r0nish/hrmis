<?php

	namespace Modules\Security\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class Menu extends BaseModel implements MenuInterface
	{

		protected $table = 'menu';

		protected $primaryKey = 'id_menu';

		protected $guarded = [];

		protected $filterRoleId = '';

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function children()
		{
			return $this->hasMany('Modules\Security\Entities\Menu', 'parent_id', 'id_menu');
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function permission()
		{
			return $this->hasMany('Modules\Security\Entities\MenuPermission', 'menu_id', 'id_menu');
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
		 */
		public function activities()
		{
			return $this->belongsToMany('Modules\Security\Entities\MenuPermission', 'menu_permission', 'menu_id', 'menu_id');
		}

		/** recursive, loads all descendants
		 * @return mixed
		 */

		public function childrenRecursive()
		{
			return $this->children()->with('childrenRecursive');
		}

		/**  parent
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */

		public function parent()
		{
			return $this->belongsTo('Modules\Security\Entities\Menu', 'parent_id');
		}

		/** all ascendants
		 * @return mixed
		 */

		public function parentRecursive()
		{
			return $this->parent()->with('parentRecursive');
		}


		public function entity()
		{
			return $this->hasOne('Modules\Security\Entities\Entity');
		}

	}
