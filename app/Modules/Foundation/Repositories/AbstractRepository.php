<?php


	namespace App\Modules\Foundation\Repositories;

	use App\Modules\Foundation\Exception\ExceptionLogger;
	use Carbon\Carbon;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Config;
	use Illuminate\Support\Facades\DB;
	use App\Modules\Foundation\Entities\BaseModel;
	use Modules\User\Entities\UserSession;


	/**
	 * Abstract Repository to enforce all the repositories
	 */
	abstract class AbstractRepository implements BaseRepositoryInterface
	{
		public $currentUser;

		public function getCurrentUser()
		{

			if (is_null($this->currentUser)) {
				$currentUserId = Auth::user()->id;
				$this->setCurrentUser($currentUserId);
			}

			return $this->currentUser;


			//exit;
			//return $this->currentUser ;
		}

		public function setCurrentUser($currentUserId)
		{

			/**
			 * conditional Query to get the detail of the user.
			 * Create a user profile for the conditional queries
			 *  Since the app is handled by the users upto Distributor level
			 *  so routes are not required. But we can make conditional approach.
			 *  in the queries. ( Optimizations )
			 *
			 *    id_user
			 *  user_group_id
			 *  town
			 *  bu
			 *  distributor
			 *
			 */

			$userProfile = UserSession::select('user_id')
				->with(['user' => function ($query) {
					$query->select();
				}])
				->with(['user.businessUnit' => function ($query) {
					$query->select();
				}])
				->with(['user.userDistributor' => function ($query) {
					$query->select();
				}])
				->with(['user.userGroup'])
				->first()
				->toArray();


			/** Get Business Unit
			 *  if association is 0. is super admin
			 *  if association is 1. is associated to user_business_unit
			 *  if association is 2. is associated to distributor
			 *  if association is 3. is associated with both distributor and user_business_unit
			 *  ( ** note single association should be enough in this condition. pleaze check this later ** )
			 */


			switch ($userProfile['user']['user_group']['association']) {

				// case 0 and 1 is handle by the relationship.

				//case 2 is associated to distributor
				case 2 :
					/*                 $userProfile['user']['distributor'] = Distributor::where('','')->join('')->first()->toArray();
	
									 $userProfile['user']['businessUnit'] = '';*/

					break;

				case 3 :
					/*                 $userProfile['user']['distributor'] = Distributor::
									 $userProfile['user']['businessUnit'] = */

			}

			$userProfile['user']['town'] = [];


			$this->currentUser = $userProfile;

			//$this->setCurrentUser($userProfile);

			// $this->setCurrentUser($userProfile);

			/*        var_dump($this->getCurrentUser());
					exit;*/

			/*       var_dump($this->currentUser);
				   exit;*/


			return $userProfile;

			/*         var_dump($userProfile);
					 exit;*/


			/* if($this->currentUser != NULL){
				 $this->currentUser = $currentUser;
			 }*/
		}

		public function getCurrentUserDetail($userId)
		{

			/**
			 * conditional Query to get the detail of the user.
			 * Create a user profile for the conditional queries
			 *  Since the app is handled by the users upto Distributor level
			 *  so routes are not required. But we can make conditional approach.
			 *  in the queries. ( Optimizations )
			 *
			 *    id_user
			 *  user_group_id
			 *  town
			 *  bu
			 *  distributor
			 *
			 */


			$userProfile = $this->model->select('user_id')
				->with(['user' => function ($query) {
					$query->select();
				}])
				->with(['user.businessUnit' => function ($query) {
					$query->select();
				}])
				->with(['user.userDistributor' => function ($query) {
					$query->select();
				}])
				->with(['user.userGroup'])
				->first()
				->toArray();


			/** Get Business Unit
			 *  if association is 0. is super admin
			 *  if association is 1. is associated to user_business_unit
			 *  if association is 2. is associated to distributor
			 *  if association is 3. is associated with both distributor and user_business_unit
			 *  ( ** note single association should be enough in this condition. pleaze check this later ** )
			 */


			switch ($userProfile['user']['user_group']['association']) {

				// case 0 and 1 is handle by the relationship.

				//case 2 is associated to distributor
				case 2 :
					/*                 $userProfile['user']['distributor'] = Distributor::where('','')->join('')->first()->toArray();
	
									 $userProfile['user']['businessUnit'] = '';*/

					break;

				case 3 :
					/*                 $userProfile['user']['distributor'] = Distributor::
									 $userProfile['user']['businessUnit'] = */

			}

			$userProfile['user']['town'] = [];


			//$this->currentUser = $userProfile;

			$this->setCurrentUser($userProfile);

			// $this->setCurrentUser($userProfile);

			/*        var_dump($this->getCurrentUser());
					exit;*/

			/*       var_dump($this->currentUser);
				   exit;*/


			return $userProfile;

			/*         var_dump($userProfile);
					 exit;*/

		}


		/**
		 * Get all.
		 *
		 */
		public function get()
		{
			return $this->model->paginate(Config::get('app_global.RO_LIMIT'));

			//orderBy(Config::get('app_global.CREATED_AT'), 'desc')
		}

		/**
		 * @return mixed
		 *
		 */
		public function getAll()
		{
			return $this->model->filtered()->get();
		}

		/**
		 * Get specific data by Id.
		 *
		 * @param $id
		 *
		 * @return mixed
		 */
		public function getById($id)
		{

			try {

				return $this->model->findOrFail($id);

			} catch (\Exception $e) {


				ExceptionLogger::write(get_called_class() . ' create Error: ' . $e->getMessage(), 'DBError');

				return false;

			}


		}

		/**
		 * Create specific data.
		 *
		 * @param array $data
		 *
		 * @return mixed
		 */
		public function create(array $data = [])
		{

			try {
				return $this->model->create($data);

			} catch (\Exception $e) {
				ExceptionLogger::write(get_called_class() . ' create Error: ' . $e->getMessage(), 'DBError');

				return false;
			}
		}

		/**
		 * Update specific data.
		 *
		 * @param int   $id
		 * @param array $data
		 *
		 * @return mixed
		 */
		public function update($id, array $data = [])
		{
			$model = $this->getById($id);


			try {
				return $model->update($data);
			} catch (\Exception $e) {
				ExceptionLogger::write(get_called_class() . ' update Error: ' . $e->getMessage(), 'DBError');

				return false;
			}
		}

		/**
		 * Delete specific data.
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function delete($id)
		{
			$model = $this->getById($id);
			try {
				return $model->delete();
			} catch (\Exception $e) {
				ExceptionLogger::write(get_called_class() . ' delete Error: ' . $e->getMessage(), 'DBError');

				return false;
			}
		}

		/**
		 * Deactivate specific data.
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function deActivate($id)
		{
			$model = $this->getById($id);
			$model->status = 0;

			if (!$model->save()) {
				return false;
			}
			try {
				return true;
			} catch (\Exception $e) {
				ExceptionLogger::write(get_called_class() . ' deactivate Error: ' . $e->getMessage(), 'DBError');

				return false;
			}
		}

		/**
		 * Deactivate specific data.
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function activate($id)
		{
			$model = $this->getById($id);
			$model->status = 1;

			if (!$model->save()) {
				return false;
			}
			try {
				return true;
			} catch (\Exception $e) {
				ExceptionLogger::write(get_called_class() . ' activate Error: ' . $e->getMessage(), 'DBError');

				return false;
			}

		}

		/**
		 * @param $field
		 * @param $value
		 *
		 * @return mixed
		 *
		 * @throws DbException
		 */
		public function select($field, $value)
		{

			try {
				if (is_array($field)) {
					return $this->model->where($field)->get();
				}
				else {
					return $this->model->where($field, '=', $value)->get();
				}

			} catch (\Exception $e) {
				ExceptionLogger::write(get_called_class() . ' Select ' . 'Error: ' . $e->getMessage(), 'DBError');

				return false;
			}
		}

		/**
		 * Get with Pagination configurations
		 */
		public function getPaginateList($query = null)
		{
			$limit = null;
			if (isset($query['pagelimit']))
				$limit = $query['pagelimit'];

			return $this->model->filtered()->paginate($limit);
		}

		/**
		 * Get with Pagination configurations
		 */
		public function getPaginate()
		{
			return $this->model->filtered()->paginate(Config::get('app_global.RO_LIMIT'))->toArray();
			//return $pages = $this->model->filtered()->paginate();
			// return $this->model->paginate(1);
		}


		public function transformDateTime($dateTime)
		{
			$carbon = new Carbon($dateTime);

			return $carbon->toDateTimeString();
		}

	}
