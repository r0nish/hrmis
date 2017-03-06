<?php

    namespace Modules\Security\Repositories;

    use Illuminate\Support\Facades\DB;
    use Modules\Foundation\Repositories\AbstractRepository;
    use Modules\Security\Entities\EntityPropertyInterface;

    class EntityPropertyRepository extends AbstractRepository implements EntityPropertyRepositoryInterface
    {
        /**
         * The Model instance.
         *
         * @var EntityPropertyInterface
         */
        protected $model;

        /**
         * Create a new EntityPropertyRepository instance.
         *
         * @param EntityPropertyInterface $model
         */
        public function __construct(EntityPropertyInterface $model)
        {
            $this->model = $model;
        }

        /**  edit entity permission , delete old data.
         *
         * @param $entityPropertyId
         * @param $entityPermission
         *
         * @return mixed
         */

        public function editEntityPermission($entityPropertyId, $entityPermission)
        {

            $entity = $this->model->find($entityPropertyId);
            $data = $entity->entityPropertyPermissionChildren()->sync($entityPermission);
            //$entity->entityPropertyPermission()->delete();
            // $data = $entity->entityPropertyPermissionChildren()->attach($entityPermission); dump($data);

            return $data;


        }

        /**
         * fetch Entities Properties wise Permission
         *
         * @param $entityPropertyId
         *
         * @return mixed
         */
        function getEntitiesPermissionSettings($entityPropertyId)
        {

            $entity = $this->model->leftJoin('entity_permission', 'entity_permission.entity_property_id', '=', 'entity_property.id_entity_property')
                ->where('entity_permission.entity_property_id', '=', $entityPropertyId)
                ->get();

            $data = !empty($entity) ? $entity->toArray() : '';

            $result = [];
            if (!empty($data)) {
                foreach ($data as $value) {
                    if (!empty($value['permission_id'])) {
                        $result[ $value['role_id'] ][ $value['permission_id'] ] = true;
                    }

                }

            }
            else {
                $result = "Please enter Entities Permission";
            }

            return $result;
        }

        /**
         * Fetch Entities properties by menu
         *
         * @param $menuId
         *
         * @return mixed
         */
        public function getEntitiesSettings($menuId)
        {
            $data = $this->model->leftJoin('entity', 'entity.id_entity', '=', 'entity_property.entity_id')
                ->where('entity.menu_id', '=', $menuId)
                ->get();

            $data = !empty($data) ? $data->toArray() : '';

            return $data;
        }


        public function getEntityPropertyPermissionByRoleIdAndEntityId($roleId, $entityId)
        {
            $res = $this->model->
            select('permission_id',
                   DB::raw("GROUP_CONCAT(DISTINCT id_entity_property SEPARATOR ',') as entity_property_permission"))
                ->Join('entity_permission', 'entity_property.id_entity_property', '=', 'entity_permission.entity_property_id')
                ->where('entity_id', '=', $entityId)
                ->where('role_id', '=', $roleId)
                ->groupBy('permission_id')
                ->get()
                ->toArray();

            return $res;

        }

    }
