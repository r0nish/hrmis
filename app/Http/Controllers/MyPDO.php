<?php namespace app\Http\Controllers;

use Modules\User\Services\OauthService;
use OAuth2\Storage\Pdo;


class MyPDO extends Pdo
{

    function __construct($connection, $config = [])
    {
        parent::__construct($connection, $config);

        $this->oauthService = new OauthService;
    }

    public function checkUserCredentials($username, $password)
    {

        return $this->oauthService->checkUserCredentials($username, $password);

    }

    public function getUser($username)
    {

        return $this->oauthService->getUser($username);
    }

    public function setAccessToken($access_token, $client_id, $user_id, $expires, $scope = null)
    {

        return $this->oauthService->setAccessToken($access_token, $client_id, $user_id, $expires, $scope = null);

    }


    public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null)
    {
        return $this->oauthService->setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null);
    }

}