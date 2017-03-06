<?php namespace App\Http\Middleware;


use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Config;

//use Modules\Security\Menu\Entities\Menu;
//use Modules\Security\Menu    Services\MenuService;
use Modules\Security\Services\Menu\MenuService;
use Modules\User\Entities\UserSession;
use Modules\User\Services\UserSessionService;
use Symfony\Component\HttpFoundation\Session\Session;


class PermissionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */

    protected $route;
    protected $permission;
    protected $menuPermission;
    protected $menuService;
    protected $menuId;
    protected $currentUser;
    protected $session;
    protected $userSessionService;


    public function __construct(Session $session, Guard $auth, Route $route, MenuService $menuService, UserSessionService $userSessionService)
    {
        $this->session = $session;
        // parent::__construct($auth);
        $this->auth = $auth;
        $this->route = $route;
        $this->menuService = $menuService;
        $this->userSessionService = $userSessionService;


    }

    /** get method constant to check permission
     * mapping controller method with permission
     */
    public function getMethodPermission()
    {
        return Config::get('constants.menuWiseControllerMethodPermission');

    }

    /** filter menu id from url.
     * @return string
     */
    public function getMenuIdFromUrl()
    {
        $pre = 'api/v2/';
        $url = $this->route->getUri();
        $url = ($url) ? trim($url) : '';

        $url = ($url) ? str_replace($pre, '', $url) : '';

        $urlCheck = explode('/', $url);
        $url = count($urlCheck) > 0 ? $urlCheck[0] : $urlCheck;

        $url = ($url) ? str_replace($pre, '', $url) : '';

        $data = $this->menuService->select('url', $url);

        $dataArray = !empty($data) ? $data->toArray() : '';
        $menuId = !empty($dataArray) ? $dataArray[0]['id_menu'] : '';

        $this->menuId = $menuId;

        return $menuId;
    }

    /**
     * user information from
     *
     * @param $accessTokenString
     *
     * @return string
     *
     */
    public function getUserByAccessToken($accessTokenString)
    {
        $accessToken = '';
        if (strpos($accessTokenString, 'Bearer') != -1) {

            $accessToken = explode(' ', $accessTokenString)[1];
            $user_session = UserSession::select('user_id', 'user_group_id', 'email')
                ->leftjoin('user', 'user.id_user', '=', 'user_session.user_id')
                ->where('token', $accessToken)
                ->where('user.status', 1)->get()->first();// dd($user_session);
            $user_session = ($user_session) ? $user_session->toArray() : '';

            return $user_session;
        }

        return $accessToken;
    }

    /** check permission with menu id and user id
     *
     * @param         $request
     * @param Closure $next
     */
    public function handle($request, Closure $next)
    {

        if ($request->header('AUTHORIZATION')) {

            $user_detail = $this->getUserByAccessToken($request->header('AUTHORIZATION')); //var_dump($user_detail);
            $roleId = ($user_detail) ? $user_detail['user_group_id'] : '';
        }

        //$roleId = ($this->session->get('currentUser'))?$this->session->get('currentUser')->user_group_id:'';

        if (empty($roleId)) {
            return abort(401, 'Unauthorize User.');
        }

        $menuId = $this->getMenuIdFromUrl();

        $request->merge(["menuId" => $menuId]);

        if (empty($menuId)) {
            return abort(401, 'Unauthorise Url Permission action.');
        }

        list(, $action) = explode('@', $this->route->getActionName());
        $this->validatePermisssion($action, $roleId, $menuId);

        return $next($request);
    }

    /** User role wise validate permission of controller method
     *
     * @param $action
     * @param $roleId
     * @param $menuId
     */
    public function validatePermisssion($action, $roleId, $menuId)
    {
        $permission = $this->getMethodPermission();
        $menuPermission = $this->menuService->getMenuPermission($roleId, $menuId); //dd($menuPermission);
        $menu = !empty($menuPermission[ $menuId ]['permission']) ? $menuPermission[ $menuId ]['permission'] : '';

        if (!empty($permission) && $action) {

            if (array_key_exists($action, $permission)) {
                $actionPermission = $permission[ $action ];

                if (!empty($menu)) {
                    if (!in_array($actionPermission, $menu)) {
                        return abort(401, 'Unauthorized Permission action.');
                    }
                }

            }
            else {

                return abort(401, 'Permission is not set.');
            }

        }
    }
}