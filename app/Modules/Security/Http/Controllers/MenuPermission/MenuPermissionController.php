<?php

    namespace Modules\Security\Http\Controllers\MenuPermission;

    use App\APIHelpers\Transformers\MenuPermissionTransformer;
    use Modules\Foundation\Controllers\AbstractController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\App;
    use Modules\Security\Services\MenuPermission\MenuPermissionService;


    class MenuPermissionController extends AbstractController
    {

        protected $service;

        protected $dataTransformer;

        protected $primary_key = 'id_menu_permission';

        /**
         * MenuPermissionController constructor.
         *
         * @param MenuPermissionService     $service
         * @param MenuPermissionTransformer $menuPermissionTransformer
         */
        public function __construct(MenuPermissionService $service, MenuPermissionTransformer $menuPermissionTransformer)
        {
            $this->service = $service;
            $this->dataTransformer = $menuPermissionTransformer;

        }


        /**
         * Get the all the menu with the permission for the roleId to view.
         *
         * @param $roleId
         *
         * @return array
         */

        public function getMenuPermissionByRole($roleId)
        {
            $permissionfilter = [];
            $data = $this->service->select(['role_id' => $roleId, 'permission_id' => 4]);

            return $this->dataTransformer->transformCollection($data, $permissionfilter);
        }

        /**
         * Create the permission is not found
         * OR DELETE the permission if set.
         *
         * @param Request $request
         *
         */

        public function configure(Request $request)
        {
            $input = $request->input('detail');

            //  'roleId':roleId, 'menuId':menuId, 'permissionId':permissionId

            $permission = $this->service->select(['role_id' => $input['roleId'], 'menu_id' => $input['menuId'], 'permission_id' => $input['permissionId']]);

            if (count($permission)) {

                $id = ($permission[0]['id_menu_permission']);
                if ($this->service->delete($id))
                    return 'success';

            }
            else {

                $menuPermission = [
                    'menu_id'       => $input['menuId'],
                    'permission_id' => $input['permissionId'],
                    'role_id'       => $input['roleId']
                ];

                return $this->service->create($menuPermission);

            }


        }


    }
