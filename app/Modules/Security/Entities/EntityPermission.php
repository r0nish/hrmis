<?php

	namespace Modules\Security\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class EntityPermission extends BaseModel implements EntityPermissionInterface
	{

		protected $table = 'entity_permission';

		protected $primaryKey = 'id_entity_permission';

		protected $fillable = ['entity_property_id', 'role_id', 'permission_id'];


	}
