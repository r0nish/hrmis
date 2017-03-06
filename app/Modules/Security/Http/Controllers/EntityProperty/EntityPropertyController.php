<?php

    namespace Modules\Security\Http\Controllers\EntityProperty;

    use App\APIHelpers\Transformers\EntityPropertyTransformer;
    use Modules\Foundation\Controllers\AbstractController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
//use Modules\Security\Entities\EntityProperty; // Entities\EntityProperty;
    use Modules\Security\Services\EntityProperty\EntityPropertyService;

    class EntityPropertyController extends AbstractController
    {
        protected $service;
        protected $dataTransformer;
        protected $primary_key = 'id_entity_property';


        /**
         * EntityPropertyController constructor.
         *
         * @param EntityPropertyService     $service
         * @param EntityPropertyTransformer $entitypropertyTransformer
         */
        public function __construct(EntityPropertyService $service, EntityPropertyTransformer $entitypropertyTransformer, Request $request)
        {
            $this->service = $service;
            $this->request = $request;
            $this->dataTransformer = $entitypropertyTransformer;
        }


        /**
         * Store a newly created resource in storage.
         *
         * @param Request|\Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {

            if (is_array($request->input('detail'))) {
                foreach ($request->input('detail') as $input) {
                    $input['status'] = 1;
                    $createResponse = $this->service->create($input);

                    /**
                     * Validation Error Section.
                     */
                    if ($createResponse instanceof MessageBag) {
                        return $this->responseValidationError($createResponse);
                    }

                    $createData[] = $createResponse;

                }
            }
            else {
                $createData = $this->service->create($request->input('detail'));
                /**
                 * Validation Error Section.
                 */
                if ($createData instanceof MessageBag) {
                    return $this->responseValidationError($createData);
                }

            }

            return $this->respond([
                                      'data' => (is_array($createData)) ? $this->dataTransformer->transformCollection($createData) : $this->dataTransformer->transform($createData),
                                  ]);


        }

        /**
         * Edit Menu Entities Permission
         * @return mixed
         */

        public function editMenuEntitiesPermission()
        {
            $transaction = [];
            $requestInput = $this->request->input();
            $inputFormat = ($requestInput['detail']) ? $requestInput['detail'] : $requestInput;
            //  $input['menu_id']=$inputFormat['id_menu'];
            $input['entity_property_id'] = $inputFormat['id_entity_property'];

            $input['permission'] = $inputFormat['permissions'];


            if (isset($input['entity_property_id']) && isset($input['permission'])) {

                $menuInput = $this->service->getById($input['entity_property_id']);
                if (!$menuInput) {
                    return $this->responseNotFound('Entity Property does not exists');
                }

                if (is_array($input['permission'])) {

                    $transaction = DB::transaction(function () {

                        try {

                            $result = [];
                            $input = $this->request->input();


                            $requestInput = $this->request->input();
                            $inputFormat = ($requestInput['detail']) ? $requestInput['detail'] : $requestInput;
                            $input['entity_property_id'] = $inputFormat['id_entity_property'];

                            $input['permission'] = $inputFormat['permissions'];

                            $entityPropertyId = $input['entity_property_id'];
                            $permission = $input['permission'];

                            $entityPermission = $this->mappingEntitiesPermission($entityPropertyId, $permission);

                            if (!empty($entityPermission)) {

                                $inserted = $this->service->editEntityPermission($entityPropertyId, $entityPermission);

                                if (empty($inserted)) {
                                    DB::rollback();
                                    $transaction['fail'] = 'Problem in updating Entities permission';
                                    $transaction['error'] = $inserted;

                                    return $transaction;
                                }
                                else {
                                    $result[] = $inserted;
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
                $transaction['fail'] = 'Entities permission is not entered';
            }

            return $this->respond(['data' => $transaction]);
        }


        /** mapping relation entities, role, permission
         *
         * @param $entityPropertyId
         * @param $permission
         *
         * @return array
         */

        public function mappingEntitiesPermission($entityPropertyId, $permission)
        {
            $i = 0;
            $menu = [];

            foreach ($permission as $key => $value) {

                if (!empty($value)) {
                    foreach ($permission[ $key ] as $k => $val) {
                        if ($val == 'true') {
                            $menu[ $i ]['entity_property_id'] = $entityPropertyId;
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

        /**
         * Fetch menu wise entities properties.
         *
         * @param $menuId
         *
         * @return mixed
         */
        public function getEntitiesSettings($menuId)
        {
            $result = $this->service->getEntitiesSettings($menuId);

            return $this->respond(['data' => $result]);
        }

        /** fetch Entities property wise permission
         *
         * @param $entityPropertyId
         *
         * @return mixed
         */

        public function getEntitiesPermissionSettings($entityPropertyId)
        {
            $result = $this->service->getEntitiesPermissionSettings($entityPropertyId);

            return $this->respond(['data' => $result]);
        }


        public function getEntityPropertyPermissionByRoleIdAndEntityId($roleId, $entityId)
        {

            $result = $this->service->getEntityPropertyPermissionByRoleIdAndEntityId($roleId, $entityId);

            return $this->respond(['data' => $result]);

        }

    }
