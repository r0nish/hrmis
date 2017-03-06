<?php

namespace App\APIHelpers\Transformers;

use Illuminate\Support\Facades\Request;
use App\Modules\Foundation\Controllers\AbstractController;
//use App\Modules\Security\Menu\Entities\Entity;
//use App\Http\Controllers\API\ApiController;
use Illuminate\Routing\Route as AppRoute;
//use Modules\Security\Menu\Services\Menu\MenuService as MenuService;


abstract class Transformer extends AbstractController
{

    protected $filterPermissions;
    protected $middleware;
    protected $route;


    /**
     * @param $items ( Collection  ORM Object.)
     *
     * @return array
     *               *
     */
    /* public function transformCollection($items)
     {
         //return array_map([$this, 'transform'], $items);

         if (!$items) {
             return $items;
         }
         $collectionArray = [];


        $this->filterPermissions = $this->getEntityPropertyPermission();


         foreach ($items as $item) {
             $collectionArray[] = $this->transform($item);
         }

         $responseCollection['filtered_data'] = $collectionArray;
         $responseCollection['visible'] = isset($this->filterPermissions['visible'])?$this->filterPermissions['visible']:'';


          //return $collectionArray;

         return $responseCollection;
     }*/

    public function transformCollection($items, $permissionfilters)
    {

        if (!$items) {
            return $items;
        }
        $collectionArray = [];

        /**
         * Get the permission data according to collection and send
         * the permission to the transformer.
         */

//        $this->filterPermissions = $this->getEntityPropertyPermission();


        foreach ($items as $item) {
            $collectionArray[] = $this->transform($item, $permissionfilters);
        }

        //      $responseCollection['filtered_data'] = $collectionArray;
        //    $responseCollection['visible'] = isset($this->filterPermissions['visible'])?$this->filterPermissions['visible']:'';


        return $collectionArray;

        // return $responseCollection;
    }


    //abstract public function transform($item );


    abstract public function transform($item, $permissionfilters);

    /**  filter EntityPropertyPermission
     *
     * @param $items ( Collection  ORM Object.)
     *
     * @return array
     *               *
     */
    public function filterPermissionTransform($item, $blockInfo = null)
    {

        return $item;

        if (is_null($this->filterPermissions)) {
            $data = $this->getEntityPropertyPermission();
            $this->filterPermissions = $data;
        }


        /** @var $fillableDataFilter
         *  Get the list of the fillableData according to block
         * if block exists else receive all.
         */

        $fillableDataFilter = isset($this->filterPermissions['fillable']) ? $this->filterPermissions['fillable'] : '';


        if (!is_null($blockInfo)) {
            $fillableDataFilter = $this->filterPermissions['fillable'][ $blockInfo ];
        }


        if (!empty($fillableDataFilter)) {
            foreach ($item as $key => $value) {

                $filter[ $key ] = '~#';
                if (in_array($key, $fillableDataFilter)) {
                    $filter[ $key ] = $value;
                }
            }
        }

        $item = $filter;

        return $item;

    }

    /**  Fetch EntityPropertyPermission
     *
     * @param $items ( Collection  ORM Object.)
     *
     * @return array
     *               *
     * TODO Check the instance of the DATA.
     */
    public function getEntityPropertyPermission()
    {


        $roleId = 1;
        $menuId = Request::instance()->query('menuId');

        $propertyPermission = Entity::leftjoin('entity_property', 'entity.id_entity', '=', 'entity_property.entity_id')
            ->leftjoin('entity_permission', 'entity_property.id_entity_property', '=', 'entity_permission.entity_property_id')
            ->where('entity.menu_id', $menuId)
            ->where('entity_permission.role_id', $roleId)
            ->orderBy('id_entity_property')
            ->get()->toArray();

        $data = $this->changeKeyPermission($propertyPermission);

        return $data;
    }

    /** mapping key with fillable and permission
     *
     * @param $array
     *
     * @return mixed
     */
    public function changeKeyPermission($array)
    {

        /*        var_dump($array);
                exit;*/


        if (isset($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {

                    // $array['fillable'][] = $value['field_name'];
                    /*
                                        $array['fillable'][][] = [
                                            'title'=>$value['title'],
                                            'field'=>$value['field_name'],
                                            'label'=>$value['label']
                                        ];*/

                    if ($value['permission_id'] == 1) {
                        $array['fillable'][ $value['title'] ][] = $value['field_name'];
                    }


                    if ($value['permission_id'] == 4) {
                        $array['visible'][] = [
                            'title' => $value['title'],
                            'field' => $value['field_name'],
                            'label' => $value['label']
                        ];
                    }

                }
                $array['permission'][ $value['field_name'] ][] = $value['permission_id'];
                unset($array[ $key ]);
            }
        }

        return $array;
    }


    public function getMenuIdFromUrl()
    {

        //$this->route = instanceof AppRoute::class;
        $this->menuService = new MenuService();

        $url = "";// $this->route->getUri();
        //dd($url);
        //dd($url);
        $url = ($url) ? trim($url) : '';
        $data = $this->menuService->select('url', $url);

        $dataArray = !empty($data) ? $data->toArray() : '';
        $menuId = !empty($dataArray) ? $dataArray[0]['id_menu'] : '';

        return $menuId;
    }
}
