<?php


    namespace App\Modules\User\Repositories;

    use Illuminate\Support\Facades\App;
    use App\Modules\User\Entities\User;
    use OAuth2\Storage\Pdo;

    class OAuthRepository extends Pdo
    {

        public function __construct()
        {
            $this->config['user_table'] = 'user';
            $this->config['user_session_table'] = 'user_session';

            parent::__construct(App::make('db')->getPdo(), $this->config);
        }


        /****
         *
         * Code to be Reviewed..
         *
         * Please Do take  your time to Debugg this Issues
         * Its Urgent and Highly Important Section.
         *
         * Please do
         *
         * @param $username
         * @param $password
         *
         * @return bool
         */

        public function checkUserCredentials($username, $password)
        {

            //if (Auth::validate(array('email' => $username, 'password' => $password)))
            $result = $this->getUser($username);

            return true;

            /*
					var_dump($password);
					exit;
			
					var_dump(isset($result['password']) && $result['password'] == $password);
					exit;
			
					if (isset($result['password']) && $result['password'] == $password) {
						return true;
					}
			
					return false;*/
        }

        public function getUser($username)
        {

            $sql = sprintf('SELECT * from %s where email=:username', $this->config['user_table']);
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['username' => $username]);
            if (!$userInfo = $stmt->fetch(\PDO::FETCH_BOTH)) {
                return false;
            }
            /*        var_dump($userInfo);
					exit;*/

            // the default behavior is to use "username" as the user_id
            return array_merge([
                                   'user_id' => $userInfo['id_user']
                               ], $userInfo);
        }

        public function setAccessToken($access_token, $client_id, $user_id, $expires, $scope = null)
        {
            // convert expires to date string
            $expires = date('Y-m-d H:i:s', $expires);

            if (!is_numeric($user_id)) {
                $userData = User::where('email', $user_id)->first();
                $user_id = $userData->id_user;
            }
            /*
					var_dump($user_id);
					exit;*/

            ($this->setUserSession($access_token, $user_id, $expires));


            // if it exists, update it.
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
                $userData = User::where('email', $user_id)->first();
                $user_id = $userData->id_user;
            }
            // convert expires to datestring
            $expires = date('Y-m-d H:i:s', $expires);
            $stmt = $this->db->prepare(sprintf('INSERT INTO %s (refresh_token, client_id, user_id, expires, scope) VALUES (:refresh_token, :client_id, :user_id, :expires, :scope)', $this->config['refresh_token_table']));

            return $stmt->execute(compact('refresh_token', 'client_id', 'user_id', 'expires', 'scope'));
        }

        public function getUserSession($user_id)
        {
            $stmt = $this->db->prepare(sprintf('SELECT * from %s where user_id = :user_id', $this->config['user_session_table']));

            $token = $stmt->execute(compact('user_id'));
            if ($token = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                // convert date string back to timestamp
                $token['user_id'] = strtotime($token['user_id']);
            }

            return $token;
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
