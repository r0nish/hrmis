<?php

	namespace Modules\Dashboard\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class SalesProductivityToday extends BaseModel implements SalesProductivityTodayInterface
	{

		/***
		 *
		 *'retail_outlet_id',
		 * 'sku_id',
		 * 'town_id',
		 * 'route_id',
		 * 'user_id',
		 * distributor_id
		 * business_unit_id
		 * 'qty',
		 * 'order_received',
		 * 'order_invoiced',
		 * 'transaction_dt',
		 * 'productivity'
		 * */


		/**
		 * @var RouteProductivityToday Database Table
		 */
		protected $table = 'rpt_sales_productivity_today';
		/**
		 * @var rpt_sales_productivity_today Database Table Primary key
		 */
		protected $primaryKey = ['retail_outlet_id', 'sku_id'];
		/*
		* @var array()
		*/

		protected $fillable = [
			'retail_outlet_id',
			'sku_id',
			'town_id',
			'route_id',
			'user_id',
			'distributor_id',
			'business_unit_id',
			'qty',
			'order_received',
			'order_invoiced',
			'transaction_dt',
			'productivity'
		];


		public function retail_outlet()
		{
			return $this->belongsTo('Modules\Sales\Entities\RetailOutlet');
		}

		public function user()
		{
			return $this->belongsTo('Modules\User\Entities\User');
		}

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
