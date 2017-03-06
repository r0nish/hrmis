<?php

    namespace Modules\Security\Http\Controllers\Menu;

    use App\APIHelpers\Transformers\MenuTransformer;
    use Modules\Foundation\Controllers\AbstractController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\DB;
    use Modules\Security\Entities\Menu;
    use Modules\Security\Services\Menu\MenuService;

    class MenuController extends AbstractController
    {

        protected $service;

        protected $menuTransformer;
        protected $dataTransformer;
        protected $primary_key = 'id_menu';

        /**
         * MenuController constructor.
         *
         * @param MenuService     $service
         * @param MenuTransformer $menuTransformer
         */
        public function __construct(MenuService $service, MenuTransformer $menuTransformer, Request $request)
        {
            $this->service = $service;
            $this->request = $request;

            $this->menuTransformer = $menuTransformer;
            $this->dataTransformer = $menuTransformer;

        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            //dump($request->input('detail'));
            $input = $request->input('detail');
            $data = $this->getMenuCode($input['parent_id']);

            if (!($data)) {
                return $this->responseValidationError($data);
            }

            $input['menu_code'] = $data;

            $createData = $this->service->create($input);
            $menuId = isset($createData->id_menu) ? $createData->id_menu : '';

            if (!($menuId)) {
                return $this->respondWithError('Fail to creata Menu');
            }

            $data = (isset($menuId)) ? $this->addParentMenuPermission($menuId) : '';


            if (!($createData instanceof Menu)) {
                return $this->responseValidationError($createData);
            }

            return $this->respond([
                                      'data' => $this->menuTransformer->transform($createData)
                                  ]);
        }


        /**  Generate New Menu code final 1.1 to 1.2
         *
         * @param $menuId
         *
         * @return string
         */

        public function getMenuCode($menuId)
        {
            $childMenuCode = $this->getChildMenuCode($menuId);
            $newMenuCode = ($childMenuCode) ? $this->getNewGenerateChildMenuCode($childMenuCode) : 'Parent Menu Not found';

            return $newMenuCode;
        }

        /**  To generate Menu pattern 1.1 to 1.2
         *
         * @param $menuId
         *
         * @return int|mixed|string
         */

        public function getChildMenuCode($menuId)
        {
            $menu = [];
            $childCode = 0;
            $hasParent = 1;

            $menuList = $this->service->select('parent_id', $menuId);

            if (count($menuList) < 1) { // check if menu code is already has child
                $menuList = $this->service->select('id_menu', $menuId);

                $hasParent = 0;
            }

            if (count($menuList) > 0) {

                foreach ($menuList as $subcat) {
                    $menu[] = $subcat['menu_code'];

                }
                $childCode = max($menu);
                $childCode = ($hasParent) ? $childCode : $childCode . '.0';
            }

            return $childCode;

        }

        /** To formulate string of Menu pattern 1.1 to 1.2
         *
         * @param $childCode
         *
         * @return string
         */

        public function getNewGenerateChildMenuCode($childCode)
        {
            $lastInc = 1;

            $newMenu = '';
            if ($childCode == 1) {
                $newMenu = $newMenu . $lastInc;
            }
            else {

                $childValues = ($childCode) ? explode('.', $childCode) : '';

                if (is_array($childValues)) {

                    $countChild = (count($childValues));

                    foreach ($childValues as $key => $child) {

                        if ($countChild > $key + 1) {
                            $newMenu = $newMenu . $child . ".";
                        }

                    }

                    $lastInt = end($childValues);
                    $lastInc = $lastInt + 1;
                    $newMenu = $newMenu . $lastInc;
                }
            }

            return $newMenu;
        }


        /**
         * should be capable to retrieve all the menu in the hierarchy
         * Input Parameters:
         * -    role_id ( Id )
         * -    show_all ( boolean )
         *
         * if boolean is true, get all the menu list regardless of role_id.
         *
         * Output Parameters:
         * Hierarchical list of menu.
         */
        public function generateMenu($roleId = 0, $showAll = "1", $isVisible = "0")
        {


            $menu = $this->service->getGenerateMenu($roleId, $showAll, $isVisible);

            $menuOrder = (isset($menu)) ? $this->orderMenuByID($menu) : '';
            $data = (isset($menuOrder)) ? $this->parseTree($menuOrder) : '';


            return $this->respond([
                                      'data' => $this->menuTransformer->menuGenerateTransform($data),
                                  ]);
        }

        /** Sort menu array by index of menu id
         *
         * @param $menu
         *
         * @return array|null
         */

        function orderMenuByID($menu)
        {
            $return = [];

            $tree = (isset($menu) && !is_array($menu)) ? $menu->toArray() : $menu;
            # Traverse the tree and search for direct children of the root
            foreach ($tree as $child => $parent) {
                # A direct child is found
                if (isset($parent)) {
                    $return[ $parent['id_menu'] ] = $parent;
                }
            }

            return empty($return) ? null : $return;
        }

        /** generate hierarchy
         *
         * @param      $tree
         * @param null $root
         *
         * @return array|null
         */

        function parseTree($tree, $root = null)
        {
            $return = [];

            # Traverse the tree and search for direct children of the root
            foreach ($tree as $child => $parent) {
                # A direct child is found
                $parentId = $parent['parent_id'];
                if ($parentId == $root) {
                    # Remove item from tree (we don't need to traverse this again)
                    unset($tree[ $child ]);
                    # Append the child into result array and parse its children
                    // $parent['entity_permission'][$parent['entity_name']][$parent['field_name']] = $parent['permission_id'];
                    $return[] = [
                        'parent'   => $parent,
                        'children' => $this->parseTree($tree, $child)
                    ];
                }
            }

            return empty($return) ? null : $return;
        }


        /** clone permission of parent menu
         *
         * @param current menu id
         *
         * @return mixed|string
         */
        public function addParentMenuPermission($menuId)
        {
            $menu = $this->service->getParentPermissionByMenuID($menuId);
            $data = (isset($menu)) ? $this->service->permission($menuId, $menu) : $menu;

            return $data;
        }

        /** change the menu permission
         *
         * @param Request $request
         *
         * @return mixed|string
         */

        public function editMenuPermission()
        {
            $transaction = [];
            $requestInput = $this->request->input();
            $inputFormat = ($requestInput['detail']) ? $requestInput['detail'] : $requestInput;

            $input['menu_id'] = $inputFormat['id_menu'];
            $input['permission'] = $inputFormat['permissions'];


            if (isset($input['menu_id']) && isset($input['permission'])) {

                $menuInput = $this->service->getById($input['menu_id']);
                if (!$menuInput) {
                    return $this->responseNotFound('Menu does not exists');
                }

                if (is_array($input['permission'])) {

                    $transaction = DB::transaction(function () {

                        try {


                            $result = [];
                            $input = $this->request->input();


                            $requestInput = $this->request->input();
                            $inputFormat = ($requestInput['detail']) ? $requestInput['detail'] : $requestInput;
                            $input['menu_id'] = $inputFormat['id_menu'];
                            $input['permission'] = $inputFormat['permissions'];

                            $permission = $input['permission'];

                            $menuChildren = $this->service->getMenuChildren($input['menu_id']);

                            $menuInsert = ($menuChildren['id_menu']) ? $menuChildren['id_menu'] : '';

                            foreach ($menuInsert as $keys => $menuId) {

                                $menu = $this->mappingMenuPermission($menuId, $permission);

                                if (!empty($menu)) {

                                    $inserted = $this->service->permission($menuId, $menu);

                                    if (empty($inserted)) {
                                        DB::rollback();
                                        $transaction['fail'] = 'Problem in updating Menu permission';
                                        $transaction['error'] = $inserted;

                                        return $transaction;
                                    }
                                    else {
                                        $result[] = $inserted;
                                    }

                                }
                            }

                            DB::commit();

                            return $result;

                        } catch (\Exception $e) {
                            DB::rollback();

                            throw $e;
                        }
                    });


                }

            }
            else {
                $transaction['fail'] = 'Menu permission is not entered';
            }

            return $this->respond(['data' => $transaction]);
        }

        /** mapping relation menu, role, permission
         *
         * @param $menuId
         * @param $permission
         *
         * @return array
         */

        public function mappingMenuPermission($menuId, $permission)
        {
            $i = 0;
            $menu = [];

            foreach ($permission as $key => $value) {

                if (!empty($value)) {
                    foreach ($permission[ $key ] as $k => $val) {
                        if ($val == 'true') {
                            $menu[ $i ]['menu_id'] = $menuId;
                            $menu[ $i ]['role_id'] = $key;
                            $menu[ $i ]['permission_id'] = $k;
                            $menu[ $i ]['status'] = 1;
                            $i++;
                        }

                    }
                }

            }

            return $menu;

        }

        /** fetch menu children by menu id
         *
         * @param $menuId
         *
         * @return mixed
         */
        public function getMenuChildren($menuId)
        {
            $data = $this->menuService->getMenuChildren($menuId);

            return $this->respond([
                                      'data' => $this->menuTransformer->menuGenerateTransform($data),
                                  ]);
        }

        /** fetch Menu permission by role Id
         *
         * @param $roleId
         *
         * @return mixed
         */
        public function getMenuPermission($roleId, $menuId = 0)
        {
            $menu = $this->service->getMenuPermission($roleId, $menuId);

            return $menu;
        }

        /** Menu Permission Settings
         *
         * @param $menuId
         *
         * @return mixed
         */
        public function getMenuPermissionSettings($menuId)
        {
            $menu = $this->service->getMenuPermissionSettings($menuId);

            return $this->respond([
                                      'data' => $this->menuTransformer->menuPermissionTransform($menu),
                                  ]);

        }

        /** Menu Entities Permission Settings
         *
         * @param $menuId
         *
         * @return mixed
         */
        public function getMenuEntitiesPermissionSettings($menuId)
        {
            $menu = $this->service->getMenuEntitiesPermissionSettings($menuId);

            return $this->respond([
                                      'data' => $this->menuTransformer->menuPermissionTransform($menu),
                                  ]);

        }

        public function getChildMenu()
        {
            $menu = $this->service->getChildMenu();

            return $this->respond([
                                      'data' => $this->menuTransformer->menuPermissionTransform($menu),
                                  ]);
        }
    }