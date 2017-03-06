<?php

	namespace Modules\Dashboard\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class RouteProductivityToday extends BaseModel implements RouteProductivityTodayInterface
	{
		/***
		 *
		 * 'retail_outlet_id',
		 * 'town_id',
		 * 'route_id',
		 * 'user_id',
		 * distributor_id,
		 * business_unit_id,
		 * 'dse_route',
		 * 'call_made',
		 * 'sucessful_call',
		 * 'unsucessful_call',
		 * 'transaction_dt'
		 * */


		/**
		 * @var RouteProductivityToday Database Table
		 */
		protected $table = 'rpt_route_productivity_today';
		/**
		 * @var rpt_route_productivity_today Database Table Primary key
		 */
		protected $primaryKey = 'retail_outlet_id';
		/*
		* @var array()
		*/

		protected $fillable = ['retail_outlet_id',
			'town_id',
			'route_id',
			'user_id',
			'distributor_id',
			'business_unit_id',
			'dse_route',
			'call_made',
			'sucessful_call',
			'unsucessful_call',
			'transaction_dt'];


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
