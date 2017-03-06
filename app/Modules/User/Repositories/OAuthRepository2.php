<?php
	/**
	 * Created by PhpStorm.
	 * User: udnbikesh
	 * Date: 2/19/16
	 * Time: 9:50 PM
	 */

	namespace Modules\User\Repositories;


	use Illuminate\Support\Facades\Auth;
	use Modules\User\Services\UserService;
	use Modules\User\Services\UserSessionService;

	class OAuthRepository extends PDO
	{
		protected $userService;
		protected $userSessionService;

		public function __construct(UserService $userService, UserSessionService $userSessionService)
		{
			$this->userService = $userService;
			$this->userSessionService = $userSessionService;

			parent::__construct(App::make('db')->getPdo());
		}


		public function checkUserCredentials($username, $password)
		{
			return (Auth::validate(['email' => $username, 'password' => $password]));
		}

		public function getUser($username)
		{

			if (!$userInfo = $this->userService->select('email', $username)) {
				return false;
			}

			return array_merge([
								   'user_id' => $username
							   ], $userInfo);

		}

		public function setAccessToken($access_token, $client_id, $user_id, $expires, $scope = null)
		{
			// convert expires to date string
			$expires = date('Y-m-d H:i:s', $expires);

			if (!is_numeric($user_id)) {
				$userData = $this->userService->select('email', $user_id);
				$user_id = $userData->id_user;
			}


			$this->setUserSession($access_token, $user_id, $expires);


			// if it exists, update it.
			/** should be handled using service  */
			if ($this->getAccessToken($access_token)) {

				$stmt = $this->db->prepare(sprintf('UPDATE %s SET client_id=:client_id, expires=:expires, user_id=:user_id, scope=:scope where access_token=:access_token', $this->config['access_token_table']));
			}
			else {


				$stmt = $this->db->prepare(sprintf('INSERT INTO %s (access_token, client_id, expires, user_id, scope) VALUES (:access_token, :client_id, :expires, :user_id, :scope)', $this->config['access_token_table']));
			}


			return $stmt->execute(compact('access_token', 'client_id', 'user_id', 'expires', 'scope'));
		}

		public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null)
		{
			if (!is_numeric($user_id)) {
				$userData = $this->userService->select('email', $user_id);
				$user_id = $userData->id_user;
			}
			// convert expires to datestring
			$expires = date('Y-m-d H:i:s', $expires);
			$stmt = $this->db->prepare(sprintf('INSERT INTO %s (refresh_token, client_id, user_id, expires, scope) VALUES (:refresh_token, :client_id, :user_id, :expires, :scope)', $this->config['refresh_token_table']));

			return $stmt->execute(compact('refresh_token', 'client_id', 'user_id', 'expires', 'scope'));
		}


		public function getUserSession($user_id)
		{
			/*		$stmt = $this->db->prepare(sprintf('SELECT * from %s where user_id = :user_id', $this->config['user_session_table']));
			
					$token = $stmt->execute(compact('user_id'));
			*/

			return $this->userSessionService->select('user_id', $user_id);
			/*
					if ($token = $this->userSessionService->select('user_id',$user_id)){
						$token['user_id'] = strtotime($token['user_id']);
					}
			
					return $token;*/
		}

		public function setUserSession($token, $user_id, $expired_on)
		{

			// if it exists, update it.
			if ($this->getUserSession($user_id)) {

				$stmt = $this->db->prepare(sprintf('UPDATE %s SET  expired_on=:expired_on, token=:token where user_id=:user_id', $this->config['user_session_table']));

			}
			else {

				$sql = sprintf('INSERT INTO %s (token,  expired_on, user_id) VALUES (:token, :expired_on, :user_id )', $this->config['user_session_table']);
				$stmt = $this->db->prepare($sql);
			}

			return $stmt->execute(compact('token', 'expired_on', 'user_id'));
		}


		public function getAccessTokenDetail($access_token)
		{
			$stmt = $this->db->prepare(sprintf('SELECT * from %s where access_token = :access_token', $this->config['access_token_table']));

			$token = $stmt->execute(compact('access_token'));
			if ($token = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				// convert date string back to timestamp
				$token['access_token'] = strtotime($token['access_token']);
			}

			return $token;
		}
	}