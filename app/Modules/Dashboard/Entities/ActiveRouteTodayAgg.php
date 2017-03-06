<?php

	namespace Modules\Dashboard\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class ActiveRouteTodayAgg extends BaseModel implements ActiveRouteTodayInterfaceAgg
	{

		/**
		 * `id`,
		 * `route_id`,
		 * `town_id`,
		 * `dse_route`,
		 * `distributor_id`,
		 * `business_unit_id`,
		 * `schedule_call`,
		 * `call_made`,
		 * `successfull_call`,
		 * `call_not_performed`,
		 * `transaction_dt`,
		 * `created_at`,
		 * `phone_order`
		 **/


		/**
		 * @var RouteProductivityToday Database Table
		 */
		protected $table = 'rpt_active_route_agg';
		/**
		 * @var rpt_active_route_agg Database Table Primary key
		 */
		protected $primaryKey = 'id';
		/*
		* @var array()
		*/

		protected $fillable = [
			'id',
			'route_id',
			'town_id',
			'dse_route',
			'distributor_id',
			'business_unit_id',
			'schedule_call',
			'call_made',
			'successfull_call',
			'call_not_performed',
			'transaction_dt',
			'created_at',
			'phone_order'
		];


		public function user()
		{
			return $this->belongsTo('Modules\User\Entities\User');
		}


		public function route()
		{
			return $this->belongsTo('Modules\Sales\Entities\Route');
		}

		public function distributor()
		{
			return $this->belongsTo('Modules\Configure\Entities\Distributor');////->select('distributor.id_distributor','distributor.title');
		}

		public function business_unit_id()
		{
			return $this->belongsTo('Modules\Configure\Entities\BusinessUnit');
		}
	}
