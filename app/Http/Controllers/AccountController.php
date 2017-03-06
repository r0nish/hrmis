<?php

    namespace App\Http\Controllers;

    use App\Modules\Foundation\Controllers\AbstractController;
    use Auth;
    use App\APIHelpers\Transformers\AuthTransformer;
    use App\APIHelpers\Transformers\UserTransformer;
    use Illuminate\Http\Request;
    use Illuminate\Contracts\Auth\Guard;
    use Illuminate\Support\Facades\Config;
    use App\Modules\User\Services\OauthService;
    use App\Modules\User\Services\UserService;
    use App\Modules\User\Services\UserSessionService;
    use Illuminate\Support\Facades\Session;


    class AccountController extends AbstractController
    {

        protected $userService;
        protected $authTransformer;
        protected $userTransformer;
        protected $currentUser;


        /**
         * UserController constructor.
         *
         * @param UserService        $service
         * @param AuthTransformer    $authTransformer
         * @param UserTransformer    $userTransformer
         * @param OauthService       $oauthService
         * @param UserSessionService $userSessionService
         */
        public function __construct(
            UserService $service,
            AuthTransformer $authTransformer,
            UserTransformer $userTransformer,
            OauthService $oauthService,
            UserSessionService $userSessionService,
            Guard $auth
        )
        {
            //   $this->middleware('oauth');
            $this->oauthService = $oauthService;
            $this->userService = $service;
            $this->userSessionService = $userSessionService;
            $this->userTransformer = $userTransformer;
            $this->authTransformer = $authTransformer;
            $this->auth = $auth;
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            return view('login');

        }

        /**
         *
         * Authorize through ldap or local database.
         *
         * @param array $data
         *
         * @return bool|\Illuminate\Contracts\Auth\Authenticatable
         *
         */
        public function loginStatus($data = [])
        {
            $isLogin = false;

          //  $data['username'] = 'binita@abc.com';
            //$data['password'] = 'e10adc3949ba59abbe56e057f20f883e';
            $isLogin = $this->auth->attempt(['email' => $data['username'], 'password' => $data['password']]);
            /**
             * Be caution using ldapAuthentications.
             */

            /*  $isLoginLdap = $this->ldapAuthenticate($username, $data['password']);
	  
				  if ($isLoginLdap) {
	  
					  $user = $this->userService->select('email', $data['username']);
	  
					  if (isset($user[0])) {
						  $user_id = $user[0]['id_user'];
						  $isLogin = $this->auth->loginUsingId($user_id);
	  
	  
					  }
	  
				  }else{
	  
					  $isLogin = $this->auth->attempt(['email' => $data['username'], 'password' => $data['password']]);
	  
	  
				  } */


            return $isLogin;
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

            $data = $request->input();

            if (isset($data['username']) && isset($data['password'])) {

                $isLogin = $this->loginStatus($data);

                if ($isLogin) {

                    $row = $this->auth->user();

                    $data['password'] = $row['password'];

//                    $result = $this->oauthService->setOauthProcess($data);
//
//                    if (array_key_exists('access_token', $result)) {
//
//                        $user = empty($user) ? $this->userService->select('email', $data['username']) : $user;
//
//                        $userInfo = $this->userTransformer->transform($user[0], '');
//
//                        $mergeResult = array_merge($result, ['userInfo' => $userInfo]);
//                        return $this->respond([
//
//                                                  'data' => $this->authTransformer->transform($mergeResult, [])
//
//                                              ]);
//
//                    }


                    return $this->respond(['data' => $row]);

                }
            }

            return $this->respondWithError(['login credential not provided']);
        }


        /**
         * logout from session
         *
         * @param user id
         *
         * @return bool
         */
        public function logout(Request $request)
        {
            $data = $request->input();
            $request_user_id = isset($data['user_id']) ? $data['user_id'] : '';


            $user = $this->auth->user();
            $user_detail = isset($user['email']) ? $this->userService->select('email', $user['email']) : '';

            $user_id = isset($user_detail[0]) ? $user_detail[0]['id_user'] : '';
            $user_id = ($user_id) ? $user_id : $request_user_id;

            if (isset($user_id)) {

                $user_session = $this->userSessionService->select('user_id', $user_id);
                $id_user_session = isset($user_session[0]) ? $user_session[0]['id'] : '';

                $result = ($id_user_session) ? $this->userSessionService->delete($id_user_session) : '';

                Session::set('currentUser', null);

                return $this->respond(['data' => $user_id]);


            }

            return $this->respondWithError(['Unable to logout']);

        }

        public function register(Request $request)
        {
            $data = $request->input();


        }


    }
