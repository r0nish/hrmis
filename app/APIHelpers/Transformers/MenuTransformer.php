<?php

	namespace App\APIHelpers\Transformers;

	class MenuTransformer extends Transformer
	{
		public function transform($menu, $permissions)
		{

			$data = [
				'id_menu'   => $menu['id_menu'],
				'menu_code' => $menu['menu_code'],
				'title'     => $menu['title'],
			];

			return $data;
			// return $this->filterPermissionTransform($data);
		}

		/*    public function transformChild($menu)
			{
				$data = [
					'id_menu' => $menu['id_menu'],
					'parent_id' => $menu['parent_id'],
					'children' => (!is_null($menu->children)) ? $this->transformCollection($menu->children) : 'null',
					 'menu_code' => $menu['menu_code'],
					'title' => $menu['title'],
					'icon' => $menu['icon'],
					'url' => $menu['url'],
					'state'=>$menu['state'],
					'status' => (boolean) $menu['status'],
					'updated_by' => $menu['updated_by'],
					'updated_at' => $menu['updated_at'],
					'created_by' => $menu['created_by'],
					'created_at' => $menu['created_at'],
				];
		
				return $this->filterPermissionTransform($data);
			}*/

		public function menuGenerateTransform($menu)
		{
			return $menu;
		}

		public function menuPermissionTransform($menu)
		{
			$data = $menu;

			return $data;
		}
	}
