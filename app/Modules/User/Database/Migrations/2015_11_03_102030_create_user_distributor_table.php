<?php

	use Modules\CustomMigration;
	use Modules\CustomBluePrint;

	class CreateUserDistributorTable extends CustomMigration
	{
		/**
		 * Run the migrations.
		 */
		public function up()
		{
			$this->schema->create('user_distributor', function (CustomBluePrint $table) {
				$table->increments('id_user_distributor');
				$table->integer('user_id')->unsigned();
				$table->integer('distributor_id')->unsigned();
				$table->tinyInteger('status');
				$table->authors();
				$table->timestamps();

				$table->foreign('user_id')->references('id_user')->on('user');
				$table->foreign('distributor_id')->references('id_distributor')->on('distributor');
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			Schema::drop('user_distributor');
		}
	}
