<?php

	namespace app\Http\Middleware;

	use Closure;
//use Illuminate\Support\Facades\App;
	use Illuminate\Contracts\Auth\Guard;
	use Illuminate\Support\Facades\App;
	use Modules\User\Repositories\OAuthRepository;
	use Modules\User\Services\OauthService;
	use OAuth2\HttpFoundationBridge\Request as OAuthRequest;
	use OAuth2\HttpFoundationBridge\Response;

	use App\APIHelpers\Transformers\UserSessionTransformer;

	use Modules\User\Services\UserSessionService;


	class RequestDataTransformerMiddleware
	{

		public function handle($request, Closure $next)
		{

			$data = $request->input();

			/***
			 * Condition Applied only for the authentication issue between RMAP and ROSIA application
			 * RMAP seeks the data input as POSt ( usename and password ) and the response parameters are different
			 *
			 * FOR RMAP. {'status':'success','data':{'token':'','created_on':'2016 -'.....}}
			 *
			 * But ROISA seeks the data input as ( data : {'username','password'}
			 * But the Url is same. ( api/user/authenticate )
			 *
			 * {"status":"success","data":{"token":"57e7695dd7fb90716d9708d321ffb6a00818614779e779925365c","created_on":{"date":"2016-09-25 11:51:21.000000","timezone_type":3,"timezone":"Asia\/Kathmandu"},"expire_on":{"date":"2016-09-25 23:51:21.000000","timezone_type":3,"timezone":"Asia\/Kathmandu"}}}
			 */

			if (isset($data['data'])) {

				$decodedRequest = json_decode(stripslashes($data['data']), 1);

				$request->merge($decodedRequest);


				if (isset($decodedRequest['token'])) {
					$request->headers->set('AUTHORIZATION', 'Bearer ' . $decodedRequest['token']);

				}
			}
			else {
				/**
				 * For RMAP append a parameter so that response could be determinable.
				 */

				$RMAPResponseParameter = ['rmap' => 1];

				$request->merge($RMAPResponseParameter);

			}

			return $next($request);
		}
	}
