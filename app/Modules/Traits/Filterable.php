<?php
	namespace App\Modules\Traits;

	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Support\Str;

	use Modules\User\Entities\User;
	use Modules\User\Entities\UserSession;
	use RuntimeException;

	trait Filterable
	{

		public function getQueryModeParameterName()
		{
			return 'mode';
		}

		/**
		 * Applies filters.
		 *
		 * @param Builder $builder query builder
		 * @param array   $query   query parameters to use for search - Input::all() is used by default
		 */
		public function scopeFiltered(Builder $builder, array $query = [])
		{

			$query = $query ?: Input::all();

			$mode = $this->getQueryMode($query);

			$query = array_except($query, $this->getQueryModeParameterName());

			$constraints = $this->getConstraints($builder, $query);

			$builder = $this->setContextToQuery($builder);

			$this->applyConstraints($builder, $constraints, $mode);

		}


		/**
		 * Builds search constraints based on model's searchable fields and query parameters.
		 *
		 * @param Builder $builder query builder
		 * @param array   $query   query parameters
		 *
		 * @return array
		 */
		protected function getConstraints(Builder $builder, array $query)
		{
			$constraints = [];
			foreach ($query as $field => $values) {
				if ($this->isFieldSearchable($builder, $field)) {
					$constraints[ $field ] = $this->buildConstraints($field, $values);
				}
			}

			return $constraints;
		}

		/**
		 * Check if field is searchable for given model.
		 *
		 * @param Builder $builder query builder
		 * @param string  $field   field name
		 *
		 * @return bool
		 */
		protected function isFieldSearchable(Builder $builder, $field)
		{
			$fillable = $this->_getSearchableAttributes($builder);

			return in_array($field, $fillable) || in_array('*', $fillable);
		}

		/**
		 * Applies constraints to query, allowing model to overwrite any of them.
		 *
		 * @param Builder                $builder     query builder
		 * @param FilterableConstraint[] $constraints constraints
		 * @param string                 $mode        determines how constraints are applied ("or" or "and")
		 */
		protected function applyConstraints(Builder $builder, array $constraints, $mode = FilterableConstraint::MODE_AND)
		{
			foreach ($constraints as $field => $constraint) {
				$tableName = $builder->getModel()->getTable();

				if (is_array($constraint)) {
					foreach ($constraint as $single_constraint) {
						$this->applyConstraint($builder, $tableName . '.' . $field, $single_constraint, $mode);
					}
				}
				else {
					$this->applyConstraint($builder, $tableName . '.' . $field, $constraint, $mode);
				}
			}
		}

		/**
		 * Calls constraint interceptor on model.
		 *
		 * @param Builder              $builder    query builder
		 * @param string               $field      field on which constraint is applied
		 * @param FilterableConstraint $constraint constraint
		 *
		 * @return bool true if constraint was intercepted by model's method
		 */
		protected function callInterceptor(Builder $builder, $field, FilterableConstraint $constraint)
		{
			$model = $builder->getModel();
			$interceptor = sprintf('process%sFilter', Str::studly($field));

			if (method_exists($model, $interceptor)) {
				if ($model->$interceptor($builder, $constraint)) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Build FilterableConstraint objects from given filter values
		 *
		 * @param string []|string
		 *
		 * @return FilterableConstraint[]|Constraint
		 */
		/**
		 * @param $field was added for the condition of ANDING values in case created_at
		 *               but for other case implode the values
		 *
		 * @return array|FilterableConstraint
		 * @return array|FilterableConstraint
		 */
		protected function buildConstraints($field, $values)
		{

			if (is_array($values) && $field == 'created_at') {
				$constraints = [];
				foreach ($values as $value) {
					$constraints[] = FilterableConstraint::make($value);
				}

				return $constraints;
			}
			else if (is_array($values)) {
				$string = implode(',', $values);
				$constraints = FilterableConstraint::make($string);

				return $constraints;
			}
			else {
				return FilterableConstraint::make($values);
			}
		}

		/**
		 * Apply a single constraint - either directly or using model's interceptor
		 *
		 * @param Builder              $builder    query builder
		 * @param string               $field      field name
		 * @param FilterableConstraint $constraint constraint
		 * @param string               $mode       determines how constraint is applied ("or" or "and")
		 */
		protected function applyConstraint(Builder $builder, $field, $constraint, $mode = FilterableConstraint::MODE_AND)
		{
			// let model handle the constraint if it has the interceptor
			if (!$this->callInterceptor($builder, $field, $constraint)) {
				$constraint->apply($builder, $field, $mode);
			}
		}

		/**
		 * Determines how constraints are applied ("or" or "and")
		 *
		 * @param array $query query parameters
		 *
		 * @return mixed
		 */
		protected function getQueryMode(array $query = [])
		{
			return array_get($query, $this->getQueryModeParameterName(), FilterableConstraint::MODE_AND);
		}

		/**
		 * @param Builder $builder
		 *
		 * @return array list of searchable attributes
		 */
		protected function _getSearchableAttributes(Builder $builder)
		{
			if (method_exists($builder->getModel(), 'getSearchableAttributes')) {
				return $builder->getModel()->getSearchableAttributes();
			}

			if (property_exists($builder->getModel(), 'fillable')) {
				return $builder->getModel()->fillable;
			}

			throw new RuntimeException(sprintf('Model %s must either implement getSearchableAttributes() or have $searchable property set', get_class($builder->getModel())));
		}


		protected function setContextToQuery(Builder $builder)
		{

			// get the user profile to set the context of query.

			$userProfile = Session::get('currentUser');

			/** Dirty Fixings Only for the result to obtain should make and interface to arrange the data */

			// IF THE USER IS DSE PROVIDE HIS/HER ROUTE
			// IF the model has users and user group is 9 should be DSE.
			if ($userProfile['user_group'] == 9) {

				$userId = $userProfile['user_id'];

				if (method_exists($builder->getModel(), 'users')) {

					$builder->whereHas('users', function ($q) use ($userId) {
						$q->where('user_id', $userId);
					});
				}
			}


			// Business Unit.
			// If the model is itself  business unit. get the query
			if (count($userProfile['business_unit_id'])) {
				$business_unit_id = (explode(',', $userProfile['business_unit_id']));
				if ($builder->getModel()->table == 'business_unit') {
					$builder->whereIn('id_business_unit', $business_unit_id);
				}
			}


			if (count($userProfile['business_unit_id'])) {

				$business_unit_id = (explode(',', $userProfile['business_unit_id']));

				if (method_exists($builder->getModel(), 'businessUnit')) {

					$builder->whereHas('businessUnit', function ($q) use ($business_unit_id) {
						$q->whereIn('id_business_unit', $business_unit_id);
					});
				}
			}


			// Business Unit.
			// If the model is itself  distributor unit. get the query
			if (count($userProfile['distributor_id'])) {
				$distributor_id = (explode(',', $userProfile['distributor_id']));
				if ($builder->getModel()->table == 'distributor') {
					$builder->whereIn('id_distributor', $distributor_id);
				}
			}


			if (count($userProfile['distributor_id'])) {
				$distributor_id = explode(',', $userProfile['distributor_id']);

				if (method_exists($builder->getModel(), 'distributor')) {

					$tableName = $builder->getModel()->getTable();
					$builder->whereHas('distributor', function ($q) use ($distributor_id, $tableName) {
						$q->whereIn($tableName . '.distributor_id', $distributor_id);
					});
				}
			}


			if (count($userProfile['town_id'])) {
				$town_id = explode(',', $userProfile['town_id']);

				if (method_exists($builder->getModel(), 'town')) {

					$tableName = $builder->getModel()->getTable();
					$builder->whereHas('town', function ($q) use ($town_id, $tableName) {
						$q->whereIn($tableName . '.town_id', $town_id);
					});
				}
			}


			// set other queries here.
			/*
			 * Its only the task to be done.
			 *
			 *
			 */

			return $builder;
		}


	}
