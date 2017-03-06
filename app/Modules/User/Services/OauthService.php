<?php

	namespace App\Modules\User\Services;

	use Illuminate\Support\Facades\App;
	use OAuth2\GrantType;

	use OAuth2\HttpFoundationBridge\Request as OAuthRequest;

	class OauthService
	{

		public function setOauthProcess($data)
		{

			$req = \Symfony\Component\HttpFoundation\Request::createFromGlobals();


			/**
			 * For the mobile App . To be revised for the OauthProcess
			 */

			$req->request->add(['username' => $data['username'], 'password' => $data['password'], 'client_id' => 'client', 'client_secret' => 'secret', 'grant_type' => 'password']);

			/**
			 * End of Mobile App Hack.
			 */

			$bridgedRequest = OAuthRequest::createFromRequest($req);
			$bridgedResponse = new \OAuth2\HttpFoundationBridge\Response();
			$bridgedResponse = App::make('OauthServer')->handleTokenRequest($bridgedRequest, $bridgedResponse);
			$bridgedResponse = $bridgedResponse->getContent();
			$bridgedResponse = json_decode($bridgedResponse, true);

			return $bridgedResponse;
		}


		public function getOauthProcess($access_token)
		{

			$req = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

			$req->headers->add(['Authorization' => 'Bearer ' . $access_token]);
			$req->server->add(["REDIRECT_HTTP_AUTHORIZATION" => "Bearer " . $access_token,
							   "HTTP_AUTHORIZATION"          => "Bearer " . $access_token]);


			$bridgedRequest = OAuthRequest::createFromRequest($req); //dd($bridgedRequest);
			$bridgedResponse = new \OAuth2\HttpFoundationBridge\Response();


			if (!$token = App::make('OauthServer')->getAccessTokenData($bridgedRequest, $bridgedResponse)) {
				$response = App::make('OauthServer')->getResponse();

				if ($response->isClientError() && $response->getParameter('error')) {
					if ($response->getParameter('error') == 'expired_token') {
						return response('The access token provided has expired', 401);
					}

					return response('Invalid Token.', 422);
				}

			}
			else {
				$request['user_id'] = $token['user_id'];

				return $token;
			}

		}


	}
