<?php

	namespace Modules\Security\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class Entity extends BaseModel implements EntityInterface
	{
		/**
		 * Database Table Structure.
		 * id_entity     int(10)
		 * menu_id        int(11)
		 * title    VARCHAR(255);
		 * created_by       int(10)
		 * updated_by       int(10)
		 * created_at       timestamp
		 * updated_at       timestamp
		 */

		/**
		 * table name.
		 */
		protected $table = 'entity';

		protected $guarded = [];

		// protected $fillable = ['title', 'status'];

		protected $primaryKey = 'id_entity';

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function entity_properties()
		{
			return $this->hasMany('Modules\Security\Entities\EntityProperty');
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasOne
		 */
		public function menu()
		{
			return $this->belongsTo('Modules\Security\Entities\Menu');
		}

	}
