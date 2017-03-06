<?php
	/**
	 * Created by PhpStorm.
	 * User: binita
	 * Date: 8/29/16
	 * Time: 5:32 PM
	 */

	namespace App\APIHelpers\Transformers;


	class UserLocationTransformer extends Transformer
	{
		public function transform($userLocation, $restrictions)
		{
			$data = ['id_user'          => (int)$userLocation['id_user'],
					 'user_group_name'  => $userLocation['user_group_name'],
					 'user_group_label' => $userLocation['user_group_label'],
					 'geo_status'       => $userLocation['geo_status'],
					 'user_name'        => $userLocation['user_name'],
					 'geo_location'     => $userLocation['geo_location'],
					 'geo_location_id'  => $userLocation['geo_location_id']
			];

			if ($restrictions) {
				foreach ($restrictions as $restriction) {
					unset ($data[ $restriction ]);
				}
			}

			return $data;
			// return $this->filterPermissionTransform($data);
		}
	}