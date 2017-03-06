<?php
	namespace App\Modules\Traits;

	use App\User;
	use ClassPreloader\Config;
	use Illuminate\Support\Facades\Auth;

	trait HandleOwnerTrait
	{

		public static function boot()
		{
			parent::boot();
			static::creating(function ($model) {
				$user = Auth::user();
				$model->created_by = $user->id;
				$model->updated_by = $user->id;
			});
			static::updating(function ($model) {
				$user = Auth::user();
				$model->updated_by = $user->id;
			});
		}

		/**
		 * This is owned by a user
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user()
		{
			return $this->belongsTo(User::class, 'created_by');
		}
	}
