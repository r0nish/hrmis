<?php

	namespace Modules\Security\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class EntityProperty extends BaseModel implements EntityPropertyInterface
	{
		/**
		 * Database Table Structure.
		 * id_entity_property     int(10)
		 * entity_id    INT(10);
		 * field_name    VARCHAR(255);
		 * label    VARCHAR(255);
		 * created_by       int(10)
		 * updated_by       int(10)
		 * created_at       timestamp
		 * updated_at       timestamp
		 */

		/**
		 * table name.
		 */
		protected $table = 'entity_property';

		protected $fillable = ['entity_id', 'field_name', 'label', 'status'];

		protected $primaryKey = 'id_entity_property';

		/**
		 * Relation One to Many . Many Section. Belongs to entity
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
		 */
		public function entity()
		{
			return $this->belongsToMany('Modules\Security\Entities\Entity', 'entity_id');
		}




		//Add Relations if any

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function entityPropertyPermission()
		{
			return $this->hasMany('Modules\Security\Entities\EntityPermission', 'entity_property_id', 'id_entity_property');
		}

		/**Relations
		 * @return \Illuminate\Database\Eloquent\\BelongsToMany
		 */
		public function entityPropertyPermissionChildren()
		{
			return $this->belongsToMany('Modules\Security\Entities\EntityPermission', 'entity_permission', 'entity_property_id', 'entity_property_id');
		}

	}
