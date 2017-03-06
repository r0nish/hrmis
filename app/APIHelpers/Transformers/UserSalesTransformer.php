<?php

	namespace App\APIHelpers\Transformers;

	class UserSalesTransformer extends Transformer
	{
		public function transform($userSales, $permission)
		{
			return 1;
			/*if(!empty($userSales['sales_representative_distributor_user'])){
				return 'ttt';
			}*/
		}
	}
