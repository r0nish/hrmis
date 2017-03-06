<?php

	use Modules\CustomMigration;
	use Modules\CustomBluePrint;

	class CreateUserGeographicLocationTable extends CustomMigration
	{
		/**
		 * Run the migrations.
		 */
		public function up()
		{
			$this->schema->create('user_geographic_location', function (CustomBluePrint $table) {
				$table->increments('id_user_geographic_location');
				$table->integer('user_id')->unsigned();
				$table->integer('geographic_location_id')->unsigned();
				$table->tinyInteger('status');
				$table->authors();
				$table->timestamps();

				$table->foreign('user_id')->references('id_user')->on('user');
				$table->foreign('geographic_location_id')->references('id_geographic_location')->on('geographic_location');
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			Schema::drop('user_geographic_location');
		}
	}
