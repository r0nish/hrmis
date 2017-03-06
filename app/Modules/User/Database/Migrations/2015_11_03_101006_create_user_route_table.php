<?php

	use Modules\CustomMigration;
	use Modules\CustomBluePrint;

	class CreateUserRouteTable extends CustomMigration
	{
		/**
		 * Run the migrations.
		 */
		public function up()
		{
			$this->schema->create('user_route', function (CustomBluePrint $table) {
				$table->increments('id_user_route');
				$table->integer('user_id')->unsigned();
				$table->integer('route_id')->unsigned();
				$table->tinyInteger('status');
				$table->authors();
				$table->timestamps();

				$table->foreign('user_id')->references('id_user')->on('user');
				$table->foreign('route_id')->references('id_route')->on('route');
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			Schema::drop('user_route');
		}
	}
