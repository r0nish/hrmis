<?php

	namespace Modules\Foundation\Database\Migration;

	use Illuminate\Database\Schema\Blueprint;

	class CustomBluePrint extends Blueprint
	{
		public function authors()
		{
			$this->integer('created_by')->unsigned()->nullable();
			$this->integer('updated_by')->unsigned()->nullable();

			$this->foreign('created_by')->references('id_user')->on('user')->onDelete('set null');
			$this->foreign('updated_by')->references('id_user')->on('user')->onDelete('set null');
		}
	}
