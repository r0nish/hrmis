<?php


    namespace Modules\Security\Repositories;

    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Config;
    use Modules\Foundation\Repositories\AbstractRepository;
    use Modules\Security\Entities\MenuInterface;
    use Illuminate\Support\Facades\DB;

    class MenuRepository extends AbstractRepository implements MenuRepositoryInterface
    {
        protected $model;

        public function __construct(MenuInterface $model)
        {
            $this->model = $model;
        }

        /** fetch menu permission
         *
         * @param $roleId
         * @param $showAll
         *
         * @return mixed
         */
        public function generateMenu($roleId, $showAll, $isVisible)
        {
            // $menu =  Cache::remember('laravel_menu_'.$roleId.$showAll.$isVisible,30,function()use($roleId, $showAll,$isVisible) {

            $menuSql = $this->model->leftjoin('menu_permission', 'menu.id_menu', '=', 'menu_permission.menu_id')
                ->select('menu.id_menu', 'menu.parent_id', 'menu_code', 'menu_permission.permission_id',
                         'menu_permission.role_id', 'menu.title', 'menu.icon', 'menu.url', 'menu.state', 'menu.status')
                ->orderBy('menu_code', 'desc');

            if (!empty($isVisible)) {
                $permission = Config::get('constants.permissionKeyword');
                $visible = isset($permission['VISIBLE']) ? $permission['VISIBLE'] : '';

                $menuSql->where('permission_id', $visible);
            }
            (!empty($showAll)) ? $menuSql->where('role_id', $roleId) : '';

            return $menuSql->get();

            // });


            return $menu;

        }

        /** get menu permission of parent
         *
         * @param $menuId
         *
         * @return string
         */
        public function getParentPermissionByMenuID($menuId)
        {

            $data = $this->model->leftjoin('menu_permission', 'menu.parent_id', '=', 'menu_permission.menu_id')
                ->select('menu.id_menu as menu_id', 'menu_permission.role_id', 'menu_permission.permission_id',
                         'menu_permission.status')
                ->where('menu.id_menu', $menuId)
                ->get()->toArray();

            if (!isset($data[0]['permission_id'])) {
                $data = "Parent Menu permission is empty";
            }


            return $data;
        }

        /** Add edit menu permission
         *
         * @param $menuId
         * @param $data
         *
         * @return mixed
         */
        public function permission($menuId, $data)
        {

            $menu = $this->model->find($menuId);
            $menu->permission()->delete();

            $data = $menu->activities()->attach($data);//;

            return $data;
        }

        /** fetch Menu permision by role and menu
         *
         * @param int $roleId
         * @param int $menuId
         *
         * @return mixed
         */
        public function getExistingMenuPermision($roleId = 0, $menuId = 0)
        {
            $menuChildSql = $this->model->leftjoin('menu_permission', 'menu.id_menu', '=', 'menu_permission.menu_id')
                ->leftjoin('permission', 'menu_permission.permission_id', '=', 'permission.id_permission')
                ->select('menu.id_menu as id_menu', 'menu_permission.role_id', 'menu_permission.permission_id',
                         'menu_permission.status', 'permission.description', 'permission.role_name')
                ->where('menu_permission.permission_id', '>', 0);

            ($roleId) ? $menuChildSql->where('menu_permission.role_id', $roleId) : '';
            ($menuId) ? $menuChildSql->where('menu_permission.menu_id', $menuId) : '';

            return $menuChildSql->get()->toArray();

        }

        /** fetch Missing menu permission
         *
         * @param int $roleId
         *
         * @return mixed
         */
        public function getMissingMenuPermission($roleId = 0, $menuId = 0)
        {
            $menuMissingSql = $this->model->leftjoin('menu_permission', 'menu.id_menu', '=', 'menu_permission.menu_id')
                ->select('menu.id_menu as id_menu')
                ->where('menu_permission.menu_id', null);

            ($menuId) ? $menuMissingSql->where('menu.id_menu', $menuId) : '';

            return $menuMissingSql->get()->toArray();

        }

        /** fetch Menu permission with reference to parent menu
         *
         * @param array $menuMissing
         *
         * @return mixed
         */
        public function getParentMenuPermission($menuMissing = [])
        {
            if (empty($menuMissing)) {
                return false;
            }

            $menuParentSql = $this->model->leftjoin('menu_permission', 'menu.parent_id', '=', 'menu_permission.menu_id')
                ->leftjoin('permission', 'menu_permission.permission_id', '=', 'permission.id_permission')
                ->select('menu.id_menu as id_menu', 'menu_permission.role_id', 'menu_permission.permission_id',
                         'menu_permission.status', 'permission.description', 'permission.role_name');

            ($menuMissing) ? $menuParentSql->whereIn('menu.id_menu', $menuMissing) : '';

            return $menuParentSql->get()->toArray();


        }

        /** fetch Menu permission and also menu permission of parent if null
         *
         * @param $roleId
         *
         * @return array|null|string
         */
        public function getMenuPermission($roleId = 0, $menuId = 0)
        {

            $menuChild = $this->getExistingMenuPermision($roleId, $menuId);

            $menuMissing = $this->getMissingMenuPermission($roleId, $menuId);

            $menuParent = $this->getParentMenuPermission($menuMissing);

            $menu = $menuChild;
            if (is_array($menuParent)) {
                $menu = array_merge($menuChild, $menuParent);
            }

            $menuPermission = (isset($menu)) ? $this->orderMenuByMenuID($menu) : '';

            return $menuPermission;

        }

        /** fetch Menu children
         *
         * @param $menuId
         *
         * @return array|null|string
         */
        public function getMenuChildren($menuId)
        {
            $result = [];

            $data = $this->model->with('childrenRecursive');

            if (!empty($menuId)) {
                $data->where('id_menu', $menuId);
            }
            else {
                $data->whereNull('parent_id');
            }

            $row = $data->get();

            if ($row) {

                $rowArray = $row->toArray();
                $result = $this->flattenArray($rowArray);
            }

            return $result;

        }

        /** to convert hierachy menu to linear array
         *
         * @param        $array
         * @param array  $key_path
         * @param string $level_separator
         * @param array  $flat
         *
         * @return array
         */
        public function flattenArray($array, &$key_path = [], $level_separator = '.', &$flat = [])
        {
            if (!is_array($key_path)) {
                // sanitize key_path
                $key_path = [(string)$key_path];
            }
            foreach ($array as $key => $value) {
                // push current key to path
                array_push($key_path, $key);

                if (is_array($value) || is_object($value)) {
                    // next level recursion
                    $flat = array_merge($flat, $this->flattenArray($value, $key_path, $level_separator, $flat));
                }
                else {
                    // write the value directly
                    $flat[ $key ][] = $value;
                    //$flat[implode($level_separator, $key_path)] = $value;
                }

                // remove used key
                array_pop($key_path);
            }

            return $flat;
        }

        /** Sort menu array by index of menu id
         *
         * @param $menu
         *
         * @return array|null
         */

        function orderMenuByMenuID($menu)
        {
            $result = [];

            $tree = (isset($menu) && !is_array($menu)) ? $menu->toArray() : $menu;
            # Traverse the tree and search for direct children of the root
            foreach ($tree as $child => $parent) {
                # A direct child is found
                if (!empty($parent['permission_id'])) {
                    $result[ $parent['id_menu'] ][ $parent['role_id'] ][ $parent['permission_id'] ] = $parent;
                    $result[ $parent['id_menu'] ]['permission'][] = $parent['role_name'];
                }
            }

            return empty($result) ? null : $result;
        }

        /** Menu Permission setting
         *
         * @param $menuId
         *
         * @return array
         */
        public function getMenuPermissionSettings($menuId)
        {

            $result = [];
            $menuChildSql = $this->model->leftjoin('menu_permission', 'menu.id_menu', '=', 'menu_permission.menu_id')
                ->leftjoin('permission', 'menu_permission.permission_id', '=', 'permission.id_permission')
                ->select('menu.id_menu as id_menu', 'menu_permission.role_id', 'menu_permission.permission_id',
                         'menu_permission.status', 'permission.description', 'permission.role_name');

            ($menuId) ? $menuChildSql->where('menu_permission.menu_id', $menuId) : '';

            $menu = $menuChildSql->get();
            $data = !empty($menu) ? $menu->toArray() : '';

            if (!empty($data)) {
                foreach ($data as $value) {
                    if (!empty($value['permission_id'])) {
                        $result[ $value['role_id'] ][ $value['permission_id'] ] = true;
                    }

                }

            }
            else {
                $result = "Please enter Menu Permission";
            }

            return $result;

        }

        /** Menu Entities Permission setting
         *
         * @param $menuId
         *
         * @return array
         */
        public function getMenuEntitiesPermissionSettings($menuId)
        {
            $menu = [];
            $result = [];

            $menuChildSql = $this->model->leftjoin('menu_permission', 'menu.id_menu', '=', 'menu_permission.menu_id')
                ->leftjoin('permission', 'menu_permission.permission_id', '=', 'permission.id_permission')
                ->select('menu.id_menu as id_menu', 'menu_permission.role_id', 'menu_permission.permission_id',
                         'menu_permission.status', 'permission.description', 'permission.role_name');

            ($menuId) ? $menuChildSql->where('menu_permission.menu_id', $menuId) : '';

            $menu = $menuChildSql->get();

            $data = !empty($menu) ? $menu->toArray() : '';

            if (!empty($data)) {
                foreach ($data as $value) {
                    if (!empty($value['permission_id'])) {
                        $result[ $value['role_id'] ][ $value['permission_id'] ] = true;
                    }

                }

            }
            else {
                $result = "Please enter Menu Permission";
            }

            return $result;

        }

        /**
         * get all the permissions regarding to role Id
         *
         * @param $roleId
         *
         */

        public function getAllPermissions($roleId)
        {

            // Cache implemetation. required for saving requery to database...

            //$result =  Cache::remember('laravel_permission_role__'.$roleId,1,function() use ($roleId) {

            $sql = "select
                menu.title,
                entity.title,
                entity_property.field_name,
                permission.description,
                menu.id_menu, menu.menu_code,  menu.url,
                entity.id_entity,
                entity_property.id_entity_property,
                entity_permission.id_entity_permission, entity_permission.role_id, entity_permission.entity_property_id
                from menu
                Join entity on entity.menu_id = menu.id_menu
                join entity_property on entity_property.entity_id = entity.id_entity
                join entity_permission on entity_permission.entity_property_id = entity_property.id_entity_property
                join permission on permission.id_permission = entity_permission.permission_id
                where entity_permission.role_id = $roleId
                order by entity_property.id_entity_property desc";

            $result = DB::select(DB::raw($sql));

            return $result;

            // });

            return $result;
        }

        /***
         * Get the end child of the menu
         */

        public function getChildMenu()
        {
            return $this->model->select('menu.id_menu', 'menu.title')->leftjoin('menu AS child', 'menu.id_menu', '=', 'child.parent_id')
                ->whereNull('child.parent_id')->get()->toArray();

        }

    }
