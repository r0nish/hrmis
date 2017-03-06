<?php

	namespace App\Modules\Foundation\Entities;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\Session;
	use App\Modules\Traits\Filterable;

	class BaseModel extends Model
	{
		use Filterable;

		public static function boot()
		{
			parent::boot();

			$currentUser = Session::get('currentUser');
			$userId = $currentUser['user_id'];

			static::creating(function ($model) use ($userId) {
				$model->created_by = $userId;
			});

			static::updating(function ($model) use ($userId) {
				$model->updated_by = $userId;
			});

		}

		public function creator()
		{
			return $this->belongsTo('Modules\User\Entities\User', 'created_by', 'id');
		}

		public function updater()
		{
			return $this->belongsTo('Modules\User\Entities\User', 'updated_by', 'id');
		}


		public function findById($id)
		{
			return $this->find($id);
		}


	}
