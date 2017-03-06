<?php

	namespace Modules\Dashboard\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class RouteProductivityAgg extends BaseModel implements RouteProductivityAggInterface
	{
		/**
		 * `id`,
		 * `retail_outlet_id`,
		 * `town_id`,
		 * `route_id`,
		 * `user_id`,
		 * `distributor_id`,
		 * `business_unit_id`,
		 * `dse_route`,
		 * `call_made`,
		 * `sucessful_call`,
		 * `unsucessful_call`,
		 * `transaction_dt`,
		 * `created_at`,
		 * `phone_order`,
		 * `no_order_reason`
		 * */


		/**
		 * @var RouteProductivityToday Database Table
		 */
		protected $table = 'rpt_route_productivity_agg';
		/**
		 * @var rpt_route_productivity_agg Database Table Primary key
		 */
		protected $primaryKey = 'id';
		/*
		* @var array()
		*/

		protected $fillable = ['id',
			'retail_outlet_id',
			'town_id',
			'route_id',
			'user_id',
			'distributor_id',
			'business_unit_id',
			'dse_route',
			'call_made',
			'sucessful_call',
			'unsucessful_call',
			'transaction_dt',
			'created_at',
			'phone_order',
			'no_order_reason'];


		public function retail_outlet()
		{
			return $this->belongsTo('Modules\Sales\Entities\RetailOutlet');
		}


		public function user()
		{
			return $this->belongsTo('Modules\User\Entities\User');
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function distributor()
		{
			return $this->belongsTo('Modules\Configure\Entities\Distributor');////->select('distributor.id_distributor','distributor.title');
		}

		public function business_unit_id()
		{
			return $this->belongsTo('Modules\Configure\Entities\BusinessUnit');
		}

//    public function town()
//    {
//        return $this->belongsTo('Modules\Configure\Entities\Town');
//    }

		public function route()
		{
			return $this->belongsTo('Modules\Sales\Entities\Route');
		}

	}
