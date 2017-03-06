<?php

    namespace App\APIHelpers\Transformers;

    class AuthTransformer extends Transformer
    {
        public function transform($authInfo, $permissions)
        {
            /*        return array (
						'token' => '52dcd65742c98356a192b7913b04c54574d18c28d46e6395428ab',
						'created_on' =>
							array (
								'date' => '2014-01-20 13:40:03'
							),
						'expire_on' =>
							array (
								'date' => '2014-01-21 01:40:03'
							),
					);*/

            $expire_on = ['date' => date('Y-m-d H:i:s', time() + 24000 + $authInfo['expires_in'])];
            $created_on = ['date' => date('Y-m-d H:i:s', time() + 12000)];

            if (isset($authInfo['rmap'])) {
                $created_on = $created_on['date'];
                $expire_on = $expire_on['date'];

            }


            $data = [
                'token'         => $authInfo['access_token'],
                'access_token'  => $authInfo['access_token'],
                'expire_on'     => $expire_on,
                'created_on'    => $created_on,
                'token_type'    => $authInfo['token_type'],
                'refresh_token' => $authInfo['refresh_token'],
                'userInfo'      => $authInfo['userInfo'],
            ];

            return $data;

        }
    }
