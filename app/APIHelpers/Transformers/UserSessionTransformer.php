<?php

	namespace App\APIHelpers\Transformers;

	class UserSessionTransformer extends Transformer
	{
		public function transform($userSession)
		{
			$data = ['id_user_session' => $userSession['id_user_session'],
					 'user_id'         => $userSession['user_id'],
					 'token'           => $userSession['token'],
					 'latitude'        => $userSession['latitude'],
					 'longitude'       => $userSession['longitude'],
					 'expired_on'      => $userSession['expired_on'],
					 'status'          => (boolean)$userSession['status'],
			];

			return $this->filterPermissionTransform($data);
		}
	}
