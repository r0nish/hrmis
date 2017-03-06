<?php

	namespace Modules\Dashboard\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class ActiveRouteToday extends BaseModel implements ActiveRouteTodayInterface
	{

		/**
		 * 'route_id',
		 * 'dse_route',
		 * distributor_id
		 * business_unit_id
		 * 'schedule_call',
		 * 'call_made',
		 * 'successfull_call',
		 * 'call_not_performed',
		 * 'transaction_dt'
		 * */


		/**
		 * @var RouteProductivityToday Database Table
		 */
		protected $table = 'rpt_active_route_today';
		/**
		 * @var active_route_today Database Table Primary key
		 */
		protected $primaryKey = 'route_id';
		/*
		* @var array()
		*/

		protected $fillable = ['route_id', 'dse_route', 'distributor_id', 'business_unit_id', 'schedule_call', 'call_made', 'successfull_call', 'call_not_performed', 'transaction_dt'];


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
