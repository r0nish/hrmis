<?php

	use Modules\CustomMigration;
	use Modules\CustomBluePrint;

	class CreateUserSessionTable extends CustomMigration
	{
		/**
		 * Run the migrations.
		 */
		public function up()
		{
			$this->schema->create('user_session', function (CustomBluePrint $table) {
				$table->increments('id_user_session');
				$table->integer('user_id')->unsigned();
				$table->string('token', 90);
				$table->string('latitude');
				$table->string('longitude');
				$table->timestamp('expired_on');
				$table->authors();
				$table->timestamps();
			});

			$this->schema->table('user_session', function (CustomBluePrint $table) {
				$table->foreign('user_id')->references('id_user')->on('user');
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			Schema::drop('user_session');
		}
	}
