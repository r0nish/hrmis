<?php

    namespace Modules\Security\Http\Controllers\EntityPermission;

    use App\APIHelpers\Transformers\EntityPermissionTransformer;
    use Modules\Foundation\Controllers\AbstractController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\App;
    use Modules\Security\Services\EntityPermission\EntityPermissionService;

    class EntityPermissionController extends AbstractController
    {

        protected $service;

        protected $dataTransformer;

        protected $primary_key = 'id_entity_permission';

        /**
         * EntityPermissionController constructor.
         *
         * @param EntityPermissionService     $service
         * @param EntityPermissionTransformer $entityPermissionTransformer
         */
        public function __construct(EntityPermissionService $service, EntityPermissionTransformer $entityPermissionTransformer)
        {
            $this->service = $service;
            $this->dataTransformer = $entityPermissionTransformer;

        }

        public function configure(Request $request)
        {
            $input = $request->input('detail');

            //  'roleId':roleId, 'menuId':menuId, 'permissionId':permissionId

            $permission = $this->service->select(['role_id' => $input['roleId'], 'entity_property_id' => $input['entityPropertyId'], 'permission_id' => $input['permissionId']]);

            if (count($permission)) {

                $id = ($permission[0]['id_entity_permission']);
                if ($this->service->delete($id))
                    return 'success';

            }
            else {

                $menuPermission = [
                    'permission_id'      => $input['permissionId'],
                    'entity_property_id' => $input['entityPropertyId'],
                    'role_id'            => $input['roleId']
                ];

                return $this->service->create($menuPermission);

            }


        }


    }
