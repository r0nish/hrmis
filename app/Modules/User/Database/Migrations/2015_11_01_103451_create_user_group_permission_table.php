<?php

	use Modules\CustomBluePrint;

	class CreateUserGroupPermissionTable extends \Modules\CustomMigration
	{
		/**
		 * Run the migrations.
		 */
		public function up()
		{
			$this->schema->create('user_group_permission', function (CustomBluePrint $table) {
				$table->increments('id_user_group_permission');
				$table->integer('user_group_id')->unsigned();
				$table->integer('permission_id')->unsigned();
				$table->tinyInteger('status');
				$table->text('module');
				$table->authors();
				$table->timestamps();
			});

			$this->schema->table('user_group_permission', function (CustomBluePrint $table) {
				$table->foreign('user_group_id')->references('id_user_group')->on('user_group');
				$table->foreign('permission_id')->references('id_permission')->on('permission');
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			Schema::drop('user_permission');
		}
	}
